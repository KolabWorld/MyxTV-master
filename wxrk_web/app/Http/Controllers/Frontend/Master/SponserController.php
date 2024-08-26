<?php
namespace App\Http\Controllers\Frontend\Master;

use App\Models\Sponser;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Master as MasterValidator;

class SponserController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index(Request $request)
	{
		$user = \Auth::user();

		$records = Sponser::latest();

		if($request->status){
			$records->where('status',$request->status);
		}

		$records = $records->paginate(10);
		
		return view('frontend.master.sponser.index', array(
			'tab' =>'sponsers',
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

		$record = new Sponser();

		$action = '/sponser/create';

		return view('frontend.master.sponser.create_edit', array(
			'tab' =>'sponsers',
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
		
		$validator = (new MasterValidator($request))->storeSponser();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}
		
		$record = new Sponser();
		$record->fill($request->all());
        $record->save();

		return [
			'message' => 'Sponser Added Succesfully!!!'
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

		$record = Sponser::find($id);

		$action = '/sponser/'.$id.'/edit';

		return view('frontend.master.sponser.create_edit', array(
			'tab' =>'sponsers',
            'record' => $record,
            'action' => $action,
		));	
	}

	public function update(Request $request,$id)
	{ 
		$user = \Auth::user();

		$request->request->add(['id' => $id]);
		$validator = (new MasterValidator($request))->updateSponser();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}
		
		$record = Sponser::find($id);
		$record->fill($request->all());
        $record->save();

		return [
			'message' => 'Sponser Updated Succesfully!!!'
		];
	}

	public function destroy($id){
		$user = \Auth::user();

		$record = Sponser::find($id);
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