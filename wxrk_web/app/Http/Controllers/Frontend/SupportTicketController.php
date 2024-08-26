<?php

namespace App\Http\Controllers\Frontend;

use Auth;

use App\Models\SupportTicket;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Support as SupportValidator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

//use App\Helpers\GeneralHelper;
use App\Helpers\ConstantHelper;
use App\Models\Admin;
use App\Models\SupportCategory;
use App\Models\SupportChat;
use App\Models\SupportComment;

class SupportTicketController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index(Request $request)
	{
		$user = Auth::user();

		$supports = SupportTicket::orderBy('id', 'DESC');

		if ($user->hasRole('vendor')) {
			$supports->where('created_by', $user->id);
		}

		if ($request->status) {
			$supports->where('status', '=', $request->status);
		}

		if ($request->vendor_id) {
			$supports->where('created_by', '=', $request->vendor_id);
		}

		if ($request->category_id) {
			$supports->where('category_id', '=', $request->category_id);
		}

		if ($request->from_date) {
			$supports->whereDate('created_at', '>=', $request->from_date);
		}

		if ($request->to_date) {
			$supports->whereDate('created_at', '<=', $request->to_date);
		}

		$supports = $supports->paginate(10);

		$categories = SupportCategory::whereNull('parent_id')
			->where('status', 'active')
			->get();

		$vendors = Admin::where('admin_type', 'vendor')
			->where('status', 'active')
			->get();

		$statuses = ConstantHelper::SUPPORT_STATUS;

		return view('frontend.support.index', array(
			'tab' => 'supports',
			'user' => $user,
			'supports' => $supports,
			'vendors' => $vendors,
			'statuses' => $statuses,
			'categories' => $categories,
			'request' => $request,
		));
	}

	public function create(Request $request)
	{
		$user = Auth::user();

		$support = new SupportTicket();
		$action = '/support/create';

		return view('frontend.support.create_edit', array(
			'tab' => 'supports',
			'user' => $user,
			'support' => $support,
			'action' => $action,
			'request' => $request,
		));
	}


	public function store(Request $request)
	{
		$user = Auth::user();

		$validator = (new SupportValidator($request))->store();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}

		$data = $request->all();
		$support = new SupportTicket();
		$support->fill($data);
		$support->created_by = $user->id;
		$support->save();

		if ($request->hasFile('attachments')) {
			foreach ($request->attachments as $key => $image) {
				$support->addMediaFromRequest("attachments[$key]")->toMediaCollection('attachments');
			}
		}

		return [
			'message' => 'Support Added Succesfully!!!'
		];
	}

	public function edit($id)
	{
		$user = Auth::user();

		$support = SupportTicket::find($id);
		if ($user->hasRoles(['vendor']) && $support->status == 'closed') {
			return redirect('/supports');
		}

		$action = '/support/' . $id . '/edit';

		return view('frontend.support.create_edit', array(
			'tab' => 'Supports',
			'user' => $user,
			'support' => $support,
			'action' => $action,
		));
	}


	public function update(Request $request, $id)
	{
		$user = Auth::user();

		if (!$user->hasRole('admin')){
			$validator = (new SupportValidator($request))->update();
		}else{
			$validator = (new SupportValidator($request))->updateAdmin();
		}

		if ($validator->fails()) {
			throw new ValidationException($validator);
		}

		$support = SupportTicket::find($id);
		$support->fill($request->all());
		$support->updated_by = $user->id;
		$support->save();

		if ($request->hasFile('attachments')) {
			foreach ($request->attachments as $key => $image) {
				$support->addMediaFromRequest("attachments[$key]")->toMediaCollection('attachments');
			}
		}

		return [
			'message' => 'Support Updated Succesfully!!!'
		];
	}


	public function destroy($id)
	{

		$support = SupportTicket::find($id);
		if (!$support) {
			return [
				'message' => 'Support doest not exist.',
			];
		} else {

			$support->delete();
		}

		return [
			'message' => 'Record deleted successfully!',
		];
	}

	public function saveComments(Request $request)
	{
		$auth = \Auth::user();

		$validator = (new SupportValidator($request))->saveComments();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}

		$comment = new SupportComment();
		$comment->support_ticket_id = $request->support_ticket_id;
		$comment->remark = $request->remark;
		$comment->created_by = $auth->id;
		$comment->save();

		if ($request->hasFile('attachment')) {
			$comment->addMediaFromRequest('attachment')->toMediaCollection('attachment');
		}

		return [
			'message' => 'Support Comment Added Succesfully!!!'
		];
	}

	public function getSubCategories(Request $request)
	{
		$categories = SupportCategory::whereNotNull('parent_id')->where('status', 'active')
			->where('parent_id', $request->category_id)
			->orderBy('name')
			->get();

		$dataSet = array(
			'status' => 200,
			'message' => "Success..!! data successfully retrieved",
			'result' => true,
			'response' => $categories
		);

		return response()->json($dataSet);
	}

	public function getChats(Request $request)
	{
		$auth = \Auth::user();

		$chats = SupportChat::where('support_ticket_id', $request->support_id)->get();

		return [
			'message' => 'Chats retrived Succesfully!!!',
			'data' => $chats
		];
	}

	public function storeChat(Request $request)
	{
		$auth = \Auth::user();

		$chat = new SupportChat();
		$chat->fill($request->all());
		$chat->created_by = $auth->id;
		$chat->save();

		if ($request->hasFile('attachment')) {
			$chat->addMediaFromRequest('attachment')->toMediaCollection('attachment');
		}

		return [
			'message' => 'Chat Added Succesfully!!!',
			'data' => $chat
		];
	}
}
