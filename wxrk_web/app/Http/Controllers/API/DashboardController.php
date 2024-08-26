<?php
namespace App\Http\Controllers\API;

use View;
use Auth;
use DateTime;
use Carbon\Carbon;

use App\User;
use App\Models\Role;
use App\Models\Admin;
use App\Models\Offer;
use App\Models\Event;
use App\Models\Order;
use App\Models\Banner;
use App\Models\Country;
use App\Models\TwitchVideo;                                                               
use App\Models\IosIdleTime;
use App\Models\IosUsageLog;
use App\Models\AppSummaryLog;
use App\Models\DayWiseSummary;
use App\Models\PremiumCategory;
use App\Models\AndroidUsageLog;
use App\Models\DayWisePoolMaster;
use App\Models\WalletTransaction;                                                               
use App\Models\TwitchVideosStreamer;                                                               

use App\Helpers\MenuHelper;
use App\Helpers\GeneralHelper;
use App\Helpers\ConstantHelper;

use Illuminate\Http\Request;
use App\Exceptions\UserNotFound;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiGenericException;
use App\Notifications\CommonNotification;
use App\Lib\Validation\Auth as Validator;
use App\Models\UserWallet;
use Illuminate\Validation\ValidationException;
use \Laravel\Passport\Http\Controllers\AccessTokenController;

class DashboardController extends Controller
{

    const QUEUE_NAME = 'API';

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $user = \Auth::user();

        $offers = array();

        $dayWiseSummaryData = DayWiseSummary::where('user_id', $user->id)
            ->whereDate('created_at', date('Y-m-d'))
            ->first();

        $dayWiseIosAppPerformance = DayWiseSummary::where('user_id', $user->id)
            ->whereNotNull('time_saved_percentage')
            ->orderBy('created_at', 'DESC')
            ->get();

        $totalBalance = DayWiseSummary::where('user_id', $user->id)
            ->sum('wxrk_balance');

        $totalBalance = $totalBalance ?: "0.00";    
        
        $offers = Offer::whereHas(
            'countries', function($c) use ($user){
                $c->where('countries.id', $user->country_id);
            }
        )
        ->with([
            'offerType',
            'offerCategory'
        ])
        ->where(function($query){
            $query->whereDate('offer_end_date','>=',date('Y-m-d'));
        })
        ->where('status','=', 'active')
        ->latest()
        ->limit(5)
        ->get();
       
        $events = Event::with(
            [
                'eventType',
                'countries',
            ]
        )
        ->whereHas(
            'eventType',
            function ($query) {
                $query->where('name', '=', 'Featured');
            }
        )
        ->whereDate('end_date_time', '>=', date('Y-m-d H:i:s'))
        ->where('status','=', 'active')
        ->latest()
        ->get();

        $banners = Banner::where('status', 'active')
                    ->take(3)
                    ->get();

        $data = array(
            'total_balance' => $totalBalance,
            'day_wise_summary' => $dayWiseSummaryData,
            'ios_app_performace' => $dayWiseIosAppPerformance,
            'banners' => $banners,
            'offers' => $offers,
            'events' => $events,
            'user' => $user,
        );

        return array(
			'message' => __('message.fetch_records'),
			'data' => $data,
		);
    }

    public function saveAndroidAppLogs(Request $request){
        $user = \Auth::user();

        $dt = Carbon::now();
        $currentTime = $dt->toTimeString();
        $appWiseUsageTime = 0;
        $dayWiseUsageTime = 0;
        $totalUsageTime = 0;
        $totalIdleTime = 0;
        $wxrkEarned = 0;
        $wxrkSpent = 0;
        $wxrkBalance = 0;
        $totalTime = 1440;
        $dayWiseSummaryData = '';
        $dayWisePoolMaster = DayWisePoolMaster::whereDate('pool_date', date('Y-m-d'))
            ->first();
        $wxrkPerMinute = $dayWisePoolMaster ? $dayWisePoolMaster->wxrk_per_min : 0.00;
        $dayWiseSummaryData = DayWiseSummary::where('user_id', $user->id)
            ->whereDate('created_at', date('Y-m-d'))
            ->first();
        // dd($dayWiseSummaryData);
        // if($dayWiseSummaryData && ($dayWiseSummaryData->day_idle_time <= 0)){
        //     throw new ApiGenericException(__('message.donthave_enough', ['static' => __('static.idle_time')]));
        // }
        
        foreach($request->all() as $key => $data){
            $androidUsageLog = new AndroidUsageLog();
            $androidUsageLog->user_id = $user->id;
            $androidUsageLog->log_date = date('Y-m-d');
            $androidUsageLog->app_name = $data['app_name'];
            $androidUsageLog->package_name = $data['package_name'];
            $androidUsageLog->usage_time = ($data['usage_time']/60);
            $androidUsageLog->current_time = $currentTime;
            $androidUsageLog->status = 'active';
            $androidUsageLog->save();
        }

        $androidUsageData = AndroidUsageLog::select(
            \DB::raw('sum(usage_time) as total_usage_time, android_usage_logs.*')
        )
        ->whereDate('created_at', date('Y-m-d'))
        ->where('user_id', $user->id)
        ->groupBy('package_name')
        ->latest()
        ->get();
        // dd($androidUsageData);

        if($androidUsageData){
            foreach($androidUsageData as $data){
                $dayWiseUsageTime += $data->total_usage_time;
                $appUsageData = AppSummaryLog::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'package_name' => $data->package_name
                    ],
                    [
                        'user_id' => $user->id,
                        'log_date' => date('Y-m-d'),
                        'app_name' => $data->app_name,
                        'package_name' => $data->package_name,
                        'usage_time' => $data->total_usage_time,
                        'status' => 'active'
                    ]
                );
            }
        }

        if(!$dayWiseSummaryData){

            $dayWiseSummaryData = new DayWiseSummary();
            $dayWiseSummaryData->user_id = $user->id;
            $dayWiseSummaryData->user_type = 'android';
            $registrationTime = date('Y-m-d H:i:s', strtotime($user->created_at));
            $lastDayTime = date('Y-m-d 23:59:59');
            $l = date('Y-m-d H:i:s', strtotime($lastDayTime));
            $totalTime = ceil((strtotime($l) - strtotime($registrationTime))/60);
            $dayWiseSummaryData->total_app_usage_time = $dayWiseUsageTime;
            $totalIdleTime = $totalTime - $dayWiseSummaryData->total_app_usage_time;
            $wxrkEarned = $totalIdleTime*$wxrkPerMinute;
            $wxrkBalance = $wxrkEarned - $wxrkSpent;

            $dayWiseSummaryData->wxrk_per_minute = $wxrkPerMinute;
            $dayWiseSummaryData->day_total_time = $totalTime;
            $dayWiseSummaryData->day_idle_time = $totalIdleTime;
            $dayWiseSummaryData->wxrk_earned = $wxrkEarned;
            $dayWiseSummaryData->wxrk_spent = $wxrkSpent;
            $dayWiseSummaryData->wxrk_balance = $wxrkBalance;
            $dayWiseSummaryData->save();
        }
        else{
            $dayWiseSummaryData->total_app_usage_time = $dayWiseUsageTime;
            $totalIdleTime = $totalTime - $dayWiseSummaryData->total_app_usage_time;
            $wxrkEarned = $totalIdleTime*$wxrkPerMinute;
            $wxrkBalance = $wxrkEarned - $wxrkSpent;

            $dayWiseSummaryData->wxrk_per_minute = $wxrkPerMinute;
            $dayWiseSummaryData->day_total_time = $totalTime;
            $dayWiseSummaryData->day_idle_time = $totalIdleTime;
            $dayWiseSummaryData->wxrk_earned = $wxrkEarned;
            $dayWiseSummaryData->wxrk_spent = $wxrkSpent;
            $dayWiseSummaryData->wxrk_balance = $wxrkBalance;
            $dayWiseSummaryData->save();
        }

        return array(
            'message' => __('message.mapped_successfully', ['static' => __('static.offer')]),
            'total_idle_time' => $totalIdleTime,
            'daily_wise_summary_data' => $dayWiseSummaryData,
        );
    }

    public function saveIosAppLogs(Request $request){
        $user = \Auth::user();
        
        $dt = Carbon::now();
        $currentTime = $dt->toTimeString();
        $appWiseUsageTime = 0;
        $dayWiseUsageTime = 0;
        $totalUsageTime = 0;
        $totalIdleTime = 0;
        $wxrkEarned = 0;
        $wxrkSpent = 0;
        $wxrkBalance = 0;
        $totalTime = 1440;
        $dayWiseSummaryData = '';
        $dayWisePoolMaster = DayWisePoolMaster::whereDate('pool_date', date('Y-m-d'))
            ->first();
        $wxrkPerMinute = $dayWisePoolMaster ? $dayWisePoolMaster->wxrk_per_min : 0.00;
        $dayWiseSummaryData = DayWiseSummary::where('user_id', $user->id)
            ->where('user_type', '=', 'ios')
            ->whereDate('created_at', date('Y-m-d'))
            ->first();
        // dd($dayWiseSummaryData);
        // if($dayWiseSummaryData && ($dayWiseSummaryData->day_idle_time <= 0)){
        //     throw new ApiGenericException(__('message.donthave_enough', ['static' => __('static.idle_time')]));
        // }
        
        foreach($request->all() as $key => $data){
            $I = date('Y-m-d H:i:s', $data['timeStamp']);
            $idleTime = strtotime($I)/60;
            $androidUsageLog = new IosUsageLog();
            $androidUsageLog->user_id = $user->id;
            $androidUsageLog->log_date = date('Y-m-d');
            $androidUsageLog->event_name = $data['stateName'];
            $androidUsageLog->idle_time = $idleTime;
            $androidUsageLog->current_time = $currentTime;
            $androidUsageLog->timer_status = 'active';
            $androidUsageLog->save();

            if($data['stateName'] == 'Timer Started'){
                $iosIdleTime = IosIdleTime::where('user_id', $user->id)
                    ->whereDate('created_at', date('Y-m-d'))
                    ->first();
                if($iosIdleTime && $iosIdleTime->end_time == 'NULL'){
                    $iosIdleTime->end_time = $currentTime; 
                    $iosIdleTime->end_time = $currentTime; 
                    $iosIdleTime->idle_time = 0; 
                    $iosIdleTime->status = 'stopped'; 
                }
            }
        }

        if(!$dayWiseSummaryData){

            $dayWiseSummaryData = new DayWiseSummary();
            $dayWiseSummaryData->user_id = $user->id;
            $dayWiseSummaryData->user_type = 'ios';
            $registrationTime = date('Y-m-d H:i:s', strtotime($user->created_at));
            $lastDayTime = date('Y-m-d 23:59:59');
            $l = date('Y-m-d H:i:s', strtotime($lastDayTime));
            $totalTime = ceil((strtotime($l) - strtotime($registrationTime))/60);
            $dayWiseSummaryData->total_app_usage_time = 100;
            $totalIdleTime = $totalTime - $dayWiseSummaryData->total_app_usage_time;
            $wxrkEarned = $totalIdleTime*$wxrkPerMinute;
            $wxrkBalance = $wxrkEarned - $wxrkSpent;

            $dayWiseSummaryData->wxrk_per_minute = $wxrkPerMinute;
            $dayWiseSummaryData->day_total_time = $totalTime;
            $dayWiseSummaryData->day_idle_time = $totalIdleTime;
            $dayWiseSummaryData->wxrk_earned = $wxrkEarned;
            $dayWiseSummaryData->wxrk_spent = $wxrkSpent;
            $dayWiseSummaryData->wxrk_balance = $wxrkBalance;
            $dayWiseSummaryData->save();
        }
        else{
            $dayWiseSummaryData->total_app_usage_time = $dayWiseUsageTime;
            $totalIdleTime = $totalTime - $dayWiseSummaryData->total_app_usage_time;
            $wxrkEarned = $totalIdleTime*$wxrkPerMinute;
            $wxrkBalance = $wxrkEarned - $wxrkSpent;

            $dayWiseSummaryData->wxrk_per_minute = $wxrkPerMinute;
            $dayWiseSummaryData->day_total_time = $totalTime;
            $dayWiseSummaryData->day_idle_time = $totalIdleTime;
            $dayWiseSummaryData->wxrk_earned = $wxrkEarned;
            $dayWiseSummaryData->wxrk_spent = $wxrkSpent;
            $dayWiseSummaryData->wxrk_balance = $wxrkBalance;
            $dayWiseSummaryData->save();
        }

        $walletTransaction = new WalletTransaction();
        $walletTransaction->user_id = $user->id;
        $walletTransaction->offer_id = null;
        $walletTransaction->type = 'earned';
        $walletTransaction->wxrk_balance = $wxrkEarned;
        $walletTransaction->app_usage_time = "0.00";
        $walletTransaction->idle_time = $totalIdleTime;
        $walletTransaction->status = "active";
        $walletTransaction->save();

        return array(
            'message' => __('message.mapped_successfully', ['static' => __('static.offer')]),
            'total_idle_time' => $totalIdleTime,
            'daily_wise_summary_data' => $dayWiseSummaryData,
        );
    }

    public function androidAppPerformance(Request $request)
    {
        $user = \Auth::user();
        
        $lastDate = date('Y-m-d', strtotime('-7 days'));

        $weeklyAverage = '';
        $socialApps = '';
        $utilityApps = '';
        $productivityApps = '';
        $financialApps = '';
        
        $lastWeekData = AppSummaryLog::select(
            \DB::raw('sum(usage_time) as total_usage_time, app_summary_logs.*')
        )
        ->where('user_id', $user->id)
        ->whereDate('created_at', '>=', $lastDate)
        ->groupBy('package_name')
        ->orderBy('created_at', 'DESC')
        ->get();

        $todaysData = AppSummaryLog::select(
            \DB::raw('sum(usage_time) as total_usage_time, app_summary_logs.*')
        )
        ->where('user_id', $user->id)
        ->whereDate('created_at', '=', date('Y-m-d'))
        ->groupBy('package_name')
        ->orderBy('created_at', 'DESC')
        ->get();

        $dayWiseSummaryData = DayWiseSummary::where('user_id', $user->id)
            ->where('user_type', '=', 'android')
            ->whereDate('created_at', '>=', $lastDate)
            ->orderBy('created_at', 'DESC')
            ->get();

        $data = array(
            'weeklyAverage' => $weeklyAverage,
            'socialApps' => $socialApps,
            'utilityApps' => $utilityApps,
            'productivityApps' => $productivityApps,
            'financialApps' => $financialApps,
            'lastWeekData' => $lastWeekData,
            'todaysData' => $todaysData,
            'dayWiseSummaryData' => $dayWiseSummaryData,
        );

        return array(
			'message' => __('message.fetch_records'),
			'data' => $data,
		);
    }

    public function topTransactions(Request $request)
    {
        $user = \Auth::user();
        
        $transactions = WalletTransaction::with(
            [
                'user',
                'offer',
            ]
        )
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'DESC')
        ->take(5)
        ->get();

        $data = array(
            'transactions' => $transactions,
        );

        return array(
			'message' => __('message.fetch_records'),
			'data' => $data,
		);
    }

    public function transactions(Request $request)
    {
        $user = \Auth::user();

        $from_date = date('Y-m-d', strtotime('-30 days'));
        $to_date = date('Y-m-d');
        
        $transactions = WalletTransaction::with(
            [
                'user',
                'offer',
            ]
        )
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'DESC');

        if($request->from_date && $request->to_date){
            $from_date = $request->from_date;
            $to_date = $request->to_date;
            $transactions->whereDate('created_at',">=",date('Y-m-d',strtotime($request->from_date)))
                ->whereDate('created_at',"<=",date('Y-m-d',strtotime($request->to_date)));
        }else{
            $transactions->whereDate('created_at', '>=', $from_date)
                ->whereDate('created_at', '<=', $to_date);
        }

        $transactions = $transactions->get();

        $data = array(
            'from_date' => $from_date,
            'to_date' => $to_date,
            'transactions' => $transactions,
        );

        return array(
			'message' => __('message.fetch_records'),
			'data' => $data,
		);
    }

    public function getPromoCode($id)
    {
        $user = \Auth::user();

        $order = Order::where('offer_id', $id)
        ->where('user_id', $user->id)
        ->first();
        
        if(!$order){
            throw new ApiGenericException(__('message.doesnt_exist', ['static' => __('static.promo_code')]));
        }

        $data = array(
            'promoCode' => $order,
        );

        return array(
			'message' => __('message.fetch_records'),
			'data' => $data,
		);
    }

    public function indexPerformance(Request $request)
    {
        $user = \Auth::user();
        
        $dayWiseIosAppPerformance = DayWiseSummary::where('user_id', $user->id)
            ->where('user_type', '=', 'ios')
            ->orderBy('created_at', 'ASC')
            ->get();

        $dayWiseAndroidAppPerformance = AppSummaryLog::select(
            \DB::raw('sum(usage_time) as total_usage_time, app_summary_logs.*')
        )
        ->where('user_id', $user->id)
        ->groupBy('package_name')
        ->orderBy('created_at', 'ASC')
        ->get();

        $data = array(
            'ios_app_performace' => $dayWiseIosAppPerformance,
            'android_app_performace' => $dayWiseAndroidAppPerformance,
            'user' => $user,
        );

        return array(
			'message' => __('message.fetch_records'),
			'data' => $data,
		);
    }
   
    public function iosAppPerformance(Request $request)
    {
        $user = \Auth::user();
        
        $dayWiseIosAppPerformance = DayWiseSummary::where('user_id', $user->id)
            ->whereDate('created_at','>',date('Y-m-d',strtotime("-1 week")))
            ->orderBy('created_at', 'DESC')
            ->get();

        $data = array(
            'ios_app_performace' => $dayWiseIosAppPerformance,
        );

        return array(
			'message' => __('message.fetch_records'),
			'data' => $data,
		);
    }

    public function todayWatchTime(Request $request)
    {
        $user = \Auth::user();
        
        $todayWatchTime = DayWiseSummary::where('user_id', $user->id)
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->sum('watch_time');

        $todayWxrkBalance = UserWallet::where('user_id', $user->id)
            ->sum('wxrk_balance');

        $actualWxrkBalance = (double)$todayWxrkBalance;
        $todayWxrkBalance = round($todayWxrkBalance,1);
        if($todayWxrkBalance && ($todayWxrkBalance >= 1000)){
            $todayWxrkBalance = round(($todayWxrkBalance/1000),1). 'k';
        }

        $data = array(
            'today_watch_time' => (int)$todayWatchTime,
            'today_wxrk_balance' => (string)$todayWxrkBalance,
            'actual_wxrk_balance' => (string)$actualWxrkBalance,
        );

        return array(
			'message' => __('message.fetch_records'),
			'data' => $data,
		);
    }

    public function createdAtList()
    {
        $records = ConstantHelper::CREATED_AT;

        return array(
			'message' => __('message.fetch_records'),
			'data' => $records,
		);
    }

    public function unauthorized()
    {
        return view('frontend.dashboard.unauthorized', array('current_page' => ''));
    }

    public function notifications() {
        $notifications = MenuHelper::adminNotifications();

        return array(
			'message' => __('message.fetch_records'),
			'data' => $notifications,
		);
    }

    public function countryCodes() {
        $countryCodes = Country::select('dial_code')->get();

        return array(
			'message' => __('message.fetch_records'),
			'data' => $countryCodes,
		);
    }

    public function pushNotification(Request $request)
    {
        $userToken = OauthAccessToken::where('admin_id','=',$request->admin_id)
                        ->whereNotNull('firebase_id')
                        ->where('firebase_id', '!=', '0')
                        ->where('revoked', '=', 0)
                        ->orderBy('updated_at', 'DESC')
                        ->with('client')
                        ->first();
        if(!$userToken) {
            throw new ApiGenericException("NO user Token Found in Database");
        }
        $client = $userToken->client;

        if(!$client) {
            throw new ApiGenericException("NO Client in Database");
        }

        $dataSet = array(
            "to" => $userToken->firebase_id,
            "data" => [
                "body" => $request->description,
                "title" => $request->title,
                "type" => $request->type,
                "content_available" => true,
                "typeID" => $request->type_id,
                'userID' => $request->admin_id,
                "content_available" => true,
                "priority" => "high",
                "sound" => "default",
                "id" => $request->type_id,
                "image" => '',
                "link" => ''
            ]
        );

        return $this->sendPushNotification($dataSet);
	}
   

    // send Push notifications
    private function sendPushNotification($data)
    {
    	$headers = [
            'Authorization: key=' . config('app.firebase_key'),
            'Content-Type: application/json'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,  config('app.firebase_url'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $output = json_decode(curl_exec($ch), true);
        $err = curl_error($ch);

        curl_close($ch);

        return [
        	'response' => $output,
        	'error' => $err
        ];
    }

    // Logout Api
    public function logout() {
        $user = \Auth::guard('api')->user();
        $token = $user->token();
        $token->revoked = 1;
        $token->save();

        return array(
			'message' => __('message.logged_out_successfully'),
		);
    }

    // Deactivate User Api
    public function deactivateUser() {
        $user = \Auth::guard('api')->user();
        $token = $user->token();
        $token->revoked = 1;
        $token->save();

        $user->offers()->sync([]);
        $user->events()->sync([]);
        $user->wallet()->delete();
        $user->orders()->delete();
        $user->dayWiseSummaries()->delete();
        $user->delete();

        return array(
			'message' => __('message.deactivated_successfully', ['static' => __('static.user')]),
		);
    }
}