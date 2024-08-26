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
use Stripe\Subscription;

class TransactionHistoryController extends Controller
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

        $txns = PaymentTransaction::latest();
        if($auth->hasRole('vendor')){
            $txns->where('admin_id', $auth->id);
        }
        $txns = $txns->paginate(10);
        
        return view('frontend.transactions.index', [
            'tab' =>'transaction-history',
            'auth' => $auth,
            'txns' => $txns
        ]);
    }
}