<?php
namespace App\Http\Controllers\Admin\Master;

use App\Models\MainCategory;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\AdminController;

use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Admin\CategoryValidation as Validator;

class MainCategoryController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $parents = MainCategory::whereNull('parent_id')->get();

        $mainCategory = MainCategory::with('childs')
            ->whereNull('parent_id')->orderBy('id', 'DESC');

        if ($request->search) {
            $mainCategory->where('name', 'like', '%' . $request->search . '%');
        }

        $mainCategories = $mainCategory->paginate(10);

        return view('admin.master.main-category.index', [
            'parents' => $parents,
            'mainCategories' => $mainCategories,
        ]);
    }

    public function show()
    {
        return view('admin.main-category.view');
    }

    public function edit($id)
    {
        $mainCategory = MainCategory::find($id);
        $parents = MainCategory::whereNull('parent_id')->get();

        return view(
            'admin.master.main-category.edit',
            array(
                'parents' => $parents,
                'mainCategory' => $mainCategory
            )
        );
    }

    public function store(Request $request)
    {
        $auth = \Auth::guard('admin')->user();
        
        $validator = (new Validator($request))->storeMainCategory();
		if($validator->fails()){
			throw new ValidationException($validator);
		}

        $mainCategory = new MainCategory();
        $mainCategory->fill($request->all());
        $mainCategory->save();

        return [
            'message' => "Main Category added succesfully",
        ];
    }

    public function update(Request $request, $id)
    {
        $auth = \Auth::guard('admin')->user();

        $request->request->add(['id' => $id]);
		$validator = (new Validator($request))->updateMainCategory();
        if($validator->fails()){
            throw new ValidationException($validator);
		}
        
        $mainCategory = MainCategory::find($id);
        $mainCategory->fill($request->all());
        $mainCategory->update();

        return [
            'message' => "Main Category updated succesfully",
        ];
    }

    public function destroy($id)
    {
        $mainCategory = MainCategory::find($id);
        if($mainCategory && (count($mainCategory->childs) > 0)){
            return [
                'message' => "You can't delete this record, first delete its childs",
            ];    
        }
        $mainCategory->delete();

        return [
            'message' => "Main Category deleted succesfully",
        ];
    }
}