<?php
namespace App\Http\Controllers\Frontend;

use DB;
use View;
use Session;
use stdClass;
use Datatables;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Models\Role;
use App\Models\Admin;
use App\Models\MailBox;
use App\Models\Address;
use App\Models\Country;
use App\Models\Currency;
use App\Models\SocialMedia;
use App\Models\BusinessCategory; 
use App\Models\SubscriptionPlan;
use App\Models\ServerWelcomeEmail;
use App\Models\SubscriptionPlanLog;
use App\Models\AdminSubscriptionPlan;

use Illuminate\Validation\Rule;
use App\Services\Mailers\Mailer;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Admin as AccountValidator;

use App\Helpers\GeneralHelper;
use App\Helpers\ConstantHelper;
use Stripe\Subscription;

class LoginController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        parent::__construct($this);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('frontend.login.index');
    }

    public function discordLogin()
    {
        return view('frontend.index.discord-login');
    }

    public function adminLogin()
    {
        session(['link' => url()->previous()]);
        $errorMessage = Session::get('errorMessage');
        $successMessage = Session::get('successMessage');
        $request = json_decode(Session::get('request'));
        // dd($request);
        return view('auth.admin-login',
            array(
                'request' => $request,
                'errorMessage' => $errorMessage,
                'successMessage' => $successMessage,
            )
        );
    }

    public function designerLogin()
    {

        session(['link' => url()->previous()]);
        $successMessage = Session::get('successMessage');

        if (view()->exists('auth.authenticate')) {
            return view('auth.authenticate');
        }
        return view('auth.designer-login',
            array(
                'successMessage' => $successMessage,
            )
        );
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'email' => ['required','string','email'],
            'password' => ['required','string'],
        ]);

        $credentials = $request->only('email', 'password');
        $userData = User::where('email', '=', $request->email)->first();
        if(!$userData) {
            return back()->with('error','User does not exist!');
        }

        if($userData && (!$userData->password )) {
            return back()->with('error','Your password has been expired please reset your password!');
        }
        if (Auth::attempt($credentials)) {
            $userData = User::where('email', '=', $request->email)->first();
            // if($userData->status == 'pending'){
            //     $errorMsg = "Your account is not activated yet.";
            //     return view('frontend.login.index',array('errorMsg' => $errorMsg));
            // }
            // if($userData->status == 'inactive'){
            //     $errorMsg = "Your account is deactivated.";
            //     // return view('frontend.login.index',array('errorMsg' => $errorMsg));
            //     return $errorMsg;
            // }

            if($request->session()->get('cart')) {
                GeneralHelper::addUserCartDataFromSession($userData, $request->session()->get('cart'));
                $request->session()->forget('cart');
                $request->session()->save();
            }
            // Authentication passed...

            // if ($request->route) {
            //     return redirect(route($request->route));
            // }
            // if($request->is_url == 'checkout'){
            //     return redirect()->intended('/checkout');
            // }
            // else{
            //     if($request->route) {
            //         return redirect(route($request->route));
            //     }
            //     return redirect()->intended('/');
            // }
            return back()->with('success','Logged in successfully!');
        }
        else{
            return back()->with('error','Incorrect  Password!');
        }
    }

    public function register()
    { 
        if (auth()->user()) 
        {
            return redirect()->intended('/');
        }
        $successMessage = Session::get('successMessage');
        $errorMessage = Session::get('errorMessage');

        $currencies = Currency::all(); 
        $countries = Country::all();
        
        return view('frontend.login.register',
            array(
                'countries' => $countries,
                'currencies' => $currencies,
                'errorMessage' => $errorMessage,
                'successMessage' => $successMessage,
            )
        );
    }

    public function forgetPassword()
    {
        if (auth()->user()) 
        {
            return redirect()->intended('/');
        }
        $errorMessage = Session::get('errorMessage');
        $successMessage = Session::get('successMessage');

        return view('frontend.login.forget-password',
            array(
                "errorMessage" => $errorMessage,
                "successMessage" => $successMessage
            )
        );
    }

    public function submitPassword(Request $request)
    {
        $mailbox = new MailBox;
        $userData = User::where('email','=',$request->email)->first();

        if(!$userData){
            $errorMessage = "No client account was found with the email address you entered.";
            return redirect('/login/forget-password')->with('errorMessage', $errorMessage);
        }
        else{
            $email = $request->email;
            $name = $request->name;
            $token = base64_encode($email.time().$name);
            $userData->remember_token = $token;
            $userData->save();
            $link = env('APP_URL', '');
            $description = 'Dear '.$userData->name.' ('.$userData->company_name.')!<br/><br/>Recently a request was submitted to reset your password for our client area. If you did not request this, please ignore this email. It will expire and become useless in 2 hours time.
 <br/><br/>To reset your password, please <a href="'.$link.'/reset-password?token='.$token.'" target="new"><b>Click Here</b> </a>! <br/><br/>
 When you visit the link above, you will have the opportunity to choose a new password.';

            $mailArray = array(
                "header" => "Reset Password",
                "description" => $description,
                "footer" => "System Generated Email"
            );

            $mailbox->mail_body = json_encode($mailArray);
            $mailbox->category = "Reset password";
            $mailbox->mail_to = $userData->email;
            $mailbox->subject = "Your login details for Miditech Technical";
            $mailbox->layout = "email.email-template";
            $mailbox->save();

            $mailer = new Mailer;
            $mailer->emailTo($mailbox);

            if($mailer){
                $successMessage = "The password reset process has now been started. Please check your email for instructions on what to do next.";
                return redirect('/login/forget-password')->with('successMessage', $successMessage);

            }

            else{
                $errorMessage = "something went wrong.";
                return redirect('/login/forget-password')->with('errorMessage', $errorMessage);
            }
        }
    }

    public function reset(Request $request)
    {
        $errorMessage = Session::get('errorMessage');
        $successMessage = Session::get('successMessage');
        $user = User::where('remember_token','=',$request->token)->first();
        if($user){
            return view('frontend.login.reset',
                array(
                    'email' => $user->email,
                    'name' => $user->name,
                    'token' => $request->token,
                    "errorMessage" => $errorMessage,
                    "successMessage" => $successMessage
                )
            );
        }
        else{
            return view('frontend.login.index');
        }
    }

    public function resetPassword(Request $request)
    {
        $user = User::where('remember_token','=',$request->token)
                    ->first();
        if($user){
            $password = $request->password;
            $passwordConfirmation = $request->password_confirmation;

            if (!empty($password)) {
                if ($password === $passwordConfirmation) {
                    $user->password = $password;
                }
                else {
                    $errorMessage = "Confirmation password not matched !!";
                    return redirect()->back()->with('errorMessage', $errorMessage);
                }
                $user->save();

                $welcomeEmail = ServerWelcomeEmail::where('name', '=', 'Automated Password Reset')
                    ->first();

                $siteLink = env('APP_URL', '');

                if($welcomeEmail){
                    $description = $welcomeEmail->description;
                    $emailKeywords = array(
                        "{CLIENT_NAME}" => $user->name,
                        "{CLIENT_EMAIL}" => $user->email,
                        "{CLIENT_PASSWORD}" => $request->password,
						"{COMPANY_NAME}" => $user->company_name,
                        "{WHMCS_LINK}" => $siteLink,
                        "{SIGNATURE}" => "",
                    );
                    foreach($emailKeywords as $key => $val){
                        $description = str_replace("$key",$val, $description);
                    }

                    $mailbox = new MailBox;

                    $mailArray = array(
                        "name" => $user->name,
                        "mobile" => $user->mobile,
                        "email" => $user->email,
                        "email_template_name" => $welcomeEmail->name,
                        "from_name" => $welcomeEmail->fromname,
                        "from_email" => $welcomeEmail->fromemail,
                        "subject" => $welcomeEmail->subject,
                        "copy_to" => $welcomeEmail->copyto,
                        "description" => $description
                    );

                    $mailbox->mail_body = json_encode($mailArray);
                    $mailbox->subject = $welcomeEmail->subject;
                    $mailbox->mail_to = $user->email;
                    if($welcomeEmail->copyto){
                        $mailbox->mail_cc = $welcomeEmail->copyto;
                    }
                    $mailbox->category = $welcomeEmail->name;
                    $mailbox->layout = "email.email-template";
                    $mailbox->save();

                    $mailer = new Mailer;
                    $mailer->emailTo($mailbox);
                }
            }

            $successMessage = "Password changed successfully !!";
            return redirect()->back()->with('successMessage', $successMessage);

        }
        else{
            return view('frontend.login.index');
        }
    }

    public function vendorRegistration($id)
    {
        $vendor = new Admin();

        $subscriptionPlan = SubscriptionPlan::find($id);
		$countries = Country::where('status','active')->get();
		$businessCategories = BusinessCategory::where('status','active')->get();
		
        return view('auth.vendor-registration',
            array(
                'countries' => $countries,
                'subscriptionPlan' => $subscriptionPlan,
                'businessCategories' => $businessCategories,
            )
        );
    }

    public function saveVendorRegistration(Request $request)
    {
        $validator = (new AccountValidator($request))->store();
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}

        $plan = SubscriptionPlan::find($request->subscription_plan_id);

        $vendor = new Admin();
		$vendor->fill($request->all());
		$vendor->admin_type = 'vendor';
        $vendor->remember_token = bcrypt(Str::random(6));
        $vendor->is_email_verified = 1;
        $vendor->subscription_plan_id = $request->subscription_plan_id;
        if(strtolower(@$plan->name) == 'trial'){
            $vendor->is_payment_done = 1;
        }else{
            $vendor->is_payment_done = 0;
        }
        $vendor->status = 'pending';
		$vendor->save();    

		$role = Role::where('alias','vendor')->first();
		
		$vendor->roles()->sync([$role->id]);
		
		$vendor->address()->create([
			'line_1' => '',
			'country_id' => $request->country_id,
			'state_id' => $request->state_id,
			'city_id' => $request->city_id,
			'landmark' => $request->address,
			'postal_code' => $request->postal_code,
		]);

        if ($request->hasFile('logo')) {
            $vendor->addMediaFromRequest('logo')->toMediaCollection('logo');
        }

		if ($request->hasFile('image')) {
            $vendor->profile->addMediaFromRequest('image')->toMediaCollection('image');
        }

        if(strtolower(@$plan->name) == 'trial'){
            $expiresAt = date('Y-m-d H:i:s', strtotime('+7 day'));

            $vendorSubscriptionPlanMapping = new AdminSubscriptionPlan();
            $vendorSubscriptionPlanMapping->admin_id = $vendor->id;
            $vendorSubscriptionPlanMapping->subscription_plan_id = $vendor->subscription_plan_id;
            $vendorSubscriptionPlanMapping->plan_expires_at = $expiresAt;
            $vendorSubscriptionPlanMapping->status = 'paid';
            $vendorSubscriptionPlanMapping->save();
            
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
			'message' => 'Vendor registered succesfully, please check your mail to set password !!'
		];
    }

}
