<?php
namespace App\Http\Controllers\Frontend\Master;

use App\Models\PlanType;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Master as MasterValidator;

class PlanTypeController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index(Request $request)
	{
		$user = \Auth::user();

		$records = PlanType::latest();

		if($request->status){
			$records->where('status',$request->status);
		}

		$records = $records->paginate(10);
		
		return view('frontend.master.plan-type.index', array(
			'tab' =>'plan-type',
            'user' => $user,
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
		$user = \Auth::user();
		if(($record = PlanType::count() == 2)){
			return redirect()->back()->with('warning', 'Maximum Two Plan Type can be Added.');
		}

		$record = new PlanType();
		$action = '/plan-type/create';

		return view('frontend.master.plan-type.create_edit', array(
			'tab' =>'plan-type',
            'request' => $request,
            'record' => $record,
            'action' => $action,
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
		
		$validator = (new MasterValidator($request))->storePlanType();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}
		
		$record = new PlanType();
		$record->fill($request->all());
        $record->save();

		return [
			'message' => 'Plan-Type Added Succesfully!!!'
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

		$record = PlanType::find($id);

		$action = '/plan-type/'.$id.'/edit';

		return view('frontend.master.plan-type.create_edit', array(
			'tab' =>'plan-type',
            'record' => $record,
            'action' => $action,
		));	
	}

	public function update(Request $request,$id)
	{ 
		$user = \Auth::user();

		$request->request->add(['id' => $id]);
		$validator = (new MasterValidator($request))->updatePlanType();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}
		
		$record = PlanType::find($id);
		$record->fill($request->all());
        $record->save();

		return [
			'message' => 'Plan-Type Updated Succesfully!!!'
		];
	}

	public function destroy($id){
		$user = \Auth::user();

		$record = PlanType::find($id);
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