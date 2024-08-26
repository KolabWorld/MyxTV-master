<?php

namespace App\Lib\Validation;

use Illuminate\Http\Request;
use App\Helpers\ConstantHelper;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationValidator;

class Auth
{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function register(): ValidationValidator
    {
        $validator = Validator::make($this->request->all(), [
            'first_name' => ['required', 'string', 'max:' . ConstantHelper::NAME_MAX_LENGTH],
            'last_name' => ['required', 'string', 'max:' . ConstantHelper::NAME_MAX_LENGTH],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users,email'],
            'mobile' => ['required', 'string', 'min:8', 'max:12', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'unique:users,mobile'],
            'role_id' => [
                'nullable',
                Rule::exists('roles', 'id')
            ],
            'password' => ['required', 'string', 'min:8'],
            'gender' => ['nullable', 'string', Rule::in(ConstantHelper::GENDER)],
            'date_of_birth' => ['nullable', 'date_format:Y-m-d', 'before:' . ConstantHelper::AGE_LIMIT . ' years ago'],
            'marital_status' => ['nullable', 'string', Rule::in(ConstantHelper::MARITAL_STATUS)]
        ]);

        return $validator;
    }

    public function login(): ValidationValidator
    {
        $validator = Validator::make($this->request->all(), [
            'username' => ['required', 'string', 'max:99'],
            'password' => ['required', 'string'],
            'client_id' => ['required', 'string'],
            'client_secret' => ['required', 'string', 'min:6'],
            'grant_type' => ['required', 'string', Rule::in(['password'])],
        ]);

        return $validator;
    }

    public function forgotPassword(): ValidationValidator
    {
        $validator = Validator::make($this->request->all(), [
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:99'],
        ]);

        return $validator;
    }
    
    public function sendOtp(): ValidationValidator
    {
        $validator = Validator::make($this->request->all(), 
            [
                'user_id' => [
                    'required', 
                    'integer',
                    'exists:users,id'
                ],
                'dial_code' => [
                    'required',
                    'string',
                    'exists:countries,dial_code'
                ],
                'mobile' => [
                    'required',
                    'string', 
                    'min:8', 
                    'max:12', 
                    'regex:/^([0-9\s\-\+\(\)]*)$/', 
                ],
                'email' => [
                    'required', 
                    'string', 
                    'email', 
                    'max:50',
                ],
            ]
        );

        return $validator;
    }

    public function verifyOtp(): ValidationValidator
    {
        $validator = Validator::make($this->request->all(), 
            [
                'user_id' => [
                    'required', 
                    'integer',
                    'exists:users,id'
                ],
                'otp' => [
                    'required',
                    'numeric',
                ],
            ],[
                'otp.required' => 'OTP field is required',
                'otp.numeric' => 'OTP must be a number',
            ]
        );

        return $validator;
    }

    public function resetPassword(): ValidationValidator
    {
        $validator = Validator::make($this->request->all(), [
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:99'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
            ],
            'password_confirmation' => 'required_with:password|same:password|min:8',
        ]);

        return $validator;
    }
}