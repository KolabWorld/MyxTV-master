<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\PaymentTransaction;
use App\Models\SubscriptionPlanLog;
use App\Models\UserWalletTransaction;
use App\Models\AdminSubscriptionPlan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\GeneralHelper;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Log;
use Indipay;

class WebhookController extends Controller
{

    public function test() {
        $parameters = [
            'order_id' => '12345123',
            'amount' => 2500,
          ];
          
        $order = Indipay::gateway('CCAvenue')->prepare($parameters);

        return Indipay::process($order);
    }	

    public function indipayResponse(Request $request)
    {
        $response = Indipay::gateway('CCAvenue')->response($request);

        if(!$response) {
            $message = "No response found";
            return redirect('/error')->withMessage($message);
        }

        if(!$response['order_id']) {
            $message = "Invalid response";
            return redirect('/error')->withMessage($message);
        }

        $paymentTransaction = PaymentTransaction::with('payable')
            ->where('channel_order_id', $response['order_id'])
            ->first();

        $invoice = $paymentTransaction->payable;

        if($response['order_status'] == 'Success') {

            if($paymentTransaction->status != 'paid') {

                $paymentTransaction->status = 'paid';
                $paymentTransaction->save();
    
                $invoice->payment_method = 'online';
                $invoice->payment_status = 'paid';
                $invoice->status = 'completed';
    
                $invoice->amount_recieved = $invoice->amount_recieved + $paymentTransaction->amount;
    
                $invoice->calculatePayments();
                $invoice->save();
    
                GeneralHelper::processInvoicable($invoice, $paymentTransaction->channel_order_id);
            }

            $message = "You have successfuly placed your order";
            return redirect('/user/invoices')->withMessage($message);
        }

        else {
            $paymentTransaction->status = 'failed';
            $paymentTransaction->save();
            $message = "Payment transaction failed";
            return redirect('/error')->withMessage($message);
        }
    
    }  

    public function razorpayResponse(Request $request)
    {
        $paymentTransaction = PaymentTransaction::with('payable')->find($request->payment_transaction_id);

        $responseData = GeneralHelper::verifyRazorpayPayment($request->razorpay_payment_id);

        $invoice = $paymentTransaction->payable;

        if($responseData && $responseData->status == 'authorized') {
            $paymentTransaction->status = 'paid';
            $paymentTransaction->save();

            $invoice->payment_method = 'online';
            $invoice->payment_status = 'paid';
            $invoice->status = 'complete';

            $invoice->amount_recieved = $invoice->amount_recieved + $paymentTransaction->amount;
            $invoice->calculatePayments();
            $invoice->save();

            GeneralHelper::processInvoicable($invoice, $paymentTransaction->channel_order_id);
            $message = "You have successfuly paid invoice $invoice->invoice_number.";
            return redirect('/user/invoices')->withMessage($message);
        } 
        else {
            $paymentTransaction->status = 'failed';
            $paymentTransaction->save();
            $message = "Your wallet can not be updated please try again";
            return redirect('/error')->withMessage($message);
        }
    }


    public function paypalResponse(Request $request)
    {
        // dd($request->all());
        $paymentTransaction = PaymentTransaction::with(
            [
                'payable',
                'admin',
            ]
        )->find($request->transaction_id);

        $responseData = json_decode($request->response, true);

        $paymentTransaction->response = $responseData;
        $paymentTransaction->save();

        if(isset($responseData['state']) 
            && $responseData['state'] == 'approved'
            && isset($responseData['payer']['status'])
            && $responseData['payer']['status'] == 'VERIFIED'    
        
        ) {
            $paymentTransaction->status = 'paid';
            $paymentTransaction->save();

            $vendor = Admin::find($paymentTransaction->admin_id);
            if($request->subscription_log_id){
                $lastPaidPlanLog = SubscriptionPlanLog::where('admin_id', '=', $paymentTransaction->admin_id)
                ->where('status', '=', 'paid')
                ->latest()
                ->first(); 

                $lastPaidPlanLog->plan_upgraded_at = date('Y-m-d H:i:s');
                $lastPaidPlanLog->update();

                $log = SubscriptionPlanLog::find($request->subscription_log_id);
                $vendor->subscription_plan_id = $log->subscription_plan_id;
            }
            $vendor->is_payment_done = 1;
            $vendor->save();

            $paymentTransaction->load(['admin']);

            $plan = SubscriptionPlan::find($paymentTransaction->admin->subscription_plan_id);
            
            $expiresAt = null;
            if(strtolower(@$plan->plan_type) == 'monthly'){
                $expiresAt = date('Y-m-d H:i:s', strtotime('+1 month'));
            }else if(strtolower(@$plan->plan_type) == 'yearly'){
                $expiresAt = date('Y-m-d H:i:s', strtotime('+1 year'));
            }

            $vendorSubscriptionPlanMapping = new AdminSubscriptionPlan();
            $vendorSubscriptionPlanMapping->admin_id = $paymentTransaction->admin_id;
            $vendorSubscriptionPlanMapping->subscription_plan_id = $paymentTransaction->admin->subscription_plan_id;
            $vendorSubscriptionPlanMapping->plan_expires_at = $expiresAt;
            $vendorSubscriptionPlanMapping->status = 'paid';
            $vendorSubscriptionPlanMapping->save();

            $subscriptionPlanLog = SubscriptionPlanLog::firstOrNew(['id' => $request->subscription_log_id]);
            $subscriptionPlanLog->plan_amount = $plan->price;
            $subscriptionPlanLog->admin_id = $paymentTransaction->admin_id;
            $subscriptionPlanLog->plan_expires_at = $expiresAt;
            $subscriptionPlanLog->subscription_plan_id = $paymentTransaction->admin->subscription_plan_id;
            $subscriptionPlanLog->status = 'paid';
            $subscriptionPlanLog->save();

            $paymentTransaction->subscription_plan_log_id = $subscriptionPlanLog->id;
            $paymentTransaction->update();

            $message = "Amount has been recieved successfuly";
            return redirect('/dashboard')->with(['success' => $message]);
        } 
        else {
            $paymentTransaction->status = 'failed';
            $paymentTransaction->save();

            $subscriptionPlanLog = SubscriptionPlanLog::firstOrNew(['id' => $request->subscription_log_id]);
            $subscriptionPlanLog->admin_id = $paymentTransaction->admin_id;
            $subscriptionPlanLog->subscription_plan_id = $paymentTransaction->admin->subscription_plan_id;
            $subscriptionPlanLog->status = 'failed';
            $subscriptionPlanLog->save();

            $message = "Your wallet can not be updated please try again";
            return redirect('/error')->withMessage($message);
        }
    }

    public function discordResponse(Request $request)
    {
        // dd('hi');
        $discord_code = 200;
		$payload = [
			'code' => $discord_code,
			'client_id' => env('DISCORD_CLIENT_KEY', ''),
			'client_secret' => env('DISCORD_CLIENT_SECRET', ''),
			'grant_type' => 'authorization_code',
			'redirect_uri' => env('DISCORD_REDIRECT_URI', ''),
			'scope' => 'identify%20email%20guilds',
		];

		// dd($payload);

		$payload_string = http_build_query($payload);
		$discord_token_url = "https://discordapp.com/api/oauth2/token";

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $discord_token_url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		$result = curl_exec($ch);

		if(!$result){
			echo curl_error($ch);
		}
        dd($result);
		$result = json_decode($result,true);
		$access_token = $result['access_token'];

		$discord_users_url = "https://discordapp.com/api/users/@me";
		$header = array("Authorization: Bearer $access_token", "Content-Type: application/x-www-form-urlencoded");

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_URL, $discord_users_url);
		curl_setopt($ch, CURLOPT_POST, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		$result = curl_exec($ch);

		$result = json_decode($result, true);
		
		// if (!$username) {
		// 	throw new ApiGenericException("Username is required");
		// }
		
		return array(
            'message' => __('message.logged_in_successfully'),
            'data' => $result,
            'access_token' => $access_token,
        );


        $response = Indipay::gateway('CCAvenue')->response($request);

        if(!$response) {
            $message = "No response found";
            return redirect('/error')->withMessage($message);
        }

        if(!$response['order_id']) {
            $message = "Invalid response";
            return redirect('/error')->withMessage($message);
        }

        $paymentTransaction = PaymentTransaction::with('payable')
            ->where('channel_order_id', $response['order_id'])
            ->first();

        $invoice = $paymentTransaction->payable;

        if($response['order_status'] == 'Success') {

            if($paymentTransaction->status != 'paid') {

                $paymentTransaction->status = 'paid';
                $paymentTransaction->save();
    
                $invoice->payment_method = 'online';
                $invoice->payment_status = 'paid';
                $invoice->status = 'completed';
    
                $invoice->amount_recieved = $invoice->amount_recieved + $paymentTransaction->amount;
    
                $invoice->calculatePayments();
                $invoice->save();
    
                GeneralHelper::processInvoicable($invoice, $paymentTransaction->channel_order_id);
            }

            $message = "You have successfuly placed your order";
            return redirect('/user/invoices')->withMessage($message);
        }

        else {
            $paymentTransaction->status = 'failed';
            $paymentTransaction->save();
            $message = "Payment transaction failed";
            return redirect('/error')->withMessage($message);
        }
    
    }

}
