<?php
namespace App\Lib\Validation;

use Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Helpers\ConstantHelper;
use App\Models\Offer as ModelsOffer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Validator as ValidationValidator;

class Offer {
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function store() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            "offer_type_id" => [
                'required',
                'integer',
                'exists:offer_types,id'
            ],
            "offer_category_id" => [
                'required',
                'integer',
                'exists:offer_categories,id'
            ],
            'countries' => [
                'required',
                'array',
            ],
            'countries.*' => [
                'required',
                'exists:countries,id',
            ],
            "premium_category_id" => [
                'nullable',
                'integer',
                'exists:premium_categories,id'
            ],
            "offer_name" => [
                'required',
                'regex:/^([a-zA-Z0-9]|[- @\.#&!])*$/',
                'string',
                'max:199',
            ],
            "offer_price" => 'required|integer|min:1|max:10000000',
            "offer_period" => 'required|integer|min:1|max:1000',
            "premium_listing_period" => [
                'nullable',
                'integer',
                'min:1',
                'max:1000',
                'lte:offer_period',
                function($attribute, $value, $fail){
                    $user = \Auth::guard('admin')->user();

                    if($user){
                        $maxPremiumDays = $user->subscriptionPlan ? $user->subscriptionPlan->premium_days : 0;

                        $thisMonthPlanStart = date('Y-m-').date('d',strtotime(@$user->adminSubscriptionPlan->created_at));
                        $usedPremiumDays = ModelsOffer::where('created_by', $user->id)
                        ->whereBetween('created_at', [$thisMonthPlanStart, date('Y-m-d', strtotime($thisMonthPlanStart . ' +1 month -1 day'))])
                        ->sum('premium_listing_period');

                        // dd($maxPremiumDays, $usedPremiumDays);

                        $allowedPremiumDays = $maxPremiumDays - $usedPremiumDays;

                        if($allowedPremiumDays < $value){
                            $fail('You currently have only '.$allowedPremiumDays.' premium days');
                        }
                    }
                }
            ],
            "start_date" => 'required|after_or_equal:today',
            "you_get" => 'nullable|integer|min:1|max:10000000',
            "low_stock" => 'nullable|integer|min:1|max:10000000',
            "time_to_redeem" => 'nullable|integer|min:1|max:1000',
            "quantity_per_user" => 'nullable|integer|min:1|max:10000',
            "shipping_cost" => 'nullable|integer|min:1|max:100000',
            "highlight_of_offer" => [
                'nullable',
                'string',
                'max:599'
            ],
            "details_of_offer" => [
                'nullable',
                'string',
                'max:599'
            ],
            "company_name" => [
                'required',
                'string',
                'max:191',
            ],
            "about_the_company" => [
                'nullable',
                'string',
                'max:599'
            ],
            "link" => [
                'nullable',
                'string',
                'max:250',
            ],
            "offer_code_bg_color" => [
                'nullable',
                'numeric',
                'digits:6',
            ],
            "offer_code_text_color" => [
                'nullable',
                'numeric',
                'digits:6',
            ],
            'company_logo' => [
                'required',
                'file',
                'mimes:png,jpeg,jpg',
                'max:1024'
            ],
            'attachment_type' => [
                'required',
                'string',
                'max:191'
            ],
            'is_auto_play' => [
                'required_if:attachment_type,video',
                'nullable',
                'integer',
                'max:1',
                'min:0'
            ],
            'thumbnail_image' => [
                'required',
                'file',
                'mimes:png,jpeg,jpg,mp4',
                'max:5242'
            ],
            'banners.*' => [
                'required',
                'file',
                'mimes:png,jpeg,jpg',
                'max:1024'
            ],
            'status' => [
                'required',
                'string',
                'max:99'
            ],
            
        ],[
            'premium_listing_period.lte' => 'The premium listing period must be less than or equal Offer Period.'
        ]);

        return $validator;
    }

    public function update() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            "offer_type_id" => [
                'nullable',
                'integer',
                'exists:offer_types,id'
            ],
            "offer_category_id" => [
                'required',
                'integer',
                'exists:offer_categories,id'
            ],
            'countries' => [
                'nullable',
                'array',
            ],
            'countries.*' => [
                'nullable',
                'exists:countries,id',
            ],
            "premium_category_id" => [
                'nullable',
                'integer',
                'exists:premium_categories,id'
            ],
            "offer_name" => [
                'required',
                'regex:/^([a-zA-Z0-9]|[- @\.#&!])*$/',
                'string',
                'max:199',
            ],
            "offer_price" => 'nullable|integer|min:1|max:10000000',
            "offer_period" => 'nullable|integer|min:1|max:1000',
            "premium_listing_period" => [
                'nullable',
                'integer',
                'min:1',
                'max:1000',
                'lte:offer_period',
                function($attribute, $value, $fail){
                    $user = \Auth::guard('admin')->user();

                    if($user){
                        $maxPremiumDays = $user->subscriptionPlan ? $user->subscriptionPlan->premium_days : 0;

                        $thisMonthPlanStart = date('Y-m-').date('d',strtotime(@$user->adminSubscriptionPlan->created_at));
                        $usedPremiumDays = ModelsOffer::where('created_by', $user->id)
                        ->where('id', '!=', $this->request->id)
                        ->whereBetween('created_at', [$thisMonthPlanStart, date('Y-m-d', strtotime($thisMonthPlanStart . ' +1 month -1 day'))])
                        ->sum('premium_listing_period');

                        $allowedPremiumDays = $maxPremiumDays - $usedPremiumDays;

                        if($allowedPremiumDays < $value){
                            $fail('You currently have only '.$allowedPremiumDays.' premium days');
                        }
                    }
                }
            ],
            "start_date" => 'nullable',
            "you_get" => 'nullable|integer|min:1|max:10000000',
            "low_stock" => 'nullable|integer|min:1|max:10000000',
            "time_to_redeem" => 'nullable|integer|min:1|max:1000',
            "quantity_per_user" => 'nullable|integer|min:1|max:10000',
            "shipping_cost" => 'nullable|integer|min:1|max:100000',
            "highlight_of_offer" => [
                'nullable',
                'string',
                'max:599'
            ],
            "details_of_offer" => [
                'nullable',
                'string',
                'max:599'
            ],
            "company_name" => [
                'nullable',
                'string',
                'max:191',
            ],
            "about_the_company" => [
                'nullable',
                'string',
                'max:599'
            ],
            "link" => [
                'nullable',
                'string',
                'max:250',
            ],
            "offer_code_bg_color" => [
                'nullable',
                'numeric',
                'digits:6',
            ],
            "offer_code_text_color" => [
                'nullable',
                'numeric',
                'digits:6',
            ],
            'company_logo' => [
                'nullable',
                'file',
                'mimes:png,jpeg,jpg',
                'max:1024'
            ],
            'attachment_type' => [
                'nullable',
                'string',
                'max:191'
            ],
            'is_auto_play' => [
                'required_if:attachment_type,video',
                'nullable',
                'integer',
                'max:1',
                'min:0'
            ],
            'thumbnail_image' => [
                'nullable',
                'file',
                'mimes:png,jpeg,jpg,mp4',
                'max:5242'
            ],
            'banners.*' => [
                'nullable',
                'file',
                'mimes:png,jpeg,jpg',
                'max:1024'
            ],
            'status' => [
                'nullable',
                'string',
                'max:99'
            ],
        ],[
            'premium_listing_period.lte' => 'The premium listing period must be less than or equal to Offer Period.'
        ]);

        return $validator;
    }

    public function storePromocode() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(),[
            'promo_codes.*.promo_code' => [
                'required',
                'unique:promo_codes,promo_code'
            ]
        ],[
            'promo_codes.*.promo_code.required' => 'Please enter promo code'
        ]);

        return $validator;
    }

}