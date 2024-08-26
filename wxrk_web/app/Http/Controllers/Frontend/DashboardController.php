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
use App\Models\Role;
use App\Models\Admin;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Country;
use App\Models\Address;
use App\Models\PromoCode;
use App\Models\AdminRole;
use App\Models\PaymentChannel;
use App\Models\OauthAccessToken;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionPlanLog;
use App\Models\AdminSubscriptionPlan;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\ConstantHelper;
use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use Spatie\MediaLibrary\Models\Media;

class DashboardController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        View::share('menu_id', 'menu_dashboard');
        View::share('submenu_id', 'NA');
    }

    public function index(Request $request)
    {
        $auth = Auth::guard('admin')->user();
        // dd($user);
        $totalCoupons = 0;
        $this->validate($request, [
            'from_date' => [
                'nullable', 'date',
            ],
            'to_date' => [
                'nullable', 'date', 'after_or_equal:from_date'
            ]
        ], [
            'to_date.after_or_equal' => 'Please select Proper Date Range'
        ]);

        $fromDate = date('Y') . '-01-01';
        $toDate = date('Y-m-d');

        if ($request->from_date) {
            $fromDate = $request->from_date;
        }
        if ($request->to_date) {
            $toDate = $request->to_date;
        }

        $offers = Offer::whereDate('created_at', '>=', $fromDate)
                    ->whereDate('created_at', '<=', $toDate)
                    ->orderBy('created_at', 'DESC');
        $promoCodes = PromoCode::whereDate('created_at', '>=', $fromDate)
                    ->whereDate('created_at', '<=', $toDate)
                    ->orderBy('created_at', 'DESC');
        $soldPromoCodes = PromoCode::whereDate('created_at', '>=', $fromDate)
                    ->whereDate('created_at', '<=', $toDate)
                    ->where('status', '=', 'sold')
                    ->orderBy('created_at', 'DESC');
        $earning = PaymentTransaction::whereDate('created_at', '>=', $fromDate)
                    ->whereDate('created_at', '<=', $toDate)
                    ->where('status', 'paid')->sum('amount');

        if ($auth->hasRoles(['vendor'])) {
            // $vendors = $vendors->where('created_by', $auth->id);
            $offers = $offers->where('created_by', $auth->id);
            $promoCodes = $promoCodes->where('created_by', $auth->id);
            $soldPromoCodes = $soldPromoCodes->where('created_by', $auth->id);
        } else {
            $offers = $offers;
            $promoCodes = $promoCodes;
            $soldPromoCodes = $soldPromoCodes;
        }

        // Country Wise Vendors
        $totalVendorContries = Country::withCount(
            ['addresses as total_admin' => function ($query) use ($fromDate, $toDate) {
                $query->where('addressable_type', 'App\Models\Admin')
                    // ->whereBetween('created_at', [$fromDate, $toDate]);
                    ->whereDate('created_at', '>=', $fromDate)
                    ->whereDate('created_at', '<=', $toDate);
            }]
        )->whereIn('name', ConstantHelper::COUNTRIES)->get();
        // dd($totalVendorContries);

        $labelVendorCountries = $totalVendorContries->pluck('name')->toArray();
        array_push($labelVendorCountries, 'Total');
        $totalVendors = $totalVendorContries->pluck('total_admin')->toArray();
        array_push($totalVendors, $totalVendorContries->sum('total_admin'));

        // Country Wise Users
        $totalUserContries = Country::withCount(
            ['users as total_user' => function ($query) use ($fromDate, $toDate) {
                $query->whereDate('created_at', '>=', $fromDate)
                    ->whereDate('created_at', '<=', $toDate);
            }]
        )->whereIn('name', ConstantHelper::COUNTRIES)->get();

        $labelUserCountries = $totalUserContries->pluck('name')->toArray();
        array_push($labelUserCountries, 'Total');
        $totalUsers = $totalUserContries->pluck('total_user')->toArray();
        array_push($totalUsers, $totalUserContries->sum('total_user'));

        $totalUsers = array_map('intval', $totalUsers);

        if ($auth->hasRoles(['vendor'])) {
            // $vendors = $vendors->where('created_by', $auth->id);
            // $offers = $offers->where('created_by', $auth->id);
            $labelVendorCountries = array();
            $totalVendors = array();
            $labelUserCountries = array();
            $totalUsers = array();
        }
        $offers = $offers->get();
        $soldOffers = $offers->where('remaining_promocodes', 0);
        // dd(count($offers), count($soldOffers));
        $promoCodes = $promoCodes->get();
        $soldPromoCodes = $soldPromoCodes->get();

        $offersTop5 = $offers->sortByDesc('sold_value')->take(5)->map(function ($offer) {
            if ($offer->sold_value) {
                return [
                    'sold_value' => $offer->sold_value,
                    'offer_name' => $offer->offer_name,
                    'vendor_name' => @$offer->createdBy->contact_person_name,
                ];
            }
        })->toArray();

        $vendors = Admin::where('admin_type', 'vendor')->get();

        $vendorsTop5 = $vendors->sortByDesc('offers_sold_value')->take(5)->map(function ($vendor) {
            if ($vendor->offers_sold_value) {
                return [
                    'offers_sold_value' => $vendor->offers_sold_value,
                    'vendor_name' => $vendor->contact_person_name,
                ];
            }
        })->toArray();
        // dd($totalVendors);

        return view('frontend.dashboard.index', [
            'tab' => 'dashboard',
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'auth' => $auth,
            'earning' => $earning,
            'offers' => $offers,
            'offersTop5' => array_filter($offersTop5),
            'vendorsTop5' => array_filter($vendorsTop5),
            'soldOffers' => $soldOffers,
            'totalUsers' => $totalUsers,
            'promoCodes' => $promoCodes,
            'totalVendors' => $totalVendors,
            'soldPromoCodes' => $soldPromoCodes,
            'labelUserCountries' => $labelUserCountries,
            'labelVendorCountries' => $labelVendorCountries,

        ]);
    }

    public function unauthorized()
    {
        return view(
            'frontend.dashboard.unauthorized',
            array(
                'current_page' => ''
            )
        );
    }

    public function logout()
    {
        \Auth::guard('admin')->logout();
        session_unset();
        \Session::forget('auth_access_token');
        \Session::flush();
        return redirect('/');
    }

    public function destroyMedia(Media $media)
    {
        $media->delete();

        return [
            'message' => "Record deleted successfully!",
        ];
    }

    public function getPayment()
    {
        $auth = Auth::guard('admin')->user();
        $subscriptionPlan = SubscriptionPlan::find($auth->subscription_plan_id);

        return view('frontend.dashboard.subscription-plan-payment', [
            'tab' => 'subscription-plan-payment',
            'auth' => $auth,
            'subscriptionPlan' => $subscriptionPlan,
        ]);
    }

    public function makePayment()
    {
        $auth = Auth::guard('admin')->user();
        $subscriptionPlan = SubscriptionPlan::find($auth->subscription_plan_id);
        if ($auth->hasRoles(['vendor'])) {
            // dd($subscriptionPlan);
            if ($subscriptionPlan->price > 0) {
                $paymentChannel = PaymentChannel::where('alias', '=', 'paypal')
                    ->first();

                // dd($paymentChannel);

                $paymentTransaction = $auth->paymentTransactions()->create(
                    [
                        'payment_channel_id' => $paymentChannel->id,
                        'admin_id' => $auth->id,
                        'payee_name' => $auth->name,
                        'payee_email' => $auth->email,
                        'payee_mobile' => $auth->mobile,
                        'amount' => $subscriptionPlan->price,
                        'currency_code' => 'USD'
                    ]
                );

                if ($paymentChannel->alias == "paypal") {

                    $orderID = 'paypal_' . Str::random();
                    $paymentTransaction->channel_order_id = $orderID;

                    $paymentTransaction->status = "created";
                    $paymentTransaction->save();

                    return view(
                        'frontend.paypal-payment',
                        array(
                            'paypalKey' => env('PAYPAL_KEY', ''),
                            'auth' => $auth,
                            'subscriptionPlan' => $subscriptionPlan,
                            'paymentTransaction' => $paymentTransaction,
                        )
                    );
                }
            }
        }
    }

    public function subscriptionPlanUpgrade()
    {
        $auth = Auth::guard('admin')->user();
        $subscriptionPlans = SubscriptionPlan::where('id', '!=', $auth->subscription_plan_id)->get();

        return view('frontend.dashboard.subscription-plan-upgrade', [
            'tab' => 'subscription-plan-payment',
            'auth' => $auth,
            'subscriptionPlans' => $subscriptionPlans,
        ]);
    }

    public function subscribePlan(Request $request, $id)
    {
        $auth = Auth::guard('admin')->user();
        $subscriptionPlan = SubscriptionPlan::find($id);

        $lastPaidPlanLog = SubscriptionPlanLog::where('admin_id', '=', $auth->id)
            ->where('status', '=', 'paid')
            ->latest()
            ->first();

        $existingPlan = $auth->subscriptionPlan;

        $planTakenOn = strtotime(date('Y-m-d', strtotime(@$auth->adminSubscriptionPlan->created_at)));
        $currentDate = strtotime(date('Y-m-d'));
        $datediff = $currentDate - $planTakenOn;

        $usedDays = round($datediff / (60 * 60 * 24));

        if (!$usedDays) {
            $usedDays = 1;
        }

        $planAmount = $lastPaidPlanLog->plan_amount;
        $remainingAmount = 0;
        $amountToBePaid = $subscriptionPlan->price;

        if (strtolower($existingPlan->plan_type) == 'monthly') {
            $remainingAmount = ($planAmount * (30 - $usedDays)) / 30;
        } else if (strtolower($existingPlan->plan_type) == 'yearly') {
            $remainingAmount = ($planAmount * (365 - $usedDays)) / 365 - $usedDays;
        }
        $remainingAmount = number_format((float)$remainingAmount, 2, '.', '');
        $amountToBePaid -= $remainingAmount;

        if ($auth && ($existingPlan->offers_in_a_month < $subscriptionPlan->offers_in_a_month)) {

            //update paid log
            $lastPaidPlanLog->remaining_paid_amount = $remainingAmount;
            $lastPaidPlanLog->used_days = $usedDays;
            $lastPaidPlanLog->update();

            $subscriptionPlanLog = new SubscriptionPlanLog();
            $subscriptionPlanLog->admin_id = $auth->id;
            $subscriptionPlanLog->paid_amount = $amountToBePaid;
            $subscriptionPlanLog->subscription_plan_id = $id;
            $subscriptionPlanLog->status = 'upgrade';
            $subscriptionPlanLog->save();

            return view('frontend.dashboard.subscription-plan-upgrade-payment', [
                'auth' => $auth,
                'subscriptionPlan' => $subscriptionPlan,
                'usedDays' => $usedDays,
                'planAmount' => $planAmount,
                'remainingAmount' => $remainingAmount,
                'amountToBePaid' => $amountToBePaid,
                'subscriptionPlanLog' => $subscriptionPlanLog,
            ]);
        } else {
            return back()->with('warning', "You cannot downgrade please select a upgradable plan.");
        }
    }

    public function subscriptionPlanUpgradePayment(Request $request)
    {
        // dd($request->all());
        $auth = Auth::guard('admin')->user();
        $subscriptionPlanLog = SubscriptionPlanLog::find($request->subscription_plan_log_id);

        // dd($request->subscription_plan_log_id, $subscriptionPlanLog);
        $subscriptionPlan = SubscriptionPlan::find($subscriptionPlanLog->subscription_plan_id);
        if ($auth->hasRoles(['vendor'])) {
            // dd($subscriptionPlan);
            if ($subscriptionPlanLog->paid_amount > 0) {
                $paymentChannel = PaymentChannel::where('alias', '=', 'paypal')
                    ->first();

                // dd($paymentChannel);

                $paymentTransaction = $auth->paymentTransactions()->create(
                    [
                        'payment_channel_id' => $paymentChannel->id,
                        'user_id' => $auth->id,
                        'admin_id' => $auth->id,
                        'payee_name' => $auth->name,
                        'payee_email' => $auth->email,
                        'payee_mobile' => $auth->mobile,
                        'amount' => $subscriptionPlanLog->paid_amount,
                        'currency_code' => 'USD'
                    ]
                );

                if ($paymentChannel->alias == "paypal") {

                    $orderID = 'paypal_' . Str::random();
                    $paymentTransaction->channel_order_id = $orderID;

                    $paymentTransaction->status = "created";
                    $paymentTransaction->save();

                    return view(
                        'frontend.paypal-payment',
                        array(
                            'paypalKey' => env('PAYPAL_KEY', ''),
                            'auth' => $auth,
                            'subscriptionPlan' => $subscriptionPlan,
                            'subscriptionPlanLog' => $subscriptionPlanLog,
                            'paymentTransaction' => $paymentTransaction,
                        )
                    );
                }
            }
        }
    }
}
