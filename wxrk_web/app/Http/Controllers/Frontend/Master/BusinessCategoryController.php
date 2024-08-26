<?php

namespace App\Http\Controllers\Frontend\Master;

use DB;
use View;
use Auth;
use Session;
use Datatables;
use Carbon\Carbon;
use stdClass;

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
use App\Lib\Validation\Master as MasterValidator;
use Illuminate\Validation\Rule;
use App\Helpers\ConstantHelper;
use App\Helpers\GeneralHelper;
use App\Models\Origin;
use App\Models\AdminProfile;
use App\Models\BusinessCategory;
use App\Models\Country;
use Illuminate\Support\Str;

class BusinessCategoryController extends AdminController
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

		$records = BusinessCategory::latest();

		if ($request->status) {
			$records->where('status', $request->status);
		}

		if ($request->from_date) {
			$records->whereDate('created_at', '>=', $request->from_date);
		}

		if ($request->to_date) {
			$records->whereDate('created_at', '<=', $request->to_date);
		}

		$records = $records->paginate(10);

		return view('frontend.master.business-category.index', array(
			'tab' => 'business-categories',
			'user' => $user,
			'records' => $records,
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

		$vendor = new BusinessCategory();

		$action = '/business-category/create';

		return view('frontend.master.business-category.create_edit', array(
			'tab' => 'business-categories',
			'request' => $request,
			'vendor' => $vendor,
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

		$validator = (new MasterValidator($request))->storeBusinessCategory();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}

		$record = new BusinessCategory();
		$record->fill($request->all());
		$record->save();

		return [
			'message' => 'Business Category Added Succesfully!!!'
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

		$vendor = BusinessCategory::find($id);

		$action = '/business-category/' . $id . '/edit';

		return view('frontend.master.business-category.create_edit', array(
			'tab' => 'business-categories',
			'vendor' => $vendor,
			'action' => $action,
		));
	}

	public function update(Request $request, $id)
	{
		$user = \Auth::user();

		$request->request->add(['id' => $id]);
		$validator = (new MasterValidator($request))->updateBusinessCategory();

		$record = BusinessCategory::find($id);
		if ($request->status == 'inactive') {
			$validator->after(function ($validator) use ($record) {
				if (count($record->vendors) > 0) {
					$validator->errors()->add('status', 'Please remove existing vendor mappings to inactive this record.');
				}
			});
		}
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}

		$record->fill($request->all());
		$record->save();

		return [
			'message' => 'Business Category Updated Succesfully!!!'
		];
	}

	public function destroy($id)
	{
		$user = \Auth::user();

		$record = BusinessCategory::find($id);
		if (count($record->vendors) > 0) {
			return [
				'message' => 'Please remove existing mappings to delete this record.',
			];
		} else {
			$record->delete();
		}

		return [
			'message' => 'Record deleted successfully!',
		];
	}
}
