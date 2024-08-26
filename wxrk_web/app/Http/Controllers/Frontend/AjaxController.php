<?php
namespace App\Http\Controllers\Frontend;

use DB;
use Auth;
use Session;

use App\User;
use App\Models\City;
use App\Models\Admin;
use App\Models\State;
use App\Models\Country;
use App\Models\Address;
use App\Models\PriceView;
use App\Models\SubscriptionPlan;
use App\Models\NewsletterSubsciber;

use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Exceptions\NotFoundException;
use Spatie\MediaLibrary\Models\Media;
use App\Exceptions\ApiGenericException;
use App\Models\Offer;

class AjaxController extends Controller
{

    public function index() {

        $user = \Auth::user();
        if($user) {
            $userCart = UserCart::where('user_id','=',\Auth::user()->id)->get();
            $cartCount = count($userCart);

            return array(
                'cart_item_count' => $cartCount
            );
        }
        else {
            throw new ApiGenericException("Not LoggedIn User");
        }
    }

    public function getStates(Request $request)
    {
        if ($request->country_id) {
            $stateData = State::where('country_id', '=', $request->country_id)->where('status','active')->get();
        }
        else if($request->country_ids) {
            $stateData = State::whereIn('country_id', json_decode($request->country_ids,true))->where('status','active')->get();        
        }
        else {
            // $stateData = State::all();
            $stateData = [];
        }
        // dd($stateData);
        $stateDataArray = array();
        foreach ($stateData as $value) {
            $stateDataArray[$value->id] = $value->name;
        }
        return $stateDataArray;
    }


    public function getCities(Request $request)
    {
        if($request->state_id)
            $cityData = City::where('state_id', '=', $request->state_id)->get();
        else if($request->state_ids) {
            $cityData = City::whereIn('state_id', json_decode($request->state_ids,true))->get();
        }
        else {
            // $cityData = City::all();
            $cityData = [];
        }
    
        $cityDataArray = array();
        foreach ($cityData as $value) {
            $cityDataArray[$value->id] = $value->name;
        }
        
        return $cityDataArray;
    }

    public function getPriceValue(Request $request)
    {
        // dd($request->all());
        $offerListingPrice = 0;
        $offerListingValue = 0;
        $premiumListingPrice = 0;
        $premiumListingValue = 0;
        $totalValue = 0;
        $priceView = '';
        $dataArray = array();
        $data = array(
            'offer_listing_price' => $offerListingPrice,
            'offer_listing_value' => $offerListingValue,
            'premium_listing_price' => $premiumListingPrice,
            'premium_listing_value' => $premiumListingValue,
            'total_value' => $totalValue
        );
        if(!$request->start_date){
            $dataArray = array(
                'status' => 'error',
                'code' => 204,
                'message' => 'start date required.',
                'data' => $data
            );
            return $dataArray;
        }
        $priceView = PriceView::whereDate('from_date', '<=', $request->start_date)
            ->whereDate('to_date', '>=', $request->start_date)
            ->first();
        if(!$priceView){
            $dataArray = array(
                'status' => 'error',
                'code' => 204,
                'message' => 'There is no price view for this date.',
                'data' => $data
            );
            return $dataArray;
        }
        if($request->offer_period && !($request->premium_period)){
            $offerListingPrice = $priceView->offer_price_per_day;
            $offerListingValue = $offerListingPrice*$request->offer_period;
        }
        else if($request->premium_period && !($request->offer_period)){
            $premiumListingPrice = $priceView->premium_price_per_day;
            $premiumListingValue = $premiumListingPrice*$request->premium_period;
        }
        else if($request->premium_period && $request->offer_period){
            $offerListingPrice = $priceView->offer_price_per_day;
            $offerListingValue = $offerListingPrice*$request->offer_period;
            $premiumListingPrice = $priceView->premium_price_per_day;
            $premiumListingValue = $premiumListingPrice*$request->premium_period;
        }
        else{
            $offerListingPrice = 0;
            $offerListingValue = 0;
            $premiumListingPrice = 0;
            $premiumListingValue = 0;
        }
        $totalValue = $offerListingValue + $premiumListingValue;

        $data = array(
            'offer_listing_price' => (int)$offerListingPrice,
            'offer_listing_value' => (int)$offerListingValue,
            'premium_listing_price' => (int)$premiumListingPrice,
            'premium_listing_value' => (int)$premiumListingValue,
            'total_value' => (int)$totalValue
        );

        $dataArray = array(
            'status' => 'success',
            'code' => 200,
            'message' => 'Data retrieved successfuly.',
            'data' => $data
        );

        return $dataArray;
    }

    public function storeLowStock(Request $request)
    {
        // dd($request->all());
        $this->validate($request,[
            'offer_id' => [
                'required',
                'exists:offers,id'
            ],
            'low_stock_perc' => [
                'required',
                'numeric',
                'min:1',
                'max:100'
            ]
        ]);

        $perc = $request->low_stock_perc;
        $offer = Offer::find($request->offer_id);

        $total = count($offer->promoCodes);
        $lowStock = $total * $perc / 100;

        $offer->low_stock = floor($lowStock);
        $offer->update();

        $data = [
            'offer' => $offer
        ];
        
        $dataArray = array(
            'status' => 'success',
            'code' => 200,
            'message' => 'Stock updated successfuly.',
            'data' => $data
        );

        return $dataArray;
    }

    public function destroyMedia(Request $request, $id)
    {
        $media = Media::find($id);
        $media->delete();

        return [
            'message' => "File deleted succesfully",
        ];
    }

    public function subscriptionPlans(Request $request)
    {
        $records = SubscriptionPlan::where('status', '=', 'active')
            ->orderBy('price', 'ASC');
        
        if($request->plan_type && ($request->plan_type == 'yearly')){
            $records = $records->where('plan_type', '=', 'yearly');
        }
        else {
            $records = $records->where('plan_type', '=', 'monthly');
        }

        $records = $records->get();

        $dataArray = array(
            'status' => 'success',
            'code' => 200,
            'message' => 'Data retrieved successfuly.',
            'data' => $records
        );

        return $dataArray;
    }
    
    public function newsletterSubscribe(Request $request){
        $messages = [
            'unique' => 'You have already subscribed.',
        ];
        $this->validate($request, [
            'email' => ['required','string','email','unique:newsletter_subscribers,email'],
        ],$messages);
        
        $newsletter = new NewsletterSubsciber();
        $input = $request->all();
        $newsletter->fill($input);
        $newsletter->save();
        // dd('fghj');
          
        return 'Thank you for subscribing newsletter';
    }
}
