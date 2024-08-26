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
use App\Models\Role;
use App\Models\Admin;
use App\Models\Country;
use App\Models\MailBox;
use App\Models\IosIdleTime;
use App\Models\IosUsageLog;
use App\Models\AppSummaryLog;
use App\Models\DayWiseSummary;
use App\Models\AndroidUsageLog;
use App\Models\DayWisePoolMaster;

use App\Helpers\GeneralHelper;
use App\Helpers\ConstantHelper;

use Illuminate\Http\Request;
use App\Services\Mailers\Mailer;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Admin as AccountValidator;
use App\Models\BusinessCategory;
use App\Models\Origin;
use App\Models\UserWallet;
use App\Models\UserWalletTransaction;
use App\Models\WalletTransaction;
use Illuminate\Validation\Rule;

class UserController extends AdminController
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
		], [
			'to_date.after_or_equal' => 'Please select Proper Date Range'
		]);

		$users = User::with([
			'country'
		])
			->latest();

		if ($request->status) {
			$users->where('status', $request->status);
		}

		if ($request->country_id) {
			$users->whereHas('address', function ($q) use ($request) {
				$q->where('country_id', $request->country_id);
			});
		}

		if ($request->from_date) {
			$users->whereDate('created_at', '>=', $request->from_date);
		}

		if ($request->to_date) {
			$users->whereDate('created_at', '<=', $request->to_date);
		}

		$users = $users->paginate(10);

		return view('frontend.users.index', array(
			'tab' => 'users',
			'request' => $request,
			'user' => $user,
			'users' => $users,
		));
	}

	public function loginAsUser(Request $request, User $user)
	{

		$auth = \Auth::user();
		$request->session()->put('admin', $auth);

		\Auth::login($user);
		return redirect('/');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$user = new User;

		return view('frontend.users.create_edit', array(
			'tab' => 'users',
			'request' => $request,
			'user' => $user,
		));
	}

	public function view(Request $request, $id)
	{
		$user = User::with('wallet')->find($id);
		$countries = Country::all();


		$dayWiseSummaryData = DayWiseSummary::where('user_id', $user->id)
			->whereDate('created_at', date('Y-m-d'))
			->first();

		$dayWiseIosAppPerformance = DayWiseSummary::where('user_id', $user->id)
			->where('user_type', '=', 'ios')
			->orderBy('created_at', 'ASC')
			->get();

		// $dayWiseCollection = DayWiseSummary::where('user_id', $user->id)
		// 	->orderBy('created_at', 'DESC')
		// 	->get();

		$dayWiseCollection = WalletTransaction::where('user_id', $user->id)
			->orderBy('created_at', 'DESC')
			->get();

		$dayWiseAndroidAppPerformance = AppSummaryLog::select(
			\DB::raw('sum(usage_time) as total_usage_time, app_summary_logs.*')
		)
			->where('user_id', $user->id)
			->groupBy('package_name')
			->orderBy('created_at', 'ASC')
			->get();

		// $totalWatchTime = DayWiseSummary::where('user_id', $user->id)
		// 	->sum('watch_time');
		// $wxrkEarned = DayWiseSummary::where('user_id', $user->id)
		// 	->sum('wxrk_earned');
		// $wxrkSpent = DayWiseSummary::where('user_id', $user->id)
		// 	->sum('wxrk_spent');
		// $wxrkBalance = DayWiseSummary::where('user_id', $user->id)
		// 	->sum('wxrk_balance');

		return view('frontend.users.view', array(
			'tab' => 'users',
			'user' => $user,
			'request' => $request,
			'countries' => $countries,
			// 'total_spent' => $wxrkSpent,
			// 'total_earned' => $wxrkEarned,
			// 'total_balance' => $wxrkBalance,
			// 'total_watch_time' => $totalWatchTime,
			'day_wise_summary' => $dayWiseSummaryData,
			'dayWiseCollection' => $dayWiseCollection,
			'ios_app_performace' => $dayWiseIosAppPerformance,
			'androidAppPerformace' => $dayWiseAndroidAppPerformance,
		));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$auth = \Auth::user();
		$status = array();

		$validator = (new Validatorf($request))->store();

		//dd($validator);
		if ($validator->fails()) {
			//if (false) { Commented Temporary
			throw new ValidationException($validator);
		}

		try {
			$currencyId = null;
			$country = Country::find($request->country_id);
			if ($country) {
				if ($country->name == 'India') {
					session()->put('currency', 'INR');
					$currencyId = 1;
				} else {
					session()->put('currency', 'AUD');
					$currencyId = 2;
				}
			}
			$user = new User();
			$user->fill($request->all());
			$user->user_name = $request->email;
			if (isset($request->user_type) && $request->user_type == "user")
				$user->user_type = "user";

			$user->currency_id = $currencyId;
			//  dd($user);
			$user->save();

			if ($request->line_1) {
				$user->address()->create($request->all());
			}
			$msg = 'New user successfully created';
			if (isset($request->user_type) && $request->user_type == "user")
				$msg = 'New user successfully created, please complete profile before any activity.';
			$status = array(
				'code' => 'success',
				'header' => 'Success',
				'messages' => array($msg)
			);
		} catch (\Exception $e) {
			//	dd($e);
			if (strpos($e->getMessage(), 'Duplicate') !== false) {
				$status['code'] = 'danger';
				$status['header'] = 'Alert';
				$status['messages'] = array('Username already exists');
			}
			return redirect('admin/users/create')->with('status', $status);
		}
		if (isset($request->user_type) && $request->user_type == "user")
			return redirect('/admin/users/' . $user->id . '/view/profile')->with('status', $status);
		return redirect('admin/users/')->with('status', $status);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param $user
	 * @return Response
	 */
	public function edit(User $user)
	{
		View::share('tab_id', 'tab_create_edit');
		$status = Session::get('status');

		$departments = Department::all();

		return View::make('admin.users.create_edit', array(
			'user' => $user,
			'status' => $status,
			'departments' => $departments
		));
	}

	/**
	 * Show users details.
	 *
	 * @param $user
	 * @return Response
	 */
	public function profile(User $user)
	{
		$vendor = \Auth::user();
		$status = Session::get('status');

		$action = '/profile';
		$businessCategories = BusinessCategory::where('status', 'active')->get();
		$countries = Country::where('status', 'active')->get();
		$origins = Origin::where('status', 'active')->get();

		if (!$vendor->hasRole('vendor')) {
			$view = 'frontend.users.profile.admin-profile';
		} else {
			$view = 'frontend.users.profile.profile';
		}

		return view(
			$view,
			array(
				'vendor' => $vendor,
				'action' => $action,
				'businessCategories' => $businessCategories,
				'countries' => $countries,
				'origins' => $origins,
			)
		);
	}


	/**
	 * update users details.
	 *
	 * @param $user
	 * @return Response
	 */
	public function updateAccount(Request $request)
	{
		$user = \Auth::user();

		if ($user->hasRole('vendor')) {
			$validator = (new AccountValidator($request))->update();
		} else {
			$validator = (new AccountValidator($request))->updateAdmin();
		}

		if ($validator->fails()) {
			throw new ValidationException($validator);
		}

		$user->fill($request->all());
		if ($request->new_password)
			$user->password = $request->new_password;
		$user->save();

		$user->origins()->sync($request->origins);

		$user->address()->updateOrCreate([
			'line_1' => '',
			'country_id' => $request->country_id,
			'state_id' => $request->state_id,
			'city_id' => $request->city_id,
			'landmark' => $request->address,
			'postal_code' => $request->postal_code,
		]);

		// $user->profile()->updateOrCreate([
		// 	'who_we_are' => $request->who_we_are,
		// ]);

		if ($request->hasFile('logo')) {
			$user->addMediaFromRequest('logo')->toMediaCollection('logo');
		}

		if ($request->hasFile('image')) {
			$user->profile->addMediaFromRequest('image')->toMediaCollection('image');
		}

		return [
			'message' => 'Profile Updated Succesfully!!!'
		];
	}


	/**
	 * Reset password.
	 *
	 * @param $user
	 * @return Response
	 */
	public function resetPassword(Request $request, User $user)
	{
		$auth = \Auth::user();
		$status = Session::get('status');

		$password = Str::random(8);

		$user->password = $password;
		$user->save();

		$user->sendNewPasswordMail($password);

		$status = array(
			'code' => 'success',
			'header' => 'Success',
			'messages' => array("Password has been reset and shared by mail")
		);

		return redirect('/admin/users/' . $user->id . '/view/profile')->with('status', $status);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param $user
	 * @return Response
	 */
	public function update(Request $request, User $user)
	{
		$auth = \Auth::user();
		$user->fill($request->all());
		$user->save();

		if ($request->hasFile('profile_pic')) {
			$user->addMediaFromRequest('profile_pic')->toMediaCollection('profile_pic');
		}

		return [
			'message' => 'User updated Successfully!!!',
		];
	}

	public function getRoles(User $user)
	{
		$status = Session::get('status');

		$roles = Role::all();

		return View::make('admin.users.roles', array('user' => $user,  'status' => $status, 'roles' => $roles));
	}

	public function updateRoles(Request $request, User $user)
	{

		try {
			$user->roles()->detach();

			foreach ($request->roles as $roleId) {
				$role = Role::find($roleId);
				$user->roles()->attach($role);
			}

			$status = array(
				'code' => 'success',
				'header' => 'Success',
				'messages' => array('Roles successfully updated')
			);
			return redirect('/admin/users/' . $user->id . '/roles')->with('status', $status);
		} catch (Exception $e) {
			dd($e->getMessage());
		}
	}

	public function getPermissions($id)
	{
		View::share('tab_id', 'tab_permissions');
		$status = Session::get('status');
		$user = User::find($id);
		$permissions_model = Permission::all();
		$permissions = array();
		foreach ($permissions_model as $key => $value) {
			$permissions[$value->id] = $value->name;
		}
		return View::make('admin.users.create_edit_permissions', array('user' => $user,  'status' => $status, 'permissions' => $permissions));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param $user
	 * @return Response
	 */
	public function delete(User $user, Request $request)
	{
		$user->delete();
		$type = $request->type;
		$status = array(
			'code' => 'success',
			'header' => 'Success',
			'messages' => array('User successfully deleted')
		);
		return redirect('admin/users?type=' . $type)->with('status', $status);
	}

	public function destroy(User $user, Request $request)
	{
		$user->forceDelete();
		$type = $request->type;
		$status = array(
			'code' => 'success',
			'header' => 'Success',
			'messages' => array('User successfully deleted from database.')
		);
		return redirect('admin/users?type=' . $type)->with('status', $status);
	}

	public function destroyall(Request $request)
	{
		foreach ($request->deleteids_arr as $deleteids_arrid) {
			User::where('id', $deleteids_arrid)->forceDelete();
		}
		//$type = $request->type;
		//$status = array(
		//	'code' => 'success',
		//	'header' => 'Success',
		//	'messages' => array('User successfully deleted from database.')
		//	);
		//return redirect('admin/users?type=' . $type)->with('status', $status);
	}

	public function restore($id, Request $request)
	{
		$user = User::withTrashed()->find($id);
		$user->restore();
		$type = $request->type;
		$status = array(
			'code' => 'success',
			'header' => 'Success',
			'messages' => array('User successfully restored')
		);
		return redirect('admin/users?type=' . $type)->with('status', $status);
	}

	/**
	 * Show a list of all the languages posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	public function changePassword()
	{
		$user = \Auth::user();

		if ($user) {
			return view(
				'frontend.users.profile.change-password',
				array(
					'user' => $user,
				)
			);
		} else {
			return redirect('/dashboard');
		}
	}

	public function updatePassword(Request $request)
	{
		$user = \Auth::user();
		$validator = (new AccountValidator($request))->userChangePassword();

		if ($validator->fails()) {
			throw new ValidationException($validator);
		}

		if ($user) {
			$user->password = $request->new_password;
			$user->save();

			return redirect('/change-password')->with(['success' => "Password changed successfully!!!"]);
		} else {
			return redirect('/change-password')->with(['error' => "Something went wrong. Please try again!!!"]);
		}
	}
}
