<?php
namespace App\Http\Controllers\API;

use App\User;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Address;
use App\Models\PromoCode;
use App\Models\UserWallet;
use App\Models\OfferCategory;
use App\Models\WalletTransaction;

use App\Helpers\GeneralHelper;
use App\Helpers\ConstantHelper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiGenericException;
use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Master as Validator;
use App\Models\DayWiseSummary;

class OfferController extends Controller
{

    const QUEUE_NAME = 'API';

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $user = \Auth::user();

        $offers = Offer::whereHas(
            'countries', function($c) use ($user){
                $c->where('countries.id', $user->country_id);
            }
        )
        ->with([
            'offerType',
            'offerCategory',
            'premiumCategory'
        ])
        ->where(function($query){
            $query->whereDate('offer_end_date','>=',date('Y-m-d'));
                // ->whereDate('offer_end_date','<=',date('Y-m-d'));
        })
        ->where('status','=', 'active')
        ->latest();
       
        if($request->status){
			$offers->where('status', $request->status);
		}

		if(!empty($request->offer_category_ids)){
			$offers->whereIn('offer_category_id', $request->offer_category_ids);
		}

        if($request->name){
			$offers->where('offer_name', '=', $request->name);
		}

        $offers = $offers->get();

        $data = array(
            'offers' => $offers,
        );

        return array(
			'message' => __('message.fetch_records'),
			'data' => $data,
		);
    }

    public function offerCategories()
    {
        $user = \Auth::user();

        $offerCategories = OfferCategory::where('status','active')->get();

        $data = [
            'offer_categories' => $offerCategories,
        ];

        return array(
			'message' => __('message.fetch_records'),
			'data' => $data,
		);
    } 

    public function show($id)
    {
        $user = \Auth::user();

        $offer = Offer::with(
            [
                'offerType',
                'offerCategory',
                'premiumCategory',
                'promoCodes'
            ]
        )
        ->find($id);
        
        if(!$offer){
            throw new ApiGenericException(__('message.doesnt_exist', ['static' => __('static.offer')]));
        }

        // if($offer->end_date_time <= date('Y-m-d H:i:s')){
        //     throw new ApiGenericException(__('message.has_expired', ['static' => __('static.offer')]));
        // }

        $data = array(
            'offer' => $offer,
        );

        return array(
			'message' => __('message.fetch_records'),
			'data' => $data,
		);
    }

    public function getPromoCode($id)
    {
        $user = \Auth::user();

        $promoCode = PromoCode::with(
            [
                'offer',
            ]
        )
        ->where('offer_id', $id)
        ->where('user_id', $user->id)
        ->where('status', '=', ConstantHelper::ACTIVE)
        ->first();
        
        if(!$promoCode){
            throw new ApiGenericException(__('message.doesnt_exist', ['static' => __('static.promo_code')]));
        }

        $data = array(
            'promoCode' => $promoCode,
        );

        return array(
			'message' => __('message.fetch_records'),
			'data' => $data,
		);
    }

    public function applyPromoCode(Request $request){
        $user = \Auth::user();

        if(!$request->promo_code){
            throw new ApiGenericException(__('message.doesnt_exist', ['static' => __('static.promo_code')]));
        }
        $promoCode = PromoCode::where('id', $request->id)
            ->where('promo_code', '=', $request->promo_code)
            ->first();
        if(!$promoCode){
            throw new ApiGenericException(__('message.doesnt_exist', ['static' => __('static.promo_code')]));
        }
        $promoCode->status = ConstantHelper::SOLD;
        $promoCode->save();
    
        return array(
            'message' => __('message.applied_successfully', ['static' => __('static.promo_code')]),
        );
    }

    public function buyOffer(Request $request){
        $user = \Auth::user();
        
        if($request->offer_id && $request->user_id){
            $offer = Offer::find($request->offer_id);
            $user = User::find($request->user_id);

            $userWallet = UserWallet::where('user_id', $user->id)->first();

            if(!$user){
                throw new ApiGenericException(__('message.doesnt_exist', ['static' => __('static.user')]));
            }
            elseif(!$offer){
                throw new ApiGenericException(__('message.doesnt_exist', ['static' => __('static.offer')]));
            }
            elseif($offer->start_date > date('Y-m-d')){
                throw new ApiGenericException(__('message.not_started', ['static' => __('static.offer')]));
            }
            elseif(!$userWallet){
                throw new ApiGenericException(__('message.doesnt_exist', ['static' => __('static.user_balance_data')]));
            }
            elseif($userWallet->wxrk_balance < $offer->offer_price_in_wxrk){
                throw new ApiGenericException(__('message.insufficient_balance'));
            }
            else{
                $promoCode = PromoCode::with(
                    [
                        'offer',
                    ]
                )
                ->where('offer_id', $offer->id)
                ->where('status', '=', ConstantHelper::ACTIVE)
                ->first();
                
                if(!$promoCode){
                    throw new ApiGenericException(__('message.doesnt_exist', ['static' => __('static.promo_code')]));
                }

                // $existingOrder = Order::where('user_id', $user->id)
                // ->where('offer_id', $offer->id)
                // ->first();

                // if($existingOrder){
                //     return array(
                //         'message' => __('message.already_purchased'),
                //         'promo_code' => $promoCode,
                //         'offer' => $offer,
                //         'order' => $existingOrder,
                //     );
                //     // throw new ApiGenericException(__('message.already_purchased'));
                // }  

                $promoCode->status = ConstantHelper::SOLD;
                $promoCode->save();

                // dd($offer->remaining_promocodes, $offer->low_stock);
                if($offer->remaining_promocodes <= $offer->low_stock){
                    $offer->is_low_stock = 1;
                }
                $offer->stock -= 1;
                $offer->update();
                
                $user->offers()->attach($offer->id);;

                // $adminAddress = Address::where('addressable_type', '=', 'App\Models\Admin')
                //     ->where('addressable_id', '=', $offer->created_by)
                //     ->first();

                $order = new Order();
                $order->order_number =  $promoCode->promo_code;
                $order->offer_id = $offer->id;
                $order->offer_name = $offer->offer_name;
                $order->offer_price = $offer->offer_price_in_wxrk;
                $order->offer_promo_code = $promoCode->promo_code;
                $order->promo_code_redemption_status = $promoCode->status;
                $order->promo_code_redemption_date = date('Y-m-d');
                $order->offer_type = $offer->offerType ? $offer->offerType->name : '';
                $order->offer_category = $offer->offerCategory ? $offer->offerCategory->name : '';
                $order->offer_premium_category = $offer->premiumCategory ? $offer->premiumCategory->name : '';
                $order->time_to_redeem = $offer->time_to_redeem;
                $order->highlight_of_offer = $offer->highlight_of_offer;
                $order->details_of_offer = $offer->details_of_offer;
                $order->link = $offer->link;
                $order->user_id = $user->id;
                $order->customer_name = $user->name;
                $order->customer_mobile = $user->mobile;
                $order->customer_email = $user->email;
                $order->customer_country = 'india';
                $order->admin_id = $offer->created_by;
                $order->vendor_name = $offer->createdBy ? $offer->createdBy->name : '';
                $order->vendor_mobile = $offer->createdBy ? $offer->createdBy->mobile : '';
                $order->vendor_email = $offer->createdBy ? $offer->createdBy->email : '';
                $order->vendor_country = 'india';
                $order->vendor_category = '';
                $order->vendor_state = '';
                $order->vendor_city = '';
                $order->vendor_address = '';
                $order->vendor_postal_code = '';
                $order->status = 'active';
                $order->created_by = $user->id;
                $order->save();

                $walletTransaction = new WalletTransaction();
                $walletTransaction->user_id = $user->id;
                $walletTransaction->offer_id = $offer->id;
                $walletTransaction->type = 'spent';
                $walletTransaction->wxrk_balance = $order->offer_price;
                $walletTransaction->app_usage_time = "0.00";
                $walletTransaction->idle_time = "0.00";
                $walletTransaction->status = "active";
                $walletTransaction->save();

                $userWallet->wxrk_spent += $order->offer_price;
                $userWallet->wxrk_balance -= $order->offer_price;
                $userWallet->update();

                return array(
                    'message' => __('message.applied_successfully', ['static' => __('static.promo_code')]),
                    'promo_code' => $promoCode,
                    'offer' => $offer,
                    'order' => $order,
                );
            }
        }
        else{
            throw new ApiGenericException(__('message.something_went_wrong'));
        }
    }
    
}