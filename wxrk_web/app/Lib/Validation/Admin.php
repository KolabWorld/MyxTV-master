<?php

namespace App\Lib\Validation;

use Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Helpers\ConstantHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Validator as ValidationValidator;

class Admin
{
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function store(): ValidationValidator
    {
        $validator = Validator::make($this->request->all(), [
            "company_name" => [
                'required',
                'regex:/^[A-Za-z .]+$/',
                // 'regex:/^[A-Z]([a-zA-Z0-9]|[- @\.#&!])*$/',
                'string',
                'max:199',
            ],
            "email" => [
                'required',
                'string',
                'email',
                'max:199',
                Rule::unique('admins', 'email'),
            ],
            "mobile" => [
                'required',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                Rule::unique('admins', 'mobile'),
                'between:' . ConstantHelper::MOBILE_MIN_LENGTH . ',' . ConstantHelper::MOBILE_MAX_LENGTH
            ],
            "company_website" => [
                'required',
                'regex:/^((https?|ftp|smtp):\/\/)?(www.)?[a-z0-9]+\.[a-z]+(\/[a-zA-Z0-9#]+\/?)*$/',
                'string',
                'max:199'
            ],
            "contact_person_name" => [
                'required',
                'regex:/^[A-Za-z ]+$/',
                'string',
                'max:199'
            ],
            "alternate_contact_number" => [
                'nullable',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'between:' . ConstantHelper::MOBILE_MIN_LENGTH . ',' . ConstantHelper::MOBILE_MAX_LENGTH
            ],
            "alternate_email" => [
                'nullable',
                'email',
                'string',
                'max:199'
            ],
            "business_category_id" => [
                'required',
                'integer',
                'exists:business_categories,id'
            ],
            "country_id" => [
                'required',
                'integer',
                'exists:countries,id'
            ],
            "state_id" => [
                'required',
                'integer',
                'exists:states,id'
            ],
            "city_id" => [
                'required',
                'integer',
                'exists:cities,id'
            ],
            "postal_code" => [
                'required',
                'regex:/^([0-9\s\(\)]*)$/',
                'max:10'
            ],
            "address" => [
                'required',
                'string',
                'max:299'
            ],
            "who_we_are" => [
                'nullable',
                'string',
                'max:499'
            ],
            'status' => [
                'nullable',
                'string',
                'max:99'
            ],
            'origins' => [
                'nullable',
                'array',
            ],
            'origins.*' => [
                'nullable',
                'exists:origins,id',
            ],
            'logo' => [
                'required',
                'file',
                'mimes:png,jpeg,jpg',
                'max:1024'
            ],
            'image' => [
                'nullable',
                'file',
                'mimes:png,jpeg,jpg',
                'max:1024'
            ],
        ]);

        return $validator;
    }

    public function update(): ValidationValidator
    {
        $rules = [
            "company_name" => [
                'required',
                'regex:/^[A-Za-z .]+$/',
                // 'regex:/^[A-Z]([a-zA-Z0-9]|[- @\.#&!])*$/',
                'string',
                'max:199',
            ],
            "email" => [
                'nullable',
                'string',
                'email',
                'max:199',
                Rule::unique('admins', 'email')
                    ->ignore($this->request->id, 'id')
                    ->whereNull('deleted_at'),
            ],
            "mobile" => [
                'required',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                Rule::unique('admins', 'mobile')
                    ->ignore($this->request->id, 'id')
                    ->whereNull('deleted_at'),
                'between:' . ConstantHelper::MOBILE_MIN_LENGTH . ',' . ConstantHelper::MOBILE_MAX_LENGTH
            ],
            "company_website" => [
                'required',
                'regex:/^((https?|ftp|smtp):\/\/)?(www.)?[a-z0-9]+\.[a-z]+(\/[a-zA-Z0-9#]+\/?)*$/',
                'string',
                'max:199'
            ],
            "contact_person_name" => [
                'required',
                'regex:/^[A-Za-z ]+$/',
                'string',
                'max:199'
            ],
            "alternate_contact_number" => [
                'nullable',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'between:' . ConstantHelper::MOBILE_MIN_LENGTH . ',' . ConstantHelper::MOBILE_MAX_LENGTH
            ],
            "alternate_email" => [
                'nullable',
                'email',
                'string',
                'max:199'
            ],
            "business_category_id" => [
                'required',
                'integer',
                'exists:business_categories,id'
            ],
            "country_id" => [
                'required',
                'integer',
                'exists:countries,id'
            ],
            "state_id" => [
                'required',
                'integer',
                'exists:states,id'
            ],
            "city_id" => [
                'required',
                'integer',
                'exists:cities,id'
            ],
            "postal_code" => [
                'required',
                'regex:/^([0-9\s\(\)]*)$/',
                'max:10'
            ],
            "address" => [
                'required',
                'string',
                'max:299'
            ],
            "who_we_are" => [
                'nullable',
                'string',
                'max:499'
            ],
            'status' => [
                'nullable',
                'string',
                'max:99'
            ],
            'origins' => [
                'nullable',
                'array',
            ],
            'origins.*' => [
                'nullable',
                'exists:origins,id',
            ],
            'logo' => [
                'nullable',
                'file',
                'mimes:png,jpeg,jpg',
                'max:1024'
            ],
            'image' => [
                'nullable',
                'file',
                'mimes:png,jpeg,jpg',
                'max:1024'
            ],
        ];

        if($this->request->new_password || $this->request->confirm_password){

            $rules['new_password'] = [
                'nullable',
                'min:8',
                'same:confirm_password'
            ];

            $rules['confirm_password'] = [
                'required_if:new_password,!=,""',
                'min:8',
                'same:new_password'
            ];
        }

        $validator = Validator::make($this->request->all(), $rules);

        return $validator;
    }

    public function updateAdmin(): ValidationValidator
    {

        $rules = [
            "company_name" => [
                'nullable',
                'regex:/^[A-Za-z .]+$/',
                // 'regex:/^[A-Z]([a-zA-Z0-9]|[- @\.#&!])*$/',
                'string',
                'max:199',
            ],
            "email" => [
                'nullable',
                'string',
                'email',
                'max:199',
                Rule::unique('admins', 'email')
                    ->ignore($this->request->id, 'id')
                    ->whereNull('deleted_at'),
            ],
            "mobile" => [
                'required',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                Rule::unique('admins', 'mobile')
                    ->ignore($this->request->id, 'id')
                    ->whereNull('deleted_at'),
                'between:' . ConstantHelper::MOBILE_MIN_LENGTH . ',' . ConstantHelper::MOBILE_MAX_LENGTH
            ],
            "company_website" => [
                'nullable',
                'regex:/^((https?|ftp|smtp):\/\/)?(www.)?[a-z0-9]+\.[a-z]+(\/[a-zA-Z0-9#]+\/?)*$/',
                'string',
                'max:199'
            ],
            "contact_person_name" => [
                'required',
                'regex:/^[A-Za-z ]+$/',
                'string',
                'max:199'
            ],
            "alternate_contact_number" => [
                'nullable',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'between:' . ConstantHelper::MOBILE_MIN_LENGTH . ',' . ConstantHelper::MOBILE_MAX_LENGTH
            ],
            "alternate_email" => [
                'nullable',
                'email',
                'string',
                'max:199'
            ],
            "business_category_id" => [
                'nullable',
                'integer',
                'exists:business_categories,id'
            ],
            "country_id" => [
                'nullable',
                'integer',
                'exists:countries,id'
            ],
            "state_id" => [
                'nullable',
                'integer',
                'exists:states,id'
            ],
            "city_id" => [
                'nullable',
                'integer',
                'exists:cities,id'
            ],
            "postal_code" => [
                'nullable',
                'regex:/^([0-9\s\(\)]*)$/',
                'max:10'
            ],
            "address" => [
                'nullable',
                'string',
                'max:299'
            ],
            "who_we_are" => [
                'nullable',
                'string',
                'max:499'
            ],
            'status' => [
                'nullable',
                'string',
                'max:99'
            ],
            'origins' => [
                'nullable',
                'array',
            ],
            'origins.*' => [
                'nullable',
                'exists:origins,id',
            ],
            'logo' => [
                'nullable',
                'file',
                'mimes:png,jpeg,jpg',
                'max:1024'
            ],
            'image' => [
                'nullable',
                'file',
                'mimes:png,jpeg,jpg',
                'max:1024'
            ]
        ];

        if($this->request->new_password || $this->request->confirm_password){

            $rules['new_password'] = [
                'nullable',
                'min:8',
                'same:confirm_password'
            ];

            $rules['confirm_password'] = [
                'required_if:new_password,!=,""',
                'min:8',
                'same:new_password'
            ];
        }

        $validator = Validator::make($this->request->all(), $rules);

        return $validator;
    }

    public function userChangePassword(): ValidationValidator
    {
        $auth = \Auth::user();
        $validator = Validator::make($this->request->all(), [
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
            ],
            'confirm_password' => [
                'required',
                'min:8',
                'same:new_password'
            ],


        ]);
        return $validator;
    }

    public function userAddress(): ValidationValidator
    {
        $auth = \Auth::user();
        $validator = Validator::make($this->request->all(), [
            'name' => [
                'required',
                'regex:/^[A-Za-z ]+$/',
                'max:180'
            ],
            'mobile' => [
                'required',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'between:' . ConstantHelper::MOBILE_MIN_LENGTH . ',' . ConstantHelper::MOBILE_MAX_LENGTH,
            ],
            'postal_code' => [
                'required',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'max:10'
            ],
            'locality' => [
                'required',
                'regex:/^[A-Za-z ]+$/',
                'max:180'

            ],
            'address' => [
                'required',
                'regex: /^[0-9A-Za-zÀ-ÿ\s,._+;()*~#@!?&-]+$/',
                'max:180'

            ],
            'city' => [
                'required',
                'regex:/^[A-Za-z ]+$/',
                'max:180'

            ],
            'state_id' => [
                'required',
                'numeric',
                'max:180'

            ],
            'landmark' => [
                'nullable',
                'regex: /^[0-9A-Za-zÀ-ÿ\s,._+;()*~#@!?&-]+$/',
                'max:180'

            ],
            'alternate_mobile' => [
                'nullable',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'between:' . ConstantHelper::MOBILE_MIN_LENGTH . ',' . ConstantHelper::MOBILE_MAX_LENGTH,

            ],
            'type' => [
                'required',
                'regex:/^[A-Za-z ]+$/',
                'max:180'

            ],
        ]);
        return $validator;
    }

    public function userShippingDetail(): ValidationValidator
    {
        $auth = \Auth::user();
        $validator = Validator::make($this->request->all(), [
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
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'max:10'
            ],
        ]);
        return $validator;
    }

    public function userBillingDetail(): ValidationValidator
    {
        $auth = \Auth::user();
        $validator = Validator::make($this->request->all(), [
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
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'max:10'
            ],
        ]);
        return $validator;
    }

    public function checkoutbillingShippingAddress(): ValidationValidator
    {
        $auth = \Auth::user();

        $validator = Validator::make($this->request->all(), [

            'shipping_name' => [
                'regex:/^[A-Za-z ]+$/',
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
                'between:' . ConstantHelper::MOBILE_MIN_LENGTH . ',' . ConstantHelper::MOBILE_MAX_LENGTH,
            ],
            'shipping_address_line_1' => [
                'required',
                'regex: /^[0-9A-Za-zÀ-ÿ\s,._+;()*~#@!?&-]+$/',
                'max:180'
            ],
            'shipping_address_line_2' => [
                'nullable',
                'regex: /^[0-9A-Za-zÀ-ÿ\s,._+;()*~#@!?&-]+$/',
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
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'required',
                'max:10'
            ],

            'billing_name' => [
                'regex:/^[A-Za-z ]+$/',
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
                'between:' . ConstantHelper::MOBILE_MIN_LENGTH . ',' . ConstantHelper::MOBILE_MAX_LENGTH,
            ],
            'billing_address_line_1' => [
                'required',
                'max:180'
            ],
            'billing_address_line_2' => [
                'nullable',
                'required',
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
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'required',
                'max:10'
            ],
        ]);
        return $validator;
    }


    public function userAppointment(): ValidationValidator
    {
        $auth = \Auth::user();
        $validator = Validator::make($this->request->all(), [
            'date' => [
                'required'
            ],
            'timeslot' => [
                'required',
            ],

        ]);
        return $validator;
    }

    public function calendlyAppointment(): ValidationValidator
    {
        $auth = \Auth::user();
        $validator = Validator::make($this->request->all(), [
            'calendly_event' => [
                'required'
            ],
        ]);
        return $validator;
    }

    public function userCancelAppointment(): ValidationValidator
    {
        $auth = \Auth::user();
        $validator = Validator::make($this->request->all(), [
            'id' => [
                'required'
            ],
            'cancellation_reason' => [
                'required'
            ],
        ]);
        return $validator;
    }


    public function updateUserAccount(): ValidationValidator
    {
        $auth = \Auth::user();
        $validator = Validator::make($this->request->all(), [
            "email" => [
                'nullable',
                'string',
                'email',
                'max:199',
                Rule::unique('users', 'email')
                    ->whereNull('deleted_at'),
            ],
            "mobile" => [
                'nullable',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                Rule::unique('users', 'mobile')
                    ->whereNull('deleted_at'),
                'between:' . ConstantHelper::MOBILE_MIN_LENGTH . ',' . ConstantHelper::MOBILE_MAX_LENGTH
            ],
            'name' => [
                'nullable',
                'string',
                'regex:/^[A-Za-z ]+$/',
                'max:99'
            ],
            'date_of_birth' => [
                'nullable',
                'date',
            ],
            'profile_pic' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png',
                'max:2048'
            ],
        ]);
        return $validator;
    }
}
