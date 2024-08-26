<?php

namespace App\Http\Controllers\Frontend\Master;

use Auth;

use App\Models\StaticContent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AdminController;

use Illuminate\Validation\ValidationException;
use App\Lib\Validation\StaticContent as StaticContentValidator;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\ConstantHelper;


class StaticContentController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index(Request $request)
	{
		$user = \Auth::user();

		$statics = StaticContent::orderBy('id', 'DESC');

		if ($request->search) {
			$keyword = $request->search;
			$statics->where(function ($q) use ($keyword) {
				$q->where('name', 'LIKE', '%' . $keyword . '%');
			});
		}

		$statics = $statics->paginate(10);

		return view('frontend.master.static-content.index', array(
			'tab' => 'static-content',
			'user' => $user,
			'statics' => $statics,
			'request' => $request,
		));
	}

	public function create(Request $request)
	{
		$user = \Auth::user();
        
		$pageTypes = ConstantHelper::PAGE_TYPE;
		$static = new StaticContent();
		$action = '/static-content/create';

		return view('frontend.master.static-content.create_edit', array(
			'tab' => 'static-content',
			'user' => $user,
			'static' => $static,
			'action' => $action,
			'request' => $request,
			'pageTypes' => $pageTypes,
		));
	}


	public function store(Request $request)
	{
        
		$user = Auth::user();

		$validator = (new StaticContentValidator($request))->store();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}

		$static = new StaticContent();
		$static->fill($request->all());
		$static->status = 'active';
		$static->save();
        
		return [
			'message' => 'Static Content Added Succesfully!!!'
		];
		
	}

	public function edit($id)
	{
		$user = Auth::user();
       
		$pageTypes = ConstantHelper::PAGE_TYPE;
		$static = StaticContent::find($id);
		
		$action = '/static-content/' . $id . '/edit';

		return view('frontend.master.static-content.create_edit', array(
			'tab' => 'static-content',
			'user' => $user,
			'static' => $static,
			'action' => $action,
			'pageTypes' => $pageTypes,
		));
	}


	public function update(Request $request, $id)
	{

		$static = StaticContent::find($id);
		$static->fill($request->all());
		$static->save();

		return [
			'message' => 'Static Content Updated Succesfully!!!'
		];
	}


	public function destroy($id)
	{
        
		//$user = \Auth::user();
		$static = StaticContent::find($id);
		if (!$static) {
			return [
				'message' => 'Static Content doest not exist.',
			];
		} else {

			$static->delete();
		}

		return [
			'message' => 'Record deleted successfully!',
		];
	}


}
