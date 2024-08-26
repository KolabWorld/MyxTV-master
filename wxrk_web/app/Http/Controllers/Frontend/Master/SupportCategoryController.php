<?php

namespace App\Http\Controllers\Frontend\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Master as MasterValidator;
use App\Models\SupportCategory;

class SupportCategoryController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
	}
    
    public function index(Request $request)
    { 

		$user = \Auth::user();
		$supportCategories = SupportCategory::whereNull('parent_id')->orderBy('id', 'DESC');

		if ($request->status) {
			$supportCategories->where('status', '=', $request->status);
		}

		$supportCategories = $supportCategories->paginate(10);

		return view('frontend.master.support-category.index', array(
			'tab' => 'support-categories',
			'supportCategories' => $supportCategories,
			'request' => $request,
			'user' => $user,
		));
	}
    
    
	public function create(Request $request)
	{
         
		$user = \Auth::user();
		$supportCategory = new SupportCategory();

		$action = '/support-category/create';

		return view('frontend.master.support-category.create', array(
			'tab' => 'support-categories',
            'request' => $request,
            'supportCategory' => $supportCategory,
            'action' => $action,
			'user' => $user,
		));
	}

	public function store(Request $request)
	{ 
		
		$validator = (new MasterValidator($request))->storeSupportCategory();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}

		$user = \Auth::user();
		$supportCategory = new SupportCategory();
		$supportCategory->fill($request->all());
		$supportCategory->save();

		return [
			'message' => 'Category Added Succesfully!!'
		];

	}

    public function edit($id)
	{

		$user = \Auth::user();
		$supportCategory = SupportCategory::find($id);
		
		$action = '/support-category/'.$id.'/edit';

		return view('frontend.master.support-category.edit', array(
			'tab' => 'support-categories',
            'supportCategory' => $supportCategory,
            'action' => $action,
			'user' => $user,
		));	
	}

    public function update(Request $request,$id)
	{ 

		$validator = (new MasterValidator($request))->updateSupportCategory();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}

		$supportCategory = SupportCategory::where('id','=',$id)->update([
        'name'=> $request->category_name
		]);

		return [
			'message' => 'Support Category Updated Succesfully!!!'
		];
	}
	

	public function destroy($id)
	{
		$user = \Auth::user();

		$supportCategory = SupportCategory::find($id);
		if(!$supportCategory) {
			return [
				'message' => 'Category doest not exist.',
			];
		} else {

			$supportCategory->delete();
		}

		return [
			'message' => 'Record deleted successfully!',
		];
	}

}