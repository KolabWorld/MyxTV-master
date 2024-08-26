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
use App\Models\Role;
use App\Models\Admin;
use App\Models\Order;
use App\Models\MailBox;

use Illuminate\Http\Request;
use App\Services\Mailers\Mailer;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AdminController;

use App\Helpers\GeneralHelper;
use App\Helpers\ConstantHelper;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Admin as AccountValidator;

use Illuminate\Support\Str;

class OrderController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index(Request $request)
	{
		$user = \Auth::user();
		$orders = Order::with(
			[
				'offer',
				'user',
				'admin',
			]
		)
		->orderBy('created_at', 'DESC');

		if(!$user->hasRole('admin')){
			$orders->where('created_by',$user->id);
		}
		
		$orders = $orders->paginate(10);

		
		return view('frontend.order.index', array(
			'tab' =>'orders',
            'user' => $user,
            'orders' => $orders,
            'request' => $request,
		));
	}

	/**
	 * Show the form for display the specified resource.
	 *
	 * @param $user
	 * @return Response
	 */
	public function view($id)
	{
		$user = \Auth::user();
		$order = Order::with(
			[
				'offer',
				'user',
				'admin',
			]
		)
		->find($id);

		return view('frontend.order.view', array(
			'tab' =>'view order',
            'user' => $user,
            'order' => $order,
		));
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
	 * Update the specified resource in storage.
	 *
	 * @param $user
	 * @return Response
	 */
	public function update(Request $request, User $user)
	{
		$auth = \Auth::user();
		$status = array();
		$request->request->add(['id' => $user->id]);

		//echo $request->id;exit;
		if (isset($request->id) && $request->id != "") {
			$validator = Validator::make($request->all(), [
				'name' => 'required',
				'email' => 'required',
				'mobile' => 'required',
			]);
		} else {
			$validator = (new Validator($request))->update();
		}
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}

		$input = $request->all();
		$user->fill($input);
		if ($request->password != "")
			$user->password = $request->password;
		$user->save();

		$status = array(
			'code' => 'success',
			'header' => 'Success',
			'messages' => array('User successfully updated')
		);
		return redirect('admin/users/' . $user->id . '/edit')->with('status', $status);
	}

}
