<?php
namespace App\Lib\Validation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator as ValidationValidator;
use App\Helpers\ConstantHelper;

class UserProfile{
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function store() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => ['nullable','max:255'],
            'email' => ['nullable','max:255'],
            'mobile' => ['nullable', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'between:'.ConstantHelper::MOBILE_MIN_LENGTH.','.ConstantHelper::MOBILE_MAX_LENGTH],           
            'line_1' => ['nullable','max:2099'],
            'landmark' => [ 'max:2099'],
            'country_id' => ['nullable', 'integer', Rule::exists('countries', 'id')],
            'state_id' => ['nullable', 'integer', Rule::exists('states', 'id')->where('country_id',$this->request->country_id)],
            'city_id' => ['nullable', 'integer', Rule::exists('cities', 'id')->where('state_id', $this->request->state_id)],
            'postal_code' => ['nullable', 'string', 'between:'.ConstantHelper::POSTAL_MIN_LENGTH.','.ConstantHelper::POSTAL_MAX_LENGTH],            
        ]);
      
        return $validator;
    }
}