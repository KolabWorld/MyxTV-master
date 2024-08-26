<?php

namespace App\Http\Controllers\Frontend\Auth;

use Session;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;

class AuthController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */


    protected $redirectTo = '/';

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;

        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function authenticate(Request $request)
    {
        dd('dkfhdsjk');
        $this->validate($request, [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only('email', 'password');
        $credentials['password'] = $request->password;

        $remember = $request->has('remember') ? true : false;

        if (\Auth::user()->attempt($credentials,$remember)) {
            $userData = Admin::where('email', '=', $request->email)
                ->first();

            if ($userData && $userData->status != 'active') {
                $errorMsg = "Your account is deactivated.";
                return view('auth.admin-login', array('errorMsg' => $errorMsg));
            }
            $accessToken = $userData->createToken('authToken')->accessToken;
            Session::put('auth_access_token', $accessToken);
            return redirect()->intended('/dashboard');
        } else {
            $errorMsg = "Incorrect Username Or Password";
            return view('auth.admin-login', array('errorMsg' => $errorMsg));
        }
    }
}