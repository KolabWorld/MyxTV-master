<?php
namespace App\Http\Controllers\API;

use Auth;
use Carbon\Carbon;

use App\User;
use App\Models\Admin;
use App\Models\Country;
use App\Models\OtpRequest;
use App\Models\OauthClient;
use App\Models\OauthAccessToken;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Helpers\ConstantHelper;
use App\Exceptions\UserNotFound;
use App\Exceptions\UserNotAuthorized;
use App\Exceptions\ApiGenericException;
use App\Notifications\CommonNotification;
use App\Lib\Validation\Auth as Validator;
use App\Models\MailBox;
use App\Services\Mailers\Mailer;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Validation\ValidationException;
use \Laravel\Passport\Http\Controllers\AccessTokenController;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use PeterPetrus\Auth\PassportToken;

use Services\Notification\Push;
use Services\Notification\Firebase;

class AuthController extends AccessTokenController
{

	const QUEUE_NAME = 'API';
	use SendsPasswordResetEmails;


	/**
	 * user login from API
	 * @param $request ServerRequestInterface
	 */ 

	public function login(ServerRequestInterface $request){
		
		$requestData = $request->getParsedBody();
		$username = $requestData['username'];
		$password = $requestData['password'];
		
		if (!$username) {
			throw new ApiGenericException("Username is required");
		}
		
		if (!$password) {
			throw new ApiGenericException("Password is required");
		}

		$user = User::where('user_name', '=', $username)->first();
		if(!$user){
			$user = new User();
			$user->user_name = $username;
			// $user->email = $username;
			$user->password = $password;
			$user->status = 'active';
			$user->save();
		}
		// dd($requestData);
		$tokenResponse = parent::issueToken($request);
		
		$token = $tokenResponse->getContent();
		// dd($tokenResponse);
		// $tokenInfo will contain the usual Laravel Passort token response.
		$tokenInfo = json_decode($token, true);
		
		if (isset($tokenInfo['error'])) {
			throw new UserNotAuthorized($tokenInfo['message']);
		}

		// Then we just add the user to the response before returning it.
		$user = User::where('user_name', '=', $username)->first();
		$authUser = User::with(['roles'])->find($user->id);

		$tokenInfo = collect($tokenInfo);
		$tokenInfo->put('user', $user);
		$tokenRow = PassportToken::dirtyDecode($tokenInfo['access_token']);

		$loginClient = OauthAccessToken::where('id', 'LIKE', $tokenRow['token_id'])->first();
		$oauthClient = OauthClient::find($loginClient->client_id);

		$loginClient->fill($requestData);
		$loginClient->save();

        // $user->status = 'active';
        // $user->save();

        if ($user && $user->status !== ConstantHelper::ACTIVE) {
            throw new ApiGenericException(__('message.unable_to_login'));
        }

        $accessToken = $user->createToken('authToken')->accessToken;
        // $user->access_token = $accessToken;
		// $deviceToken = (new AdminDeviceToken($request))->store();

        return array(
            'message' => __('message.logged_in_successfully'),
            'data' => $authUser,
            'access_token' => $accessToken,
        );
	}

	// Reset Email Link
	public function submitPassword(Request $request)
    {
		$validator = (new Validator($request))->forgotPassword();

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
		
        $user = Admin::where('email', $request->email)->first();
        if (!$user) {
			throw new UserNotFound(__('message.doesnt_exist', ['static' => __('static.user')]));
        } else {
            $remember_token = bcrypt(Str::random(6));
            $user->is_email_verified = 0;
            $user->remember_token = $remember_token;
            $user->save();

            $otpRequest = new OtpRequest();
            $otpRequest->auth_type = 'admin';
            $otpRequest->admin_id = $user->id;
            $otpRequest->email = $request->email;
            $otpRequest->expired_at = date("Y-m-d H:i:s", strtotime("+10 minutes"));
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
				return array(
					'message' => __('message.check_mail_for_otp'),
					'data' => $user,
					'otp_request' => $otpRequest,
				);
            } else {
                throw new ApiGenericException(__('message.invalid_request'));
            }
        }
    }

	// View OTP 
	public function viewOtp(Request $request)
    {
        $user = Admin::where('remember_token',$request->token)->first();
		if (!$user) {
            throw new UserNotFound(__('message.doesnt_exist', ['static' => __('static.user')]));
        }
		return array(
			'message' => __('message.fetch_records'),
			'data' => $user,
		);
    }

	//Send OTP
	public function sendOtp(Request $request){
		// dd($request->all());
		$validator = (new Validator($request))->sendOtp();

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

		$country = Country::where('dial_code', '=', $request->dial_code)
			->first();

		$user = User::find($request->user_id);
		$user->mobile = $request->mobile;
		$user->email = $request->email;
		$user->country_id = $country->id;
		$user->update();

		$otpRequest = new OtpRequest();
		$otpRequest->auth_type = 'user';
		$otpRequest->user_id = $user->id;
		$otpRequest->mobile = $user->mobile;
		$otpRequest->email = $user->email;
		$otpRequest->expired_at = date("Y-m-d H:i:s", strtotime("+10 minutes"));
		$otpRequest->otp = rand(1000,9999);
		$otpRequest->save();

		if ($user->email) {
            $mailbox = new MailBox();

            $email = $user->email;
            $description = 'Dear '.$user->name.'!<br/>
            <br/>
            Your OTP is '.$otpRequest->otp.'
			<br/>
            Thanks<br/>
            Work Study';

            $mailSubject = "LogIn OTP";

            $mailArray = array(
                "header" => "LogIn OTP",
                "description" => $description,
                "mailSubject" => $mailSubject,
                "footer" => "System Generated Email"
            );

            $mailbox->mail_body = $mailArray;
            $mailbox->category = "LogIn OTP";
            $mailbox->mail_to = $email;
            $mailbox->subject = "LogIn OTP";
            $mailbox->layout = "email.email-template";
            $mailbox->save();	

            $mailer = new Mailer;
            $mailer->emailTo($mailbox);
        }
		
		if ($user) {
			$data = array(
				'user' => $user
			);
			
			return array(
					'message' => __('message.check_mail_for_otp'),
					'data' =>  $data,
			);
		} else {
			throw new ApiGenericException(__('message.invalid_request'));
		}
	}

	// Verify Otp
	public function verifyOtp(Request $request)
    {
        $validator = (new Validator($request))->verifyOtp();

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
		
		$user = User::find($request->user_id);
		$otpRequest = OtpRequest::where('email', '=', $user->email)
			->where('auth_type', '=', 'user')
			->where('otp', '=', $request->otp)
			->latest()
			->first();

		if(!$otpRequest){
			throw new ApiGenericException(__('message.otp_invalid'));
        }
		else if($otpRequest && $otpRequest->expired_at < date("Y-m-d H:i:s")){
			throw new ApiGenericException(__('message.otp_expired'));
        }
		else{

			$data = array(
				'user' => $user
			);
			
			return array(
				'message' => __('message.otp_verified'),
				'data' => $data,
			);
		}
    }

	// Get Rest Password
    public function reset(Request $request)
    {
        $user = Admin::where('remember_token',$request->token)->first();
        if($user && $user->is_email_verified != 1){
			throw new ApiGenericException(__('message.email_verification_link_subject'));
        }
		return array(
			'message' => __('message.fetch_records'),
			'data' => $user,
		);
        
    }

	// Reset Password 
    public function resetPassword(Request $request)
    {
        $validator = (new Validator($request))->resetPassword();

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $admin = Admin::where('email', '=', $request->email)
			->where('is_email_verified', 1)
			->first();
		
        if ($admin) {
            $admin->password = $request->password;
            $admin->is_email_verified = 0;
            $admin->remember_token = null;
            $admin->save();

			return array(
				'message' => __('message.reset_password'),
				'data' => $admin,
			);
        } else {
			throw new ApiGenericException(__('message.something_went_wrong'));
        }
    }


	//validate user

	public function resetPass(Request $request) {
		$validator = (new EmployeeValidator($request))->passwordResetOTP();
        if($validator->fails()){
            throw new ValidationException($validator);
		}

		$user = Employee::where('email', '=', $request->username)
			->orWhere('mobile', '=', $request->username)
			->first();
		if (!$user) {
			throw new UserNotFound("invalid user");
		}
		
		$otpRecord = OtpRequest::where('otp','=', $request->otp)
			->where('auth_id','=', $user->id)
			->where('auth_type', '=', 'employee')
			->orderBy('id', 'DESC')
			->first();

		if($otpRecord){
			$expiry = strtotime($otpRecord->updated_at);
			$validity = time() - $expiry;
			if($validity > 900){
				throw new ApiGenericException("The OTP has been expired");
			}
		}
		else {
			throw new ApiGenericException("The OTP was incorrect");
		}

		$user->password = $request->password;
		$user->save();

		return ['message' => 'Password has been reset successfully, please login with new password'];    

	}

	/**
	 * change password for user
	 * @param $request RegisterRequest
	 */
	public function changePassword(ChangePasswordRequest $request) {

		try {
			// get user from api token
			$user = Auth::guard('api')->user();

			//checking the old password first
			$check  = Auth::guard('web')->attempt([
				'email' => $user->email,
				'password' => $request->old_password
			]);
			
			if(!$check) {
				throw new ApiGenericException("Invalid Old password");
			}
			$user->password = bcrypt($request->password);
			$user->save();

			return $user;
		} catch (Exception $e) {
			throw new ApiGenericException("Could not update password, " . $e->getMessage());
		}
	}
}
