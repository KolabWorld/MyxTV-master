<?php
namespace App\Lib\Validation\Admin;

use Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Helpers\ConstantHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator as ValidationValidator;

class DesiginerAccountSetting {
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function updateAccountDetail() : ValidationValidator
    {
        
        $designer_id = $this->request->designer_id;

        $validator = Validator::make($this->request->all(),[
            'name' => [
                'nullable',
                'string',
                'max:291'
            ],
            'email' => [
                'nullable',
                'string',
                'email',
                'max:99',
                Rule::unique('designers','email')
                    ->ignore($designer_id,'id')
            ],
            'mobile' => [
                'nullable', 
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'between:'.ConstantHelper::MOBILE_MIN_LENGTH.','.ConstantHelper::MOBILE_MAX_LENGTH,
                Rule::unique('designers','mobile')
                    ->ignore($designer_id,'id')
            ],  
            'currency_id' => [
                'nullable', 
                'integer', 
                Rule::exists('currency', 'id')
            ], 
            
             
        ]);

        return $validator;
    }



    public function updateAboutMe() : ValidationValidator
    {
        
        $validator = Validator::make($this->request->all(),[
             
            'about_me' => [
                'required'
            ], 
             
        ]);

        return $validator;
    }

    public function AverageCostLeadTime() : ValidationValidator
    {
        

        $validator = Validator::make($this->request->all(),[
            
            'consultation_fee' => [
                'required', 
                'regex:/^([0-9\s\-\+\(\)]*)$/'
            ], 
            'avg_lead_time' => [
                'required',
                'numeric'
            ], 
             
        ]);

        return $validator;
    }




    public function changePassword() : ValidationValidator
    {
        $auth = \Auth::guard('designer')->user();

        $validator = Validator::make($this->request->all(),[
            'old_password' => [
                'required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::guard('designer')->user()->password)) {
                        $fail('Old Password didn\'t match');
                    }
                },
            ],
            'new_password' => [
                'required',
                'min:8',
            ],
            'confirm_password' => [
                'required',
                'min:8',
                'same:new_password'
            ],
        ]);
        return $validator;
    }

    public function updateBankAccountDetail() : ValidationValidator
    {
        
        $validator = Validator::make($this->request->all(),[
            'bank_name' => [
                'required',
                'string',
                'max:291'
            ],
            'account_number' => [
                'required',
                'regex:/^([0-9\s\-\+\(\)]*)$/'
            ],
            'iban_code' => [
                'required',
                'string',
                'max:91'
            ],
            'swift_code' => [
                'required',
                'string',
                'max:91'
            ]
        ]);
        return $validator;
    }

}