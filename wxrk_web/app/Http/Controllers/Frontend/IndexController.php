<?php 
namespace App\Http\Controllers\Frontend;

use DB;
use Auth;
use View;
use Input;
use Session;
use Datatables;
use Carbon\Carbon;

use App\User;
use App\Models\SubscriptionPlan;
use App\Models\StaticContent;
use App\Models\Contact;

use App\Helpers\GeneralHelper;
use App\Helpers\ConstantHelper;

use Illuminate\Http\Request;
use App\Services\Mailers\Mailer;
use App\Http\Controllers\Controller;

class IndexController extends Controller {

    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        $status = Session::get('status');
        $monthlySubscriptionPlans = SubscriptionPlan::where('plan_type', '=', 'monthly')
            ->orderBy('price', 'ASC')
            ->get();
        $yearlySubscriptionPlans = SubscriptionPlan::where('plan_type', '=', 'yearly')
            ->orderBy('price', 'ASC')
            ->get();

        return view('frontend.index.index',  
            array(
                'status' => $status,
                'yearlySubscriptionPlans' => $yearlySubscriptionPlans,
                'monthlySubscriptionPlans' => $monthlySubscriptionPlans

            )
        );
    }

    public function pagenotfound()
    {
        return view('frontend.index.page-not-found');
    }

    
    public function staticContent(Request $request,$alias)
    {
        $pageTypes = ConstantHelper::PAGE_TYPE;

        //dd($alias);
        
		if($static = StaticContent::where('page_type', '=', $alias)->first()){

            return view('frontend.index.static-content', array(
                'static' => $static,
                'pageTypes' => $pageTypes,
                
            ));
        }
        else {
            return redirect('/');
        }
        
    }

	public function submitForm(Request $request)
	{
       
		$contact = new Contact();
		$contact->fill($request->all());
		$contact->status = 'active';
		$contact->save();

        return redirect('/');
        	
	}


}