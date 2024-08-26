<?php

namespace App\Http\Controllers\Frontend;

use Auth;

use App\Models\NewsletterSubsciber;

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
use App\Models\SupportComment;

class NewsletterSubscriber extends AdminController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index(Request $request)
	{
		$user = Auth::user();

		$records = NewsletterSubsciber::orderBy('id', 'DESC');

		if ($request->search) {
			$keyword = $request->search;
			$records->where(function ($q) use ($keyword) {
				$q->where('email', 'LIKE', '%' . $keyword . '%');
			});
		}
		if($request->from_date){
			$records->whereDate('created_at', '>=', $request->from_date);
		}

		if($request->to_date){
			$records->whereDate('created_at', '<=', $request->to_date);
		}

		$records = $records->paginate(10);

		return view('frontend.newsletter.index', array(
			'tab' => 'records-subs',
			'user' => $user,
			'records' => $records,
			'request' => $request,
		));
	}

}
