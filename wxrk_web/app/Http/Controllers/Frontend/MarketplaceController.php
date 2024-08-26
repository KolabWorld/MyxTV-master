<?php
namespace App\Http\Controllers\Frontend;

use DB;
use View;
use Auth;
use Session;
use stdClass;
use Datatables;
use Carbon\Carbon;

use App\User;
use App\Models\Admin;
use App\Models\Offer;
use App\Models\Country;
use App\Models\PriceView;
use App\Models\OfferType;
use App\Models\AdminOffer;
use App\Models\CountryOffer;
use App\Models\OfferCategory;
use App\Models\PaymentChannel;
use App\Models\PremiumCategory;
use App\Models\Order;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Offer as OfferValidator;
use Illuminate\Validation\Rule;

use App\Helpers\GeneralHelper;
use App\Helpers\ConstantHelper;
use App\Models\DayWisePoolMaster;
use App\Models\DayWiseSummary;
use App\Models\PoolMaster;

class MarketplaceController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index(Request $request)
	{
		$user = \Auth::guard('admin')->user();

		if($user->subscription_plan_id && ($user->is_payment_done == 0 || @$user->adminSubscriptionPlan->plan_expires_at <= date('Y-m-d H:i:s'))){
			return redirect('/subscription-plan-payment')->with(['warning' => 'Your Payment is pending for active plan']);
		}

		$this->validate($request, [
            'from_date' => [
                'nullable', 'date',
            ],
            'to_date' => [
                'nullable', 'date', 'after_or_equal:from_date'
            ]
        ],[
            'to_date.after_or_equal' => 'Please select Proper Date Range'
        ]);

        $countries = Country::get();
		$offers = Offer::with(
            [
                'offerType',
                'offerCategory',
                'premiumCategory',
				'orders',
            ]
			)
			->latest();

		if(!$user->hasRole('admin')){
			$offers->where('created_by',$user->id);
		}

		if($request->status){
			$offers->where('status', $request->status);
		}

		if($request->type){
			$offers->where('type', '=', $request->type);
		}

        if($request->name){
			$offers->where('name', '=', $request->name);
		}

		if($request->status){
			$offers->where('status',$request->status);
		}

		if($request->from_date){
			$offers->whereDate('created_at', '>=', $request->from_date);
		}

		if($request->to_date){
			$offers->whereDate('created_at', '<=', $request->to_date);
		}

		// $offers = $offers->get();
		// return $offers;
		$offers = $offers->paginate(10);
		
		return view('frontend.marketplace.index', array(
			'user' => $user,
			'tab' =>'marketplace',
            'offers' => $offers,
            'request' => $request,
            'countries' => $countries,
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$user = \Auth::guard('admin')->user();

		// if($user->subscription_plan_id && ($user->is_payment_done == 0 || @$user->adminSubscriptionPlan->plan_expires_at <= date('Y-m-d H:i:s'))){
		// 	return redirect('/subscription-plan-payment')->with(['warning' => 'Your Payment is pending for active plan']);
		// }

		if($user->hasRoles(['vendor'])){
			$thisMonthPlanStart = date('Y-m-').date('d',strtotime(@$user->adminSubscriptionPlan->created_at));
			$thisMonthOffers = Offer::where('created_by', $user->id)
			->whereBetween('created_at', [$thisMonthPlanStart, date('Y-m-d', strtotime($thisMonthPlanStart . ' +1 month -1 day'))])
			->count();

			if($thisMonthOffers >= @$user->subscriptionPlan->offers_in_a_month){
				return redirect('/marketplaces')->with(['warning' => "Your Subscription Plan doesn't allow more Offers to add."]);
			}

			$offer = new Offer();
			$countries = Country::get();
			$offerTypes = OfferType::get();
			$offerCategories = OfferCategory::get();
			$premiumCategories = PremiumCategory::get();
			$orders = Order::get();

			$action = '/marketplace/create';

			$maxAllowedImages = @$user->subscriptionPlan->planName ? $user->subscriptionPlan->planName->max_images_allowed : 0;

			return view('frontend.marketplace.create_edit', array(
				'user' => $user,
				'offer' => $offer,
				'action' => $action,
				'request' => $request,
				'tab' =>'marketplaces',
				'countries' => $countries,
				'offerTypes' => $offerTypes,
				'offerCategories' => $offerCategories,
				'premiumCategories' => $premiumCategories,
				'orders'=>$orders,
				'maxAllowedImages' => $maxAllowedImages,
			));
		}
		else{
			return redirect('/marketplaces')->withMessage('Only vendor can add offer');
		}
	}

	public function view(Request $request, $id)
	{
		$offer = Offer::find($id);
		$countries = Country::get();
		$offerTypes = OfferType::get();
		$offerCategories = OfferCategory::get();
		$premiumCategories = PremiumCategory::get();
        $orders = Order::where('offer_id' ,'=', $offer->id)->get();
		$offer->banners = $offer->getBanners();
		$action = '/marketplace/'.$offer->id.'/view';
 
		return view('frontend.marketplace.view', array(
			    'offer' => $offer,
				'action' => $action,
				'tab' =>'marketplaces',
				'countries' => $countries,
				'offerTypes' => $offerTypes,
				'offerCategories' => $offerCategories,
				'premiumCategories' => $premiumCategories,
				'orders' => $orders,
			     
		));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{ 
		$user = \Auth::guard('admin')->user();
		// dd($request->all());
		$validator = (new OfferValidator($request))->store();
		if ($validator->fails()) {
			// dd($validator);
			throw new ValidationException($validator);
		}

		$offer_end_date = date('Y-m-d',(strtotime($request->start_date.' +'.$request->offer_period.' days')));
		
		$offer = new Offer();
		$offer->fill($request->all());
		$offer->start_date = date('Y-m-d', strtotime($request->start_date));
		$offer->offer_end_date = $offer_end_date;
		if($request->premium_listing_period){
			$premium_offer_end_date = date('Y-m-d',(strtotime($request->start_date.' +'.$request->premium_listing_period.' days')));
			$offer->premium_offer_end_date = $premium_offer_end_date;
		}
		$offer->stock = 0;
		$offer->low_stock = 0;
		$offer->created_by = $user->id;
		$offer->offer_price_in_wxrk = GeneralHelper::calculateWxrkCoins($request->offer_price);
		$offer->save();

		$offer->countries()->sync($request->countries);

        if ($request->hasFile('company_logo')) {
            $offer->addMediaFromRequest('company_logo')->toMediaCollection('company_logo');
        }

		if ($request->hasFile('thumbnail_image')) {
            $offer->addMediaFromRequest('thumbnail_image')->toMediaCollection('thumbnail_image');
        }

        if ($request->hasFile('banners')) {
            foreach ($request->banners as $key => $image) {
                $offer->addMediaFromRequest("banners[$key]")->toMediaCollection('banners');
            }
        }

		// if($user->hasRoles(['vendor'])){
		// 	if($offer->offer_price > 0){
		// 		$paymentChannel = PaymentChannel::where('alias', '=', 'paypal')
		// 			->first();

		// 		$paymentTransaction = $offer->paymentTransactions()->create(
		// 			[
		// 				'payment_channel_id' => $paymentChannel->id,
		// 				'user_id' => $user->id,
		// 				'payee_name' => $user->name,
		// 				'payee_email' => $user->email,
		// 				'payee_mobile' =>$user->mobile,
		// 				'amount' => $offer->offer_price,
		// 				'currency_code' => 'USD'
		// 			]
		// 		);

		// 		if($paymentChannel->alias == "paypal") {

		// 			$orderID = 'paypal_'. Str::random();
		// 			$paymentTransaction->channel_order_id = $orderID;

		// 			$paymentTransaction->status = "created";
		// 			$paymentTransaction->save();

		// 			return view('frontend.paypal-payment',
		// 				array(
		// 					'paypalKey' => env('PAYPAL_KEY', ''),
		// 					'offer' => $offer,
		// 					'paymentTransaction' => $paymentTransaction,
		// 				)
		// 			);
		// 		}	
		// 	}
		// }

		// return redirect('/marketplaces')->withMessage('Record Added Succesfully!!!');

		return [
			'message' => 'Record Added Succesfully!!!'
		];
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param $user
	 * @return Response
	 */
	public function edit($id)
	{
		$user = \Auth::guard('admin')->user();

		// if($user->subscription_plan_id && ($user->is_payment_done == 0 || @$user->adminSubscriptionPlan->plan_expires_at <= date('Y-m-d H:i:s'))){
		// 	return redirect('/subscription-plan-payment')->with(['warning' => 'Your Payment is pending for active plan']);
		// }

		if($user->hasRoles(['vendor'])){	
			$offer = Offer::with(
				[
					'promoCodes'
				]
			)->find($id);

			if(!$user->hasRole('admin') && $offer->created_by != $user->id){
				return redirect('/dashboard')->with("Record doesn't belong to you");
			}

			$countries = Country::get();
			$offerTypes = OfferType::get();
			$offerCategories = OfferCategory::get();
			$premiumCategories = PremiumCategory::get();

			$offer->banners = $offer->getBanners();

			$action = '/marketplace/'.$offer->id.'/edit';

			$maxAllowedImages = @$user->subscriptionPlan->planName ? $user->subscriptionPlan->planName->max_images_allowed : 0;
			$maxAllowedImages -= count($offer->banners);

			return View::make('frontend.marketplace.create_edit', array(
				'user' => $user,
				'offer' => $offer,
				'action' => $action,
				'tab' =>'marketplaces',
				'countries' => $countries,
				'offerTypes' => $offerTypes,
				'offerCategories' => $offerCategories,
				'premiumCategories' => $premiumCategories,
				'maxAllowedImages' => $maxAllowedImages,
			));
		}
		else{
			return redirect('/marketplaces')->withMessage('Only vendor can update offer');
		}
	}

	public function update(Request $request,$id)
	{ 
		$user = \Auth::user();

		$request->request->add(['id' => $id]);
		$validator = (new OfferValidator($request))->update();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}
		
		$offer_end_date = date('Y-m-d',(strtotime($request->start_date.' +'.$request->offer_period.' days')));
		$premium_offer_end_date = date('Y-m-d',(strtotime($request->start_date.' +'.$request->premium_listing_period.' days')));
		
		$offer = Offer::find($id);
		$offer->fill($request->all());
		$offer->start_date = date('Y-m-d', strtotime($request->start_date));
		$offer->offer_end_date = $offer_end_date;
		$offer->premium_offer_end_date = $premium_offer_end_date;
		// $offer->stock = 0;
		// $offer->low_stock = 0;
		$offer->updated_by = $user->id;
		$offer->offer_price_in_wxrk = GeneralHelper::calculateWxrkCoins($request->offer_price);
		// dd($offer);
		$offer->save();
        
		$offer->countries()->sync($request->countries);
		
		if ($request->hasFile('company_logo')) {
            $offer->addMediaFromRequest('company_logo')->toMediaCollection('company_logo');
        }

		if ($request->hasFile('thumbnail_image')) {
            $offer->addMediaFromRequest('thumbnail_image')->toMediaCollection('thumbnail_image');
        }

        if ($request->hasFile('banners')) {
            foreach ($request->banners as $key => $image) {
                $offer->addMediaFromRequest("banners[$key]")->toMediaCollection('banners');
            }
        }

		// return redirect('/marketplaces')->withMessage('Record Updated Succesfully!!!');

		return [
			'message' => 'Record Updated Succesfully!!!'
		];
	}

	public function destroy($id){
		$user = \Auth::user();

		$offer = Offer::find($id);
		if(!$offer){
			return [
				'message' => 'Offer does not exist.',
			];
		}
		else{
			$offer->delete();
		}

		return [
			'message' => 'Record deleted successfully!',
		];
	}	
}
