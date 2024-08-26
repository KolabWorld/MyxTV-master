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
use App\Models\Banner;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Banner as BannerValidator;
use Illuminate\Validation\Rule;

use App\Helpers\ConstantHelper;
use App\Helpers\GeneralHelper;

class BannerController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index(Request $request)
	{
		$user = \Auth::user();

		if($user->subscription_plan_id && ($user->is_payment_done == 0 || @$user->adminSubscriptionPlan->plan_expires_at <= date('Y-m-d H:i:s'))){
			return redirect('/subscription-plan-payment')->with(['warning' => 'Your Payment is pending for active plan']);
		}

		$banners = Banner::latest();

		if($request->status){
			$banners->where('status', $request->status);
		}

		if($request->type){
			$banners->where('type', '=', $request->type);
		}

        if($request->name){
			$banners->where('name', '=', $request->name);
		}

		$banners = $banners->paginate(10);
		
		return view('frontend.banner.index', array(
			'tab' =>'banners',
            'request' => $request,
            'user' => $user,
            'banners' => $banners
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

		if($user->subscription_plan_id && ($user->is_payment_done == 0 || @$user->adminSubscriptionPlan->plan_expires_at <= date('Y-m-d H:i:s'))){
			return redirect('/subscription-plan-payment')->with(['warning' => 'Your Payment is pending for active plan']);
		}

		$banner = new Banner();
        $types = ConstantHelper::BANNER_TYPES;
		$action = '/banner/create';

		return view('frontend.banner.create_edit', array(
			'tab' =>'banners',
            'types' => $types,
            'banner' => $banner,
            'action' => $action,
            'request' => $request,
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
		
        $validator = (new BannerValidator($request))->store();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}
		
		$banner = new Banner();
		$banner->fill($request->all());
		$banner->save();

		if ($request->hasFile('image')) {
            $banner->addMediaFromRequest('image')->toMediaCollection('image');
        }

		return [
			'message' => 'Banner Added Succesfully!!!'
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

		if($user->subscription_plan_id && ($user->is_payment_done == 0 || @$user->adminSubscriptionPlan->plan_expires_at <= date('Y-m-d H:i:s'))){
			return redirect('/subscription-plan-payment')->with(['warning' => 'Your Payment is pending for active plan']);
		}

		$banner = Banner::find($id);
        $types = ConstantHelper::BANNER_TYPES;
        $action = '/banner/'.$id.'/edit';

		return view('frontend.banner.create_edit', array(
			'tab' =>'banners',
            'types' => $types,
            'banner' => $banner,
            'action' => $action,
		));	
	}

	public function update(Request $request,$id)
	{ 
		$user = \Auth::user();

		$validator = (new BannerValidator($request))->update();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}
		
		$banner = Banner::find($id);
		$banner->fill($request->all());
		$banner->save();

		if ($request->hasFile('image')) {
            $banner->addMediaFromRequest('image')->toMediaCollection('image');
        }

		return [
			'message' => 'Banner Updated Succesfully!!!'
		];
	}

	public function destroy($id){
		$user = \Auth::user();

		$banner = Banner::find($id);
		if(!$banner){
			return [
				'message' => 'Banner does not exist.',
			];
		}
		else{
			$banner->delete();
		}

		return [
			'message' => 'Record deleted successfully!',
		];
	}
}