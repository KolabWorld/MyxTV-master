<?php
namespace App\Http\Controllers\Frontend;

use DB;
use View;
use Auth;
use Session;
use stdClass;
use Datatables;
use Carbon\Carbon;

use App\User;
use App\Models\Admin;
use App\Models\Offer;
use App\Models\PromoCode;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Offer as PromoCodeValidator;
use Illuminate\Validation\Rule;

use App\Helpers\GeneralHelper;
use App\Helpers\ConstantHelper;

class PromoCodeController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{ 
		$user = \Auth::user();
		// dd($request->all());
		$validator = (new PromoCodeValidator($request))->storePromocode();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}
		
		if($request->promo_codes && count($request->promo_codes)){
            $offer = Offer::find($request->offer_id);
            $stock = $offer->stock ?: 0;
            foreach($request->promo_codes as $key => $val){
                $promoCode = new PromoCode();
                $promoCode->offer_id = $request->offer_id;
                $promoCode->promo_code = $val['promo_code'];
                $promoCode->status = 'active';
                $promoCode->created_by = $user->id;
                $promoCode->save();

                $stock += 1;
            }
            $offer->stock = $stock;
            $offer->save();
        }

        return [
			'message' => 'Promocode Added Succesfully!!!'
		];
	}

	public function destroy($id){
		$user = \Auth::user();

		$promoCode = PromoCode::find($id);
		if(!$promoCode){
			return [
				'message' => 'Promocode doest not exist.',
			];
		}
		else{
            $offer = Offer::find($promoCode->offer_id);
			$promoCode->delete();
            $offer->stock -= 1;
            $offer->save();
		}
        
		return [
			'message' => 'Record deleted successfully!',
		];
	}	
}
