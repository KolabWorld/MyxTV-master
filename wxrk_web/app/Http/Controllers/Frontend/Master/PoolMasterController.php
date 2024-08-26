<?php
namespace App\Http\Controllers\Frontend\Master;

use App\Models\PoolMaster;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Master as MasterValidator;

class PoolMasterController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index(Request $request)
	{
		$user = \Auth::user();

		$records = PoolMaster::latest();

		if($request->status){
			$records->where('status',$request->status);
		}

		$records = $records->paginate(10);
		
		return view('frontend.master.pool-master.index', array(
			'tab' =>'pool-master',
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

		if($record = PoolMaster::latest()->first()){
			return redirect('/pool-master/'.$record->id.'/edit');
		}

		$record = new PoolMaster();
		$action = '/pool-master/create';

		return view('frontend.master.pool-master.create_edit', array(
			'tab' =>'pool-master',
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
		
		$validator = (new MasterValidator($request))->storePoolMaster();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}
		
		$record = new PoolMaster();
		$record->fill($request->all());
        $record->save();

		return [
			'message' => 'Pool-Master Added Succesfully!!!'
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

		$record = PoolMaster::find($id);

		$action = '/pool-master/'.$id.'/edit';

		return view('frontend.master.pool-master.create_edit', array(
			'tab' =>'pool-master',
            'record' => $record,
            'action' => $action,
		));	
	}

	public function update(Request $request,$id)
	{ 
		$user = \Auth::user();

		$request->request->add(['id' => $id]);
		$validator = (new MasterValidator($request))->updatePoolMaster();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}
		
		$record = PoolMaster::find($id);
		$record->fill($request->all());
        $record->save();

		return [
			'message' => 'Pool-Master Updated Succesfully!!!'
		];
	}

	public function destroy($id){
		$user = \Auth::user();

		$record = PoolMaster::find($id);
		if(count($record->events) > 0){
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
}