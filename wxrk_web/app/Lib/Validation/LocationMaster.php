<?php
namespace App\Lib\Validation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator as ValidationValidator;

use App\Helpers\ConstantHelper;

class LocationMaster {
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function storeCountry() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'max:199',
                'unique:countries,name'
            ],
            'code' => [
                'required',
                'string',
                'max:199',
                'unique:countries,code'
            ],
            'dial_code' => [
                'required',
                'string',
                'max:199',
                'unique:countries,dial_code'
            ], 
        ]);

        return $validator;
    }

    public function updateCountry() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'max:199',
                Rule::unique('countries','name')
                    ->ignore($this->request->id,'id')
            ],
            'code' => [
                'required',
                'string',
                'max:199',
                Rule::unique('countries','code')
                    ->ignore($this->request->id,'id')
            ], 
            'dial_code' => [
                'required',
                'string',
                'max:199',
                Rule::unique('countries','dial_code')
                    ->ignore($this->request->id,'id')
            ], 
        ]);

        return $validator;
    }

    public function storeState() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'max:199',
                'unique:states,name'
            ],
            'country_id' => [
                'required',
                'string',
                'max:100'
            ],
        ]);

        return $validator;
    }

    public function updateState() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'max:199',
                Rule::unique('states','name')
                    ->ignore($this->request->id,'id')
            ],
            'country_id' => [
                'required',
                'string',
                'max:100'
            ],
        ]);

        return $validator;
    }

    public function storeCity() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'max:199',
                'unique:cities,name'
            ],
            'country_id' => [
                'required',
                'string',
                'max:199'
            ], 
            'state_id' => [
                'required',
                'string',
                'max:199'
            ],
        ]);

        return $validator;
    }

    public function updateCity() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'max:199',
                Rule::unique('cities','name')
                    ->ignore($this->request->id,'id')
            ],
            'country_id' => [
                'required',
                'string',
                'max:199'
            ], 
            'state_id' => [
                'required',
                'string',
                'max:199'
            ],
        ]);

        return $validator;
    }

}