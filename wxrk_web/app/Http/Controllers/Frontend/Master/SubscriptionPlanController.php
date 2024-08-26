<?php
namespace App\Http\Controllers\Frontend\Master;

use DB;
use View;
use Auth;
use Session;
use stdClass;
use Datatables;
use Carbon\Carbon;

use App\Models\SubscriptionPlan;
use App\Models\SubscriptionPlanLog;
use App\Models\AdminSubscriptionPlan;

use Illuminate\Http\Request;
use App\Helpers\ConstantHelper;
use App\Http\Controllers\AdminController;

use Illuminate\Validation\ValidationException;
use App\Lib\Validation\SubscriptionPlan as SubscriptionPlanValidator;
use App\Models\PlanName;
use App\Models\PlanType;
use PhpParser\Node\Stmt\Else_;

class SubscriptionPlanController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index(Request $request)
	{
		$auth = Auth::guard('admin')->user();

		$records = SubscriptionPlan::latest();

		if($request->status){
			$records->where('status',$request->status);
		}

		if($request->from_date){
			$records->whereDate('created_at', '>=', $request->from_date);
		}

		if($request->to_date){
			$records->whereDate('created_at', '<=', $request->to_date);
		}

		$records = $records->paginate(10);
		
		return view('frontend.master.subscription-plan.index', array(
			'tab' =>'subscription-plans',
            'user' => $auth,
            'records' => $records,
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$auth = Auth::guard('admin')->user();

        $planTypes = ConstantHelper::PLAN_TYPE;
		$record = new SubscriptionPlan();
		$action = '/subscription-plan/create';

		return view('frontend.master.subscription-plan.create_edit', array(
			'tab' =>'subscription-plans',
            'request' => $request,
            'record' => $record,
            'action' => $action,
            'planTypes' => $planTypes,
		));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{ 
		$auth = Auth::guard('admin')->user();
		
		$validator = (new SubscriptionPlanValidator($request))->store();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}
		
		$record = new SubscriptionPlan();
		$record->fill($request->all());
        $record->created_by = $auth->id;
		$record->save();

		return [
			'message' => 'Subscription Plan Added Succesfully!!!'
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
		$auth = Auth::guard('admin')->user();

        $planTypes = ConstantHelper::PLAN_TYPE;
		$record = SubscriptionPlan::find($id);
		$action = '/subscription-plan/'.$id.'/edit';

		return view('frontend.master.subscription-plan.create_edit', array(
			'tab' =>'subscription-plans',
            'record' => $record,
            'action' => $action,
            'planTypes' => $planTypes,
		));	
	}

	public function update(Request $request,$id)
	{ 
		$auth = Auth::guard('admin')->user();

		$request->request->add(['id' => $id]);
		$validator = (new SubscriptionPlanValidator($request))->update();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}
		
		$record = SubscriptionPlan::find($id);
		$record->fill($request->all());
        $record->updated_by = $auth->id;
		$record->save();

		return [
			'message' => 'Subscription Plan Updated Succesfully!!!'
		];
	}

	public function destroy($id){
		$auth = Auth::guard('admin')->user();

		$record = SubscriptionPlan::find($id);
		if(count($record->adminSubscriptionPlans) > 0){
			return [
				'message' => 'Please remove existing mappings to delete this record.',
			];
		}
		else{
			$record->delete();
		}

		return [
			'message' => 'Record deleted successfully!',
		];
	}

	public function getSubscriptionPlans(Request $request){
		$auth = Auth::guard('admin')->user();

		$data = PlanName::where('plan_type_id', $request->plan_type_id)->get();

		return response()->json([
			'message' => 'Plans fetched successfully!',
			'data' => $data
		]);
	}
}