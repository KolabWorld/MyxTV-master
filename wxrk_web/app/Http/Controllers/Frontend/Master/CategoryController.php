<?php
namespace App\Http\Controllers\Admin\Master;

use App\Models\ProductCategory;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\AdminController;

use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Admin\CategoryValidation as Validator;

class CategoryController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $parents = ProductCategory::whereNull('parent_id')->get();

        $productCategory = ProductCategory::with('childs', 'categoryProducts')
            ->whereNull('parent_id')->orderBy('id', 'DESC');

        if ($request->search) {
            $productCategory->where('name', 'like', '%' . $request->search . '%');
        }

        $productCategories = $productCategory->paginate(10);

        return view('admin.master.category.index', [
            'parents' => $parents,
            'productCategories' => $productCategories,
        ]);
    }

    public function show()
    {
        return view('admin.ProductCategory.view');
    }

    public function edit($id)
    {
        $productCategory = ProductCategory::find($id);
        $parents = ProductCategory::whereNull('parent_id')->get();

        return view(
            'admin.master.category.edit',
            array(
                'parents' => $parents,
                'productCategory' => $productCategory
            )
        );
    }

    public function store(Request $request)
    {
        $auth = \Auth::guard('admin')->user();
        $validator = (new Validator($request))->storeProductCategory();
		if($validator->fails()){
			throw new ValidationException($validator);
		}

        $productCategory = new ProductCategory();
        $productCategory->fill($request->all());
        
        if($request->child_id){
            $productCategory->parent_id = $request->child_id;
        }
        else{
            $productCategory->parent_id = $request->parent_id;
        }

        $productCategory->save();

        return [
            'message' => "Product Category added succesfully",
        ];
    }

    public function update(Request $request, $id)
    {
        $auth = \Auth::guard('admin')->user();
        
        $request->request->add(['id' => $id]);
		$validator = (new Validator($request))->updateProductCategory();
        if($validator->fails()){
            throw new ValidationException($validator);
		}

        $productCategory = ProductCategory::find($id);
        $productCategory->fill($request->all());
        if($request->child_id){
            $productCategory->parent_id = $request->child_id;
        }
        else{
            $productCategory->parent_id = $request->parent_id;
        }
        $productCategory->update();

        return [
            'message' => "Product Category updated succesfully",
        ];
    }

    public function destroy($id)
    {
        $productCategory = ProductCategory::with('childs')->find($id);
        if($productCategory && (count($productCategory->childs)>0)){
            return [
                'message' => "You can't delete this record, first delete its childs",
            ];    
        }
        $productCategory->delete();

        return [
            'message' => "Product Category deleted succesfully",
        ];
    }

    public function getChilds(Request $request)
    {
        if($request->parent_id)
            $childs = ProductCategory::all()->where('parent_id', '=', $request->parent_id);
        else if($request->parent_ids) {
            $childs = ProductCategory::all()->whereIn('parent_id', json_decode($request->parent_ids,true));
        }
        else {
            $childs = ProductCategory::all();
        }
        
        $childsArray = array();
        foreach ($childs as $value) {
            $childsArray[$value->id] = $value->name;
        }
        
        return $childsArray;
    }
}