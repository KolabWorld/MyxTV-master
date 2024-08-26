<?php

namespace App\Lib\Validation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationValidator;

class PasswordReset
{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function forgotPassword(): ValidationValidator
    {
        $validator = Validator::make($this->request->all(), [
            'email' => ['nullable', 'email', 'max:90'],
            'mobile' => [
                'required_without:email', 'nullable', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:8'
            ],
        ]);

        return $validator;
    }

    public function verifyResetPassword(): ValidationValidator
    {
        $validator = Validator::make($this->request->all(), [
            'token' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed', 'min:8']
        ]);

        return $validator;
    }

    public function verifyOtpPassword(): ValidationValidator
    {
        $validator = Validator::make($this->request->all(), [
            'otp' => ['digits_between:6,6', 'numeric'],
            'mobile' => ['required_without:email', 'string', 'min:8', 'regex:/^([0-9\s\-\+\(\)]*)$/']
        ]);

        return $validator;
    }
}