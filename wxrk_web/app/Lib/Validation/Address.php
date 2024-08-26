<?php

namespace App\Lib\Validation;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Helpers\ConstantHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationValidator;

class Address
{
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function store(): ValidationValidator
    {
        $validator = Validator::make($this->request->all(), [
            'name' => ['required', 'max:100'],
            'email' => ['required', 'max:100'],
            'mobile' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'between:' . ConstantHelper::MOBILE_MIN_LENGTH . ',' . ConstantHelper::MOBILE_MAX_LENGTH],
            'line_1' => ['required', 'max:180'],
            'line_2' => ['nullable','max:180'],
            'country_id' => ['required', 'integer', Rule::exists('countries', 'id')],
            'state_id' => ['required', 'integer', Rule::exists('states', 'id')->where('country_id', $this->request->country_id)],
            'city_id' => ['required', 'integer', Rule::exists('cities', 'id')->where('state_id', $this->request->state_id)],
            'postal_code' => ['required', 'string', 'between:' . ConstantHelper::POSTAL_MIN_LENGTH . ',' . ConstantHelper::POSTAL_MAX_LENGTH],
            'type' => ['required', 'string', 'max:100'],
        ]);

        return $validator;
    }
}