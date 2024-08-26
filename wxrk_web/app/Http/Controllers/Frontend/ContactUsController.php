<?php

namespace App\Http\Controllers\Frontend;

use Auth;


use App\User;
use App\Models\Admin;
use App\Models\Contact;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;



class ContactUsController extends AdminController
{
    
    public function __construct()
	{
		parent::__construct();
	}

    public function index(Request $request)
	{
		$user = \Auth::user();

		$contacts = Contact::orderBy('id', 'DESC')->get();

        if ($request->search) {
			$keyword = $request->search;
			$contacts->where(function ($q) use ($keyword) {
				$q->where('name', 'LIKE', '%' . $keyword . '%');
			});
		}

		// $contacts = $contacts->paginate(10);

		return view('frontend.contact-us.list', array(
			'tab' =>'contact-us',
			'contacts' => $contacts,
			'request' => $request,
			'user' => $user,
		));
	}
}
