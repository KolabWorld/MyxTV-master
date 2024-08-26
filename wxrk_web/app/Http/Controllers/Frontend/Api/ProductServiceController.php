<?php namespace App\Http\Controllers\Admin\Api;

use Session;

use App\Models\SeoDetail;
use App\Models\ProductServiceAttribute;

use Illuminate\Http\Request;
use App\Helpers\ConstantHelper;
use App\Http\Controllers\AdminController;

class ProductServiceController extends AdminController {
    public function __construct(){
        parent::__construct();
    }

    public function productServiceAttributes($productServiceId)
    {
        $auth = \Auth::user();
        $status = Session::get('status');
        $productAttributes = ProductServiceAttribute::where('product_service_id', '=', $productServiceId)
            ->orderBy('id','ASC')
            ->get();

        return $productAttributes;
    }

    public function addProductServiceAttribute(Request $request) {
        
        $auth = \Auth::user();
		
        $attribute = new ProductServiceAttribute();
        $attribute->product_service_id = $request->product_service_id;
        $attribute->name = $request->name;
        $attribute->created_by = $auth->id;
        $attribute->save();

        return $attribute;
    }

    public function deleteProductServiceAttribute($id) {
		$psAttribute = ProductServiceAttribute::find($id);
        $psAttribute->delete();
        
		return ['success' => true];
	}

    public function seoDetail($productServiceId)
    {
        $auth = \Auth::user();
        $status = Session::get('status');
        $seo = SeoDetail::where('product_service_id', '=', $productServiceId)
            ->first();

        return $seo;
    }

    public function addSeoDetail(Request $request) {
        
        $auth = \Auth::user();
        
        if($request->id){
            $seo = SeoDetail::where('product_service_id', '=', $productServiceId)
                ->first();
        }
        else{
            $seo = new SeoDetail();
        }
        $seo->fill($request->all());
        $attribute->created_by = $auth->id;
        $attribute->save();

        return $attribute;
    }
   
}
        
