<?php
namespace App\Http\Controllers\Frontend\Master;

use App\Models\PlanName;
use App\Models\PlanType;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Master as MasterValidator;

class PlanNameController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index(Request $request)
	{
		$user = \Auth::user();

		$records = PlanName::latest();
		$planTypes =PlanType::get();

		if($request->status){
			$records->where('status',$request->status);
		}

		$records = $records->paginate(10);
		
		return view('frontend.master.plan-name.index', array(
			'tab' =>'pool-master',
            'user' => $user,
            'records' => $records,
            'planTypes' => $planTypes,
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$user = \Auth::user();
		
		$record = new PlanName();
		$planTypes = PlanType::get();
		$action = '/plan-name/create';

		return view('frontend.master.plan-name.create_edit', array(
			'tab' =>'plan-name',
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
		$user = \Auth::user();
		
		$validator = (new MasterValidator($request))->storePlanName();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}
		
		$record = new PlanName();
		$record->fill($request->all());
        $record->save();

		return [
			'message' => 'Plan-Master Added Succesfully!!!'
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
		$user = \Auth::user();

		$record = PlanName::find($id);
		$planTypes = PlanType::get();

		$action = '/plan-name/'.$id.'/edit';

		return view('frontend.master.plan-name.create_edit', array(
			'tab' =>'plan-name',
            'record' => $record,
            'action' => $action,
			'planTypes' => $planTypes,
		));	
	}

	public function update(Request $request,$id)
	{ 
		$user = \Auth::user();

		$request->request->add(['id' => $id]);
		$validator = (new MasterValidator($request))->updatePlanName();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}
		
		$record = PlanName::find($id);
		$planType = PlanType::get();
		$record->fill($request->all());
        $record->save();

		return [
			'message' => 'Plan-Name  Updated Succesfully!!!'
		];
	}

	public function destroy($id){
		$user = \Auth::user();

		$record = PlanName::find($id);
		// if(count($record->events) > 0){
		// 	return [
		// 		'message' => 'Please remove existing mappings to delete this record.',
		// 	];
		// }
		// else{
			$record->delete();
		//}

		return [
			'message' => 'Record deleted successfully!',
		];
	}
}