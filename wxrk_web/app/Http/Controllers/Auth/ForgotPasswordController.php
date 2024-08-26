<?php

namespace App\Http\Controllers\Auth;

use App\Models\Admin;
use App\Models\Designer;
use App\Models\MailBox;
use App\Services\Mailers\Mailer;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function admin()
    {
        return view('auth.admin-forget-password');
    }

    public function submitPassword(Request $request)
    {
        $mailbox = new MailBox;
        $data = '';
        if ($request->type == 'admin') {
            $data = Admin::where('email', '=', $request->email)->first();
        } else {
            $data = Designer::where('email', '=', $request->email)->first();
        }

        if (!$data) {
            if ($request->type == 'admin') {
                $errorMessage = "No admin account was found with the email address you entered.";
                return redirect('/admin/forget-password')->with('errorMessage', $errorMessage);
            } else {
                $errorMessage = "No designer account was found with the email address you entered.";
                return redirect('/admin/forget-password')->with('errorMessage', $errorMessage);
            }
        } else {
            $email = $request->email;
            $name = $request->name;
            $token = base64_encode($email . time() . $name);
            $data->remember_token = $token;
            $data->save();
            $link = env('APP_URL', '');
            $description = 'Dear ' . $data->name . ' !<br/><br/>Recently a request was submitted to reset your password. If you did not request this, please ignore this email. It will expire and become useless in 2 hours time.
 <br/><br/>To reset your password, please <a href="' . $link . '/reset-password?token=' . $token . '" target="new"><b>Click Here</b> </a>! <br/><br/>
 When you visit the link above, you will have the opportunity to choose a new password.';

            $mailArray = array(
                "header" => "Reset Password",
                "description" => $description,
                "footer" => "System Generated Email"
            );

            $mailbox->mail_body = json_encode($mailArray);
            $mailbox->category = "Reset password";
            $mailbox->mail_to = $data->email;
            $mailbox->subject = "Your login details for Miditech Technical";
            $mailbox->layout = "email.email-template";
            $mailbox->save();

            $mailer = new Mailer;
            $mailer->emailTo($mailbox);

            if ($mailer) {
                $successMessage = "The password reset process has now been started. Please check your email for instructions on what to do next.";
                if ($request->type == 'admin') {
                    return redirect('/admin/forget-password')->with('successMessage', $successMessage);
                } else {
                    return redirect('/designer/forget-password')->with('successMessage', $successMessage);
                }
            } else {
                $errorMessage = "something went wrong.";
                if ($request->type == 'admin') {
                    return redirect('/admin/forget-password')->with('errorMessage', $errorMessage);
                } else {
                    return redirect('/designer/forget-password')->with('errorMessage', $errorMessage);
                }
            }
        }
    }
}