<?php
namespace App\Lib\Validation;

use Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Helpers\ConstantHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator as ValidationValidator;

class User {
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function store() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => ['required','string','max:99'],
            'email' => ['required','string','email','max:99','unique:users,email'],
            'mobile' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/','unique:users', 'between:'.ConstantHelper::MOBILE_MIN_LENGTH.','.ConstantHelper::MOBILE_MAX_LENGTH],
            'gender' => ['nullable','string'], 
            'department_id' => ['nullable','string'], 
            'password' => ['required','string','min:6'],
            'password_confirmation' => 'required_with:password|same:password|min:6', 
           // 'g-recaptcha-response' => 'required|captcha',
        ]);

        return $validator;
    }

    public function update() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => ['required','string','max:99'],
            'email' => [
                'required',
                'string',
                'email',
                'max:99',
                Rule::unique('users','email')
                    ->ignore($this->request->id,'id')
            ],
            'mobile' => [
                'required', 
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'between:'.ConstantHelper::MOBILE_MIN_LENGTH.','.ConstantHelper::MOBILE_MAX_LENGTH,
                Rule::unique('users','mobile')
                    ->ignore($this->request->id,'id')
            ],
            'gender' => ['nullable','string'],
            'department_id' => ['nullable','string'],
            'password' => ['required','string','min:6'],
            'password_confirmation' => 'required_with:password|same:password|min:6',
        ]);

        return $validator;
    }

    public function updateUserAccount() : ValidationValidator
    {
        $auth = \Auth::user();
        $validator = Validator::make($this->request->all(),[
            'name' => ['required','string','max:99'],
            'email' => [
                'required',
                'string',
                'email',
                'max:99',
                Rule::unique('users','email')
                    ->ignore($auth->id,'id')
            ],
            'mobile' => [
                'required', 
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'between:'.ConstantHelper::MOBILE_MIN_LENGTH.','.ConstantHelper::MOBILE_MAX_LENGTH,
                Rule::unique('users','mobile')
                    ->ignore($auth->id,'id')
            ],  
            // 'currency_id' => ['required', 'integer', Rule::exists('currency', 'id')], 
        ]);
        return $validator;
    }


    public function userChangePassword() : ValidationValidator
    {
        $auth = \Auth::user();
        $validator = Validator::make($this->request->all(),[
            'old_password' => [
                'required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('Old Password didn\'t match');
                    }
                },
            ],

            'new_password' => [
                'required',
                'min:8',
                'same:confirm_password'
            ],

            'confirm_password' => [
                'required',
                'min:8',
                'same:new_password'
            ],
            
             
        ]);
        return $validator;
    }

    public function userAddress() : ValidationValidator
    {
        $auth = \Auth::user();
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'max:180'
            ],
            'mobile' => [
                'required',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'between:'.ConstantHelper::MOBILE_MIN_LENGTH.','.ConstantHelper::MOBILE_MAX_LENGTH,
            ],
            'postal_code' => [
                'required',
                'numeric',
                'max:180'
            ],
            'locality' => [
                'required',
                'max:180'
                
            ],
            'address' => [
                'required',
                'max:180'
                
            ],
            'city' => [
                'required',
                'max:180'
                
            ],
            'state_id' => [
                'required',
                'numeric',
                'max:180'
                
            ],
            'landmark' => [
                'nullable',
                'max:180'
                
            ],
            'alternate_mobile' => [
                'nullable',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'between:'.ConstantHelper::MOBILE_MIN_LENGTH.','.ConstantHelper::MOBILE_MAX_LENGTH,
                
            ],
            'type' => [
                'required',
                'max:180'
                
            ],
        ]);
        return $validator;
    }
   
    public function userShippingDetail() : ValidationValidator
    {
        $auth = \Auth::user();
        $validator = Validator::make($this->request->all(),[
            'line_1' => [
                'required',
                'max:180'
            ],
            'line_2' => [
                'nullable',
                'max:180'
            ],
            'country_id' => [
                'required',
            ],
            'district' => [
                'required',
                
            ],
            'postal_code' => [
                'required',
                
            ],
        ]);
        return $validator;
    }

    public function userBillingDetail() : ValidationValidator
    {
        $auth = \Auth::user();
        $validator = Validator::make($this->request->all(),[
            'line_1' => [
                'required',
                'max:180'
            ],
            'line_2' => [
                'nullable',
                'max:180'
            ],
            'country_id' => [
                'required',
            ],
            'district' => [
                'required',
                
            ],
            'postal_code' => [
                'required',
                
            ],
        ]);
        return $validator;
    }

    public function checkoutbillingShippingAddress() : ValidationValidator
    {
        $auth = \Auth::user();

        $validator = Validator::make($this->request->all(),[
            
            'shipping_name' => [
                'required',
                'string',
                'max:99'
            ],
            'shipping_email' => [
                'required',
                'string',
                'email',
                'max:99'
            ],
            'shipping_mobile' => [
                'required', 
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'between:'.ConstantHelper::MOBILE_MIN_LENGTH.','.ConstantHelper::MOBILE_MAX_LENGTH,
            ],
            'shipping_address_line_1' => [
                'required',
                'max:180'
            ],
            'shipping_address_line_2' => [
                'nullable',
                'max:180'
            ],
            'shipping_country_id' => [
                'required',
            ],
            'shipping_state_id' => [
                'required',
            ],
            'shipping_city_id' => [
                'required',
            ],
            'shipping_postal_code' => [
                'required',
            ],

            'billing_name' => [
                'required',
                'string',
                'max:99'
            ],
            'billing_email' => [
                'required',
                'string',
                'email',
                'max:99'
            ],
            'billing_mobile' => [
                'required', 
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'between:'.ConstantHelper::MOBILE_MIN_LENGTH.','.ConstantHelper::MOBILE_MAX_LENGTH,
            ],
            'billing_address_line_1' => [
                'required',
                'max:180'
            ],
            'billing_address_line_2' => [
                'nullable',
                'max:180'
            ],
            'billing_country_id' => [
                'required',
            ],
            'billing_state_id' => [
                'required',
            ],
            'billing_city_id' => [
                'required',
            ],
            'billing_postal_code' => [
                'required',
            ],
        ]);
        return $validator;
    }


    public function userAppointment() : ValidationValidator
    {
        $auth = \Auth::user();
        $validator = Validator::make($this->request->all(),[
            'date' => [
                'required'
            ],
            'timeslot' => [
                'required',
            ],
            
        ]);
        return $validator;
    }

    public function calendlyAppointment() : ValidationValidator
    {
        $auth = \Auth::user();
        $validator = Validator::make($this->request->all(),[
            'calendly_event' => [
                'required'
            ],
        ]);
        return $validator;
    }

    public function userCancelAppointment() : ValidationValidator
    {
        $auth = \Auth::user();
        $validator = Validator::make($this->request->all(),[
            'id' => [
                'required'
            ],
            'cancellation_reason' => [
                'required'
            ],
        ]);
        return $validator;
    }

}