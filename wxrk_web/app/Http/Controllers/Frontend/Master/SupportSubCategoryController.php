<?php

namespace App\Http\Controllers\Frontend\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Master as MasterValidator;
use App\Models\SupportCategory;

class SupportSubCategoryController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
	}
    
    public function index(Request $request)
    { 

		$user = \Auth::user();
		$subCategories = SupportCategory::whereNotNull('parent_id')->with(['parent'])
			->orderBy('id', 'DESC');

		

		if ($request->status) {
			$subCategories->where('status', '=', $request->status);
		}

		$subCategories = $subCategories->paginate(10);


		//dd($subCategories);

		// foreach($subCategories as $key => $value) {
		// 	dd($value->children);
		// }

		return view('frontend.master.sub-category.index', array(
			'tab' => 'support-sub-categories',
			'subCategories' => $subCategories,
			'request' => $request,
			'user' => $user,
		));
	}
    
    
	public function create(Request $request)
	{
         
		$user = \Auth::user();
        $subCategory = new SupportCategory();
        $supportCategory = SupportCategory::whereNull('parent_id')->get();

		$action = '/sub-category/create';

		return view('frontend.master.sub-category.create', array(
			'tab' => 'support-sub-categories',
            'request' => $request,
            'subCategory' => $subCategory,
            'action' => $action,
			'user' => $user,
            //'subCategories'=> $subCategories,
            'supportCategory'=> $supportCategory,
		));
	}

	public function store(Request $request)
	{ 
		
		$validator = (new MasterValidator($request))->storeSubCategory();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}

		$user = \Auth::user();
		$subCategory = new SupportCategory();
		$subCategory->fill($request->all());
		$subCategory->save();

		return [
			'message' => 'Category Added Succesfully!!'
		];

		
	}

    public function edit($id)
	{

		$subCategory = SupportCategory::find($id);

		$supportCategory = SupportCategory::get()
			->toArray();

		$action = '/sub-category/'.$id.'/edit';

		return view('frontend.master.sub-category.edit', array(
			'tab' => 'support-sub-categories',
            'subCategory' => $subCategory,
			'supportCategory' =>$supportCategory,
            'action' => $action,
			//'user' => $user,
		));	
	}

    public function update(Request $request,$id)
	{ 
		
		$request->request->add(['id' => $id]);
		$validator = (new MasterValidator($request))->updateSubCategory();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}

		$user = \Auth::user();
		$subCategory = SupportCategory::find($id);
		$subCategory->fill($request->all());
		$subCategory->save();

		return [
			'message' => 'Support Sub-category Updated Succesfully!!!'
		];
	}
	

	public function destroy($id)
	{
		$user = \Auth::user();

		$subCategory = SupportCategory::find($id);
		if(!$subCategory) {
			return [
				'message' => 'Category doest not exist.',
			];
		} else {

			$subCategory->delete();
		}

		return [
			'message' => 'Record deleted successfully!',
		];
	}

}