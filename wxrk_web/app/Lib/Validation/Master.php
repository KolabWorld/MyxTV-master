<?php
namespace App\Lib\Validation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator as ValidationValidator;

use App\Helpers\ConstantHelper;

class Master {
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function storeBusinessCategory() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'regex:/^[A-Za-z ]+$/',
                'max:199',
            ],
            'status' => [
                'required',
                'string',
                'max:99',
            ], 
        ]);

        return $validator;
    }

    public function updateBusinessCategory() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'regex:/^[A-Za-z ]+$/',
                'max:199',
            ],
            'status' => [
                'required',
                'string',
                'max:99',
            ], 
        ]);

        return $validator;
    }

    public function storeVendorOrigin() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'regex:/^[A-Za-z ]+$/',
                'max:199',
            ],
            'status' => [
                'required',
                'string',
                'max:99',
            ], 
        ]);

        return $validator;
    }

    public function updateVendorOrigin() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'regex:/^[A-Za-z ]+$/',
                'max:199',
            ],
            'status' => [
                'required',
                'string',
                'max:99',
            ], 
        ]);

        return $validator;
    }

    public function storeOfferType() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'regex:/^[A-Za-z ]+$/',
                'max:199',
            ],
            'status' => [
                'required',
                'string',
                'max:99',
            ], 
        ]);

        return $validator;
    }

    public function updateOfferType() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'regex:/^[A-Za-z ]+$/',
                'max:199',
            ],
            'status' => [
                'required',
                'string',
                'max:99',
            ], 
        ]);

        return $validator;
    }

    public function storeOfferCategory() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'regex:/^[A-Za-z ]+$/',
                'max:199',
            ],
            'status' => [
                'required',
                'string',
                'max:99',
            ], 
        ]);

        return $validator;
    }

    public function updateOfferCategory() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'regex:/^[A-Za-z ]+$/',
                'max:199',
            ],
            'status' => [
                'required',
                'string',
                'max:99',
            ], 
        ]);

        return $validator;
    }

    public function storePremiumCategory() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'regex:/^[A-Za-z ]+$/',
                'max:199',
            ],
            'status' => [
                'required',
                'string',
                'max:99',
            ], 
        ]);

        return $validator;
    }

    public function updatePremiumCategory() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'regex:/^[A-Za-z ]+$/',
                'max:199',
            ],
            'status' => [
                'required',
                'string',
                'max:99',
            ], 
        ]);

        return $validator;
    }

    public function storeEventType() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'regex:/^[A-Za-z ]+$/',
                'max:199',
            ],
            'status' => [
                'required',
                'string',
                'max:99',
            ], 
        ]);

        return $validator;
    }

    public function updateEventType() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'regex:/^[A-Za-z ]+$/',
                'max:199',
            ],
            'status' => [
                'required',
                'string',
                'max:99',
            ], 
        ]);

        return $validator;
    }

    public function storePaymentCycle() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH,
                'unique:payment_cycles,name'
            ], 
        ]);

        return $validator;
    }

    public function updatePaymentCycle() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH,
                'unique:payment_cycles,name'
            ], 
        ]);

        return $validator;
    }

    public function storeSocialMedia() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH
            ],
            'link' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH
            ],
            'icon' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH
            ],
            'description' => [
                'nullable',
                'string',
                'max:'.ConstantHelper::DESCRIPTION_LENGTH
            ], 
        ]);

        return $validator;
    }

    public function updateSocialMedia() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH
            ],
            'link' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH
            ],
            'icon' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH
            ],
            'description' => [
                'nullable',
                'string',
                'max:'.ConstantHelper::DESCRIPTION_LENGTH
            ], 
        ]);

        return $validator;
    }

    public function storePaymentChannel() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH,
                'unique:payment_channels,name'
            ],
            'alias' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH,
                'unique:payment_channels,alias'
            ],
            'access_id' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH,
                'unique:payment_channels,access_id'
            ],
            'access_code' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH,
                'unique:payment_channels,access_code'
            ],
            'access_secret' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH,
                'unique:payment_channels,access_secret'
            ],
        ]);

        return $validator;
    }

    public function updatePaymentChannel() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH,
                Rule::unique('payment_channels','name')
                    ->ignore($this->request->id,'id')
            ],
            'alias' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH,
                Rule::unique('payment_channels','alias')
                    ->ignore($this->request->id,'id')
            ],
            'access_id' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH,
                Rule::unique('payment_channels','access_id')
                    ->ignore($this->request->id,'id')
            ],
            'access_code' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH,
                Rule::unique('payment_channels','access_code')
                    ->ignore($this->request->id,'id')
            ],
            'access_secret' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH,
                Rule::unique('payment_channels','access_secret')
                    ->ignore($this->request->id,'id')
            ],
        ]);

        return $validator;
    }

    public function storeVoucher() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'code' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH,
                'unique:vouchers,code'
            ],
            'value' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH
            ],
            'valid_from' => [
                'required'
            ],
            'valid_to' => [
                'required'
            ],
            'discount_type' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH
            ],
            'max_uses' => [
                'required'
            ],
        ]);

        return $validator;
    }

    public function updateVoucher() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'code' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH,
                Rule::unique('vouchers','code')
                    ->ignore($this->request->id,'id')
            ],
            'value' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH
            ],
            'valid_from' => [
                'required'
            ],
            'valid_to' => [
                'required'
            ],
            'discount_type' => [
                'required',
                'string',
                'max:'.ConstantHelper::FULLNAME_MAX_LENGTH
            ],
            'max_uses' => [
                'required'
            ],
        ]);

        return $validator;
    }

    public function storePriceView() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            "from_date" => 'required|after_or_equal:today',
            "to_date" => 'required|after_or_equal:to_date',
            "offer_price_per_day" => 'required|integer|min:1|max:10000000',
            "premium_price_per_day" => 'required|integer|min:1|max:10000000',
        ]);

        return $validator;
    }

    public function updatePriceView() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            "from_date" => 'required|after_or_equal:today',
            "to_date" => 'required|after_or_equal:to_date',
            "offer_price_per_day" => 'required|integer|min:1|max:10000000',
            "premium_price_per_day" => 'required|integer|min:1|max:10000000',
        ]);

        return $validator;
    }

    public function storeSponser() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            "name" => [
                'required',
                'regex:/^[A-Za-z .]+$/',
                'string',
                'max:199',
            ],
            "email" => [
                'required',
                'string',
                'email',
                'max:199',
            ],
            "mobile" => [
                'required', 
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'between:'.ConstantHelper::MOBILE_MIN_LENGTH.','.ConstantHelper::MOBILE_MAX_LENGTH
            ],
        ]);

        return $validator;
    }

    public function updateSponser() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            "name" => [
                'required',
                'regex:/^[A-Za-z .]+$/',
                'string',
                'max:199',
            ],
            "email" => [
                'required',
                'string',
                'email',
                'max:199',
            ],
            "mobile" => [
                'required', 
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'between:'.ConstantHelper::MOBILE_MIN_LENGTH.','.ConstantHelper::MOBILE_MAX_LENGTH
            ],
        ]);

        return $validator;
    }
    
    public function storePoolMaster() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            "total_supply" => [
                'required',
                'integer',
            ],
            "wxrk_pool" => [
                'required',
                'numeric',
            ],
            "daily_limit" => [
                'required', 
                'numeric',
            ],
            "max_coin_per_user" => [
                'required', 
                'numeric',
            ],
        ]);

        return $validator;
    }

    public function updatePoolMaster() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            "total_supply" => [
                'required',
                'numeric',
            ],
            "wxrk_pool" => [
                'required',
                'numeric',
            ],
            "daily_limit" => [
                'required', 
                'numeric',
            ],
            "max_coin_per_user" => [
                'required', 
                'numeric',
            ],
        ]);

        return $validator;
    }

    public function storeDayWisePoolMaster() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'pool_date' => [
                'required',
                'date',
                'unique:day_wise_pool_masters,pool_date'
            ],
            'pool_balance' => [
                'required',
                'numeric'
            ],
            'daily_limit' => [
                'required',
                'numeric'
            ],
            'total_user' => [
                'required',
                'numeric'
            ],
            'wxrk_dist_limit' => [
                'required',
                'numeric'
            ],
            'wxrk_per_user_per_day' => [
                'required',
                'numeric'
            ],
            'wxrk_per_min' => [
                'required',
                'numeric'
            ],
            'status' => [
                'required',
                'string'
            ],
        ]);

        return $validator;
    }

    public function updateDayWisePoolMaster() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'pool_date' => [
                'required',
                'date',
                'unique:day_wise_pool_masters,pool_date,'.$this->request->id
            ],
            'pool_balance' => [
                'required',
                'numeric'
            ],
            'daily_limit' => [
                'required',
                'numeric'
            ],
            'total_user' => [
                'required',
                'numeric'
            ],
            'wxrk_dist_limit' => [
                'required',
                'numeric'
            ],
            'wxrk_per_user_per_day' => [
                'required',
                'numeric'
            ],
            'wxrk_per_min' => [
                'required',
                'numeric'
            ],
            'status' => [
                'required',
                'string'
            ],
        ]);

        return $validator;
    }

    public function storePlanName() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            "plan_type_id" => [
                'required',
            ],
            "name" => [
                'required',
                'string',
            ],
            "max_images_allowed" => [
                'required', 
                'string',
            ],
            // "max_videos_allowed" => [
            //     'required', 
            //     'numeric',
            // ],
        ]);

        return $validator;
    }

    public function updatePlanName() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            "plan_type_id" => [
                'required',
            ],
            "name" => [
                'required',
                'string',
            ],
            "max_images_allowed" => [
                'required', 
                'string',
            ],
            // "max_videos_allowed" => [
            //     'required', 
            //     'numeric',
            // ],
        ]);

        return $validator;
    }
    public function storePlanType() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            "name" => [
                'required',
                'string',
            ],
        ]);

        return $validator;
    }

    public function updatePlanType() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            "name" => [
                'required',
                'string',
            ],
        ]);

        return $validator;
    }
    
    public function storeSupportCategory() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'regex:/^[A-Za-z ]+$/',
                'max:199',
            ],
            'status' => [
                'required',
                'string',
                'max:99',
            ], 
        ]);

        return $validator;
    }

    public function updateSupportCategory() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'name' => [
                'required',
                'string',
                'regex:/^[A-Za-z ]+$/',
                'max:199',
            ],
            'status' => [
                'required',
                'string',
                'max:99',
            ], 
        ]);

        return $validator;
    }
    
    public function storeSubCategory() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'parent_id' =>[
                'required'
            ],
            'name' => [
                'required',
                'string',
                'regex:/^[A-Za-z ]+$/',
                'max:199',
            ],
            'status' => [
                'required',
                'string',
                'max:99',
            ], 
        ]);

        return $validator;
    }

    public function updateSubCategory() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'parent_id' =>[
                'required'
            ],
            'name' => [
                'required',
                'string',
                'regex:/^[A-Za-z ]+$/',
                'max:199',
            ],
            'status' => [
                'required',
                'string',
                'max:99',
            ], 
        ]);

        return $validator;
    }

}