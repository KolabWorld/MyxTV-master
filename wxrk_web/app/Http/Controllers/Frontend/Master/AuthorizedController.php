<?php

namespace App\Http\Controllers\frontend\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthorizedController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function show(Request $request)
    {    
     die('You are not authorized');
     return('frontend.master.unauthorized.view');
    }
}
