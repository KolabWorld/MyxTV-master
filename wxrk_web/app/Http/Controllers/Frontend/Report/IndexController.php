<?php 
namespace App\Http\Controllers\Admin\Report;

use DB;
use Auth;
use View;
use Input;
use Session;
use Datatables;
use Carbon\Carbon;

use App\User;
use App\Models\Role;
use App\Models\MailBox;
use App\Models\Department;
use App\Models\ClientGroup;
use App\Models\UserProfile;
use App\Models\SecurityQuestion;


use App\Models\UserWallet;
use App\Models\OrderPayment;
use App\Models\PaymentChannel;
use App\Models\PaymentTransaction;
use App\Models\UserWalletTransaction;

use App\Models\Address;
use App\Models\Country;
use App\Models\Language;
use App\Models\Currency;
use App\Models\SupportTicket;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserService;
use App\Models\ServerModule;
use App\Models\ProductService;
use App\Models\ConfigGroupService;
use App\Models\ServerWelcomeEmail;
use App\Models\ProductServicePrice;

use App\Helpers\GeneralHelper;
use App\Helpers\ConstantHelper;

use Illuminate\Http\Request;
use App\Services\Mailers\Mailer;
use App\Http\Controllers\AdminController;

class IndexController extends AdminController {
    public function __construct(){
        parent::__construct();
        View::share('menu_id','menu_report');
        View::share('submenu_id','');
    }

    public function index()
    {
        $status = Session::get('status');
        return view('admin.report.index',  
            array(
                'status' => $status
            )
        );
    }

    public function dailyWiseReports()
    {
        $status = Session::get('status');
        
        return view('admin.report.daily-wise-report',  
            array(
                'status' => $status
            )
        );
    }

}
        
