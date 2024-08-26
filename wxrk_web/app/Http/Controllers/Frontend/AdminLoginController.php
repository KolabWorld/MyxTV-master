<?php

namespace App\Http\Controllers\Frontend;

use Session;
use App\Models\Admin;
use App\Models\OtpRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Notifications\CommonNotification;

class AdminLoginController extends Controller
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

        // $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function mainLogin(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only('email', 'password');
        $credentials['password'] = $request->password;

        $remember = true;

        if (\Auth::attempt($credentials,$remember)) {
            $userData = Admin::where('email', '=', $request->email)
                ->first();

            if ($userData && $userData->status != 'active') {
                $errorMsg = "Your account is deactivated.";
                return redirect()->back()->with(['errorMessage' => $errorMsg]);
            }
            $accessToken = $userData->createToken('authToken')->accessToken;
            Session::put('auth_access_token', $accessToken);

            if((\Auth::user()->hasRoles(['vendor'])) && (\Auth::user()->is_payment_done == 0)){
                return redirect()->intended('/subscription-plan-payment');
            }
            
            return redirect()->intended('/dashboard');
        } else {
            $errorMsg = "Incorrect Username Or Password";
            return redirect()->back()->with(['errorMessage' => $errorMsg,'request' => json_encode($request->all())]);
        }
    }

    public function forgetPassword()
    {
        return view(
            'auth.admin-forget-password'
        );
    }

    public function viewOtp(Request $request)
    {
        $user = Admin::where('remember_token',$request->token)->first();
        return view(
            'auth.admin-verify-otp',[
                'user' => $user,
            ]
        );
    }

    public function reset(Request $request)
    {
        $user = Admin::where('remember_token',$request->token)->first();
        if($user && $user->is_email_verified == 1){
            return view('auth.admin-reset-password',[
                'user' => $user,
            ]);
        }
        else{
            return redirect('/');
        }
    }

    public function submitPassword(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'string', 'email'],
        ]);

        $user = Admin::where('email', $request->email)->first();

        if (!$user) {
            $errorMessage = "No admin account was found with the email address you entered.";
            \Session::flash("flash_notification", [
                "level"     => "danger",
                "message"   => $errorMessage
            ]);
            return redirect('/forget-password');
        } else {
            $remember_token = bcrypt(Str::random(6));
            $user->is_email_verified = 0;
            $user->remember_token = $remember_token;
            $user->save();

            $otpRequest = new OtpRequest();
            $otpRequest->auth_type = $request->type;
            // $otpRequest->user_id = ;
            $otpRequest->email = $request->email;
            $otpRequest->expired_at = date("Y-m-d H:i:s", strtotime("+10 minutes"));
            // $otpRequest->otp = '12345';
            $otpRequest->otp = rand(100000,999999);
            $otpRequest->save();

            $user->notify(new CommonNotification([
                'subject' =>  "Reset Password Notification",
                'template' =>  'email.forgot-password',
                'data' => [
                    'otp' => $otpRequest->otp,
                    'name' => $user->name
                ]
            ]));

            if ($user) {
                $successMessage = "Please check your email for the OTP.";
                \Session::flash("flash_notification", [
                    "level"     => "success",
                    "message"   => $successMessage
                ]);
                return redirect('/verify-otp?token='.$remember_token);
            } else {
                \Session::flash("flash_notification", [
                    "level"     => "danger",
                    "message"   => "Something went wrong. Please try again"
                ]);
                return redirect('/forget-password');
            }
        }
    }

    public function resendOtp(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email'],
        ]);

        $user = Admin::where('email', $request->email)->first();
        $user->is_email_verified = 0;
        $user->save();

        $otpRequest = new OtpRequest();
        $otpRequest->auth_type = $request->type;
        // $otpRequest->user_id = ;
        $otpRequest->email = $request->email;
        $otpRequest->expired_at = date("Y-m-d H:i:s", strtotime("+10 minutes"));
        // $otpRequest->otp = '12345';
        $otpRequest->otp = rand(100000,999999);
        $otpRequest->save();

        $user->notify(new CommonNotification([
            'subject' =>  "Reset Password Notification",
            'template' =>  'email.forgot-password',
            'data' => [
                'otp' => $otpRequest->otp,
                'name' => $user->name
            ]
        ]));

        if ($user) {
            $dataSet = array(
                'status' => 200,
                'message' => "Please check your email for the OTP.",
                'result' => true,
            );
        } else {
            $dataSet = array(
                'status' => 204,
                'message' => "Failure. something went wrong",
                'result' => false,
            );
        }
        return $dataSet;
    }

    public function verifyOtp(Request $request)
    {
        $this->validate($request, [
            'otp.*' => [
                'required',
                'numeric',
                'min:0',
                'max:9',
            ],
            'email' => 'required|email|min:8',
            'token' => 'required|string',
        ],[
            'otp.*.required' => 'OTP field is required',
            'otp.*.numeric' => 'OTP must be a number',
        ]);
        $otp = implode("",$request->otp);
        $user = Admin::where('remember_token',$request->token)->first();
        $otpRequest = OtpRequest::where('email', '=', $request->email)->where('auth_type', '=', $request->type)->where('otp', '=', $otp)->latest()->first();
        if(!$otpRequest){
            \Session::flash("flash_notification", [
                "level"     => "danger",
                "message"   => "Wrong OTP. Please try again."
            ]);
            return back();
        }
        else if($otpRequest && $otpRequest->expired_at < date("Y-m-d H:i:s")){
            \Session::flash("flash_notification", [
                "level"     => "danger",
                "message"   => "OTP Expired. Please try again."
            ]);
            return back();
        }
        else{
            $user->is_email_verified = 1;
            $user->save();
            return redirect()->intended('/reset-password?token='.$user->remember_token);
        }
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'password' => [
                'required',
                'string',
                'min:8',
            ],
            'password_confirmation' => 'required_with:password|same:password|min:8',
            'email' => ['required', 'email'],
            'token' => ['required', 'string'],
        ]);
        $admin = Admin::where('remember_token', '=', $request->token)->where('is_email_verified', 1)->first();
        if ($admin) {
            $admin->password = $request->password;
            $admin->is_email_verified = 0;
            $admin->remember_token = null;
            $admin->status = 'active';
            $admin->save();

            \Session::flash("flash_notification", [
                "level"     => "success",
                "message"   => "New password has been successfully assigned. Please login to continue."
            ]);
            return redirect('/');
        } else {
            \Session::flash("flash_notification", [
                "level"     => "danger",
                "message"   => "Something went wrong. Please try again."
            ]);
            return back();
        }
    }
}