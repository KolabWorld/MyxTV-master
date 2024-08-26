<?php
namespace App\Http\Controllers\Frontend\Master;

use App\Models\PriceView;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Master as MasterValidator;

class PriceViewController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index(Request $request)
	{
		$user = \Auth::user();

		$this->validate($request, [
            'from_date' => [
                'nullable', 'date',
            ],
            'to_date' => [
                'nullable', 'date', 'after_or_equal:from_date'
            ]
        ],[
            'to_date.after_or_equal' => 'Please select Proper Date Range'
        ]);

		$records = PriceView::latest();

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
		
		return view('frontend.master.price-view.index', array(
			'tab' =>'price-views',
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

		$record = new PriceView();

		$action = '/price-view/create';

		return view('frontend.master.price-view.create_edit', array(
			'tab' =>'price-views',
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
		
		$validator = (new MasterValidator($request))->storePriceView();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}
		
		$record = new PriceView();
		$record->fill($request->all());
        $record->created_by = $user->id;
		$record->save();

		return [
			'message' => 'Price View Added Succesfully!!!'
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

		$record = PriceView::find($id);

		$action = '/price-view/'.$id.'/edit';

		return view('frontend.master.price-view.create_edit', array(
			'tab' =>'price-views',
            'record' => $record,
            'action' => $action,
		));	
	}

	public function update(Request $request,$id)
	{ 
		$user = \Auth::user();

		$request->request->add(['id' => $id]);
		$validator = (new MasterValidator($request))->updatePriceView();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}
		
		$record = PriceView::find($id);
		$record->fill($request->all());
        $record->updated_by = $user->id;
		$record->save();

		return [
			'message' => 'Price View Updated Succesfully!!!'
		];
	}

	public function destroy($id){
		$user = \Auth::user();

		$record = PriceView::find($id);
		if(count($record->offers) > 0){
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