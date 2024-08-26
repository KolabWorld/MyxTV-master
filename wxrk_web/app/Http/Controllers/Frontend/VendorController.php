<?php
namespace App\Http\Controllers\Frontend;

use DB;
use View;
use Auth;
use Session;
use stdClass;
use Datatables;
use Carbon\Carbon;
use Illuminate\Support\Str;

use App\User;
use App\Models\Admin;
use App\Models\Role;
use App\Models\MailBox;

use Illuminate\Http\Request;
use App\Services\Mailers\Mailer;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Admin as AccountValidator;
use Illuminate\Validation\Rule;
use App\Helpers\ConstantHelper;
use App\Helpers\GeneralHelper;
use App\Models\Origin;
use App\Models\AdminProfile;
use App\Models\AdminSubscriptionPlan;
use App\Models\BusinessCategory;
use App\Models\Country;
use App\Models\SubscriptionPlan;
use Stripe\Subscription;

class VendorController extends AdminController
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

		$vendors = Admin::where('admin_type','vendor')->latest();

		if($request->status){
			$vendors->where('status',$request->status);
		}

		if($request->country_id){
			$vendors->whereHas('address', function($q) use ($request){
				$q->where('country_id',$request->country_id);
			});
		}

		if($request->from_date){
			$vendors->whereDate('created_at', '>=', $request->from_date);
		}

		if($request->to_date){
			$vendors->whereDate('created_at', '<=', $request->to_date);
		}

		$vendors = $vendors->paginate(10);
		$countries = Country::all();
		
		return view('frontend.vendors.index', array(
			'tab' =>'vendors',
            'request' => $request,
            'user' => $user,
            'vendors' => $vendors,
            'countries' => $countries,
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

		$vendor = new Admin();

		$businessCategories = BusinessCategory::where('status','active')->get();
		$countries = Country::where('status','active')->get();
		$origins = Origin::where('status','active')->get();
		
		$action = '/vendor/create';

		return view('frontend.vendors.create_edit', array(
			'tab' =>'vendors',
            'user' => $user,
            'request' => $request,
            'vendor' => $vendor,
            'businessCategories' => $businessCategories,
            'countries' => $countries,
            'origins' => $origins,
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
		
		$validator = (new AccountValidator($request))->store();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}

		//get trial plan
		$trialPlan = SubscriptionPlan::where('name', 'trial')->first();

		$vendor = new Admin();
		$vendor->fill($request->all());
		$vendor->admin_type = 'vendor';
        $vendor->remember_token = bcrypt(Str::random(6));
        $vendor->is_email_verified = 1;
        $vendor->status = 'pending';
        $vendor->subscription_plan_id = $trialPlan->id;
		$vendor->is_payment_done = 1;
		$vendor->save();

		//Map Trial Plan
		$expiresAt = date('Y-m-d H:i:s', strtotime('+7 day'));
		$vendorSubscriptionPlanMapping = new AdminSubscriptionPlan();
		$vendorSubscriptionPlanMapping->admin_id = $vendor->id;
		$vendorSubscriptionPlanMapping->subscription_plan_id = $vendor->subscription_plan_id;
		$vendorSubscriptionPlanMapping->plan_expires_at = $expiresAt;
		$vendorSubscriptionPlanMapping->status = 'paid';
		$vendorSubscriptionPlanMapping->save();

		$role = Role::where('alias','vendor')->first();
		
		$vendor->roles()->sync([$role->id]);
		$vendor->origins()->sync($request->origins);

		$vendor->address()->create([
			'line_1' => '',
			'country_id' => $request->country_id,
			'state_id' => $request->state_id,
			'city_id' => $request->city_id,
			'landmark' => $request->address,
			'postal_code' => $request->postal_code,
		]);

		$vendor->profile()->create([
			'who_we_are' => $request->who_we_are,
		]);

		if ($request->hasFile('logo')) {
            $vendor->addMediaFromRequest('logo')->toMediaCollection('logo');
        }

		if ($request->hasFile('image')) {
            $vendor->profile->addMediaFromRequest('image')->toMediaCollection('image');
        }

		if ($vendor->email) {
            $mailbox = new MailBox;

            $email = $vendor->email;
            // $name = $bpMaster->full_name;
            $description = 'Dear '.$vendor->name.'!<br/>
            <br/>
            You have been registered on the Portal. Please click below button to set your password for your account.<br/>
            <a href="'.config('app.url').'/reset-password?token='.$vendor->remember_token.'" class="btn-primary" itemprop="url" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #f06292; margin: 0; border-color: #f06292; border-style: solid; border-width: 8px 16px;">Set Password</a>
            <br/>
            Thanks<br/>
            Work Study';

            $mailSubject = "Account Created";

            $mailArray = array(
                "header" => "Account Created",
                "description" => $description,
                "mailSubject" => $mailSubject,
                "footer" => "System Generated Email"
            );

            $mailbox->mail_body = $mailArray;
            $mailbox->category = "Account Created";
            $mailbox->mail_to = $email;
            $mailbox->subject = "Account Created";
            $mailbox->layout = "email.email-template";
            $mailbox->save();	

            $mailer = new Mailer;
            $mailer->emailTo($mailbox);
        }

		return [
			'message' => 'Vendor Added Succesfully!!!'
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

		$vendor = Admin::find($id);

		$businessCategories = BusinessCategory::where('status','active')->get();
		$countries = Country::where('status','active')->get();
		$origins = Origin::where('status','active')->get();

		$action = '/vendor/'.$id.'/edit';

		return view('frontend.vendors.create_edit', array(
			'tab' =>'vendors',
            'user' => $user,
            'vendor' => $vendor,
            'businessCategories' => $businessCategories,
            'countries' => $countries,
			'origins' => $origins,
            'action' => $action,
		));	
	}

	public function update(Request $request,$id)
	{ 
		$user = \Auth::user();

		$request->request->add(['id' => $id]);
		$validator = (new AccountValidator($request))->update();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}
		
		$vendor = Admin::find($id);
		$vendor->fill($request->all());
		$vendor->save();

		$vendor->origins()->sync($request->origins);

		$vendor->address()->update([
			'line_1' => '',
			'country_id' => $request->country_id,
			'state_id' => $request->state_id,
			'city_id' => $request->city_id,
			'landmark' => $request->address,
			'postal_code' => $request->postal_code,
		]);

		$vendor->profile()->updateOrCreate([
			'who_we_are' => $request->who_we_are,
		]);

		if ($request->hasFile('logo')) {
            $vendor->addMediaFromRequest('logo')->toMediaCollection('logo');
        }

		if ($request->hasFile('image')) {
            $vendor->profile->addMediaFromRequest('image')->toMediaCollection('image');
        }

		return [
			'message' => 'Vendor Updated Succesfully!!!'
		];
	}

	public function destroy($id){
		$user = \Auth::user();

		$vendor = Admin::find($id);
		if(count($vendor->offers) > 0 || count($vendor->events) > 0){
			return [
				'message' => 'Please remove existing mappings to delete this record.',
			];
		}
		else{
			$vendor->business_category_id = null;
			$vendor->update();
			$vendor->delete();
		}

		return [
			'message' => 'Record deleted successfully!',
		];
	}
}