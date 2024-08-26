<?php

namespace App\Helpers;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Models\Address;
use App\Models\Currency;
use App\Models\Notification;
use App\Models\OauthAccessToken;
use App\Models\NotificationAdminMapping;

use App\Helpers\ConstantHelper;
use App\Models\DayWisePoolMaster;
use App\Models\DayWiseSummary;
use App\Models\PoolMaster;
use Razorpay\Api\Api as RazorPay;

class GeneralHelper
{
	// send sms to user
	public static function sendSMS($dataSet)
	{

		$mobileNo = $dataSet['mobile'];
		$sms_text = $dataSet['message'];

		$url = env('SMS_API_URL', '/');
		$userName = env('SMS_USERNAME', '');
		$password = env('SMS_PASSWORD', '');
		$senderID = env('SMS_SENDER_ID', '');


		// Replace special charactor

		$frm = array("#", "$", "&", "*", "<| ", ">| ", "?", "@", "[", "\\", "]", "{", "|", "}", "~", "\n");
		$to = array("&#35;", "&#36;", "&#38;", "&#42;", "&#60;", "&#62;", "&#63;", "&#64;", "&#91;", "&#92;", "&#93;", "&#123;", "&#124;", "&#125;", "&#126;", "&#10;");

		// For English encode the URL
		$sms_text = str_replace($frm, $to, $sms_text);
		$sms_text = str_replace("\"", "&#34;", $sms_text);
		$queryString = urlencode('<?xml version="1.0" encoding="ISO-8859-1"?><!DOCTYPE MESSAGE SYSTEM "http://127.0.0.1/psms/dtd/message.dtd" ><MESSAGE><USER USERNAME="' . $userName . '" PASSWORD="' . $password . '"/><SMS UDH="0" CODING="1" TEXT="' . $sms_text . '" PROPERTY="0" ID="2864"><ADDRESS FROM="' . $senderID . '" TO="91' . $mobileNo . '" SEQ="1" TAG="some customer end random data" /></SMS></MESSAGE>');

		$url .=  '?data=' . $queryString . '&action=send';

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL            => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			// CURLOPT_CUSTOMREQUEST  => "POST",
			// CURLOPT_POSTFIELDS     => "{\"name\": \"Sheela Foam Ltd.\"}",
			CURLOPT_HTTPHEADER => array(
				"Cache-Control: no-cache",
				"Postman-Token: 3978abb7-d73a-44d6-8006-bae57dd6c7aa"
			),
		));

		$output = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		return array('output' => $output, 'error' => $err);
	}

	// send otp
	public static function sendOTP($dataSet)
	{

		$mobileNo = $dataSet['mobile'];
		$sms_text = $dataSet['message'];

		$url = env('SMS_API_URL', '/');
		$userName = env('SMS_USERNAME', '');
		$password = env('SMS_PASSWORD', '');
		$senderID = env('SMS_SENDER_ID', '');


		// Replace special charactor

		$frm = array("#", "$", "&", "*", "<| ", ">| ", "?", "@", "[", "\\", "]", "{", "|", "}", "~", "\n");
		$to = array("&#35;", "&#36;", "&#38;", "&#42;", "&#60;", "&#62;", "&#63;", "&#64;", "&#91;", "&#92;", "&#93;", "&#123;", "&#124;", "&#125;", "&#126;", "&#10;");

		// For English encode the URL
		$sms_text = str_replace($frm, $to, $sms_text);
		$sms_text = str_replace("\"", "&#34;", $sms_text);
		$queryString = urlencode('<?xml version="1.0" encoding="ISO-8859-1"?>
		<!DOCTYPE MESSAGE SYSTEM "http://127.0.0.1:80/psms/dtd/messagev12.dtd">
		<MESSAGE VER="1.2">
		<USER USERNAME="' . $userName . '" PASSWORD="' . $password . '" />
		<SMS  UDH="0" CODING="1" TEXT="&#60;&#35;&#62; ' . $sms_text . '" PROPERTY="0" ID="1" TEMPLATE="" EMAILTEXT="" ATTACHMENT="">
		<ADDRESS FROM="' . $senderID . '" TO="' . $mobileNo . '" EMAIL="" SEQ="1" TAG="some clientside random data"/>
		</SMS>
		</MESSAGE>');

		$url .=  '?data=' . $queryString . '&action=send';

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL            => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			// CURLOPT_CUSTOMREQUEST  => "POST",
			// CURLOPT_POSTFIELDS     => "{\"name\": \"Sheela Foam Ltd.\"}",
			CURLOPT_HTTPHEADER => array(
				"Cache-Control: no-cache",
				"Postman-Token: 3978abb7-d73a-44d6-8006-bae57dd6c7aa"
			),
		));

		$output = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		return array('output' => $output, 'error' => $err);
	}

	// send wattsapp message to user
	public static function whatsApp($dataSet)
	{

		$mobileNo = $dataSet['mobile'];

		$url = env('WHATSAPP_API_URL', '/');
		$userName = env('WHATSAPP_USERNAME', '');
		$password = env('WHATSAPP_PASSWORD', '');


		$queryString = urlencode('<?xml version="1.0" encoding="ISO-8859-1"?><!DOCTYPE MESSAGE SYSTEM "http://127.0.0.1:80/psms/dtd/messagev12.dtd"><MESSAGE VER="1.2"><USER USERNAME="' . $userName . '" PASSWORD="' . $password . '"/><SMS  UDH="0" CODING="1" TEXT="Target : 532 Cr
Achievement  : 340.7 Cr
DMA :  4.8 Cr
Daily Required Run Rate  : 9.6 Cr
Y&#39;day Despatches : 5.5 Cr
Order Pendency : 21.61 Cr
Y&#39;Day Order Receiving: 4.02 Cr" PROPERTY="0" ID="1" TEMPLATE="" EMAILTEXT="" ATTACHMENT=""><ADDRESS FROM="918448256006" TO="91' . $mobileNo . '" EMAIL="" SEQ="1" TAG="some clientside random data"	 /></SMS></MESSAGE>');

		$url .=  '?data=' . $queryString . '&action=send';

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL            => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			// CURLOPT_CUSTOMREQUEST  => "POST",
			// CURLOPT_POSTFIELDS     => "{\"name\": \"Sheela Foam Ltd.\"}",
			CURLOPT_HTTPHEADER => array(
				"Cache-Control: no-cache",
				"Postman-Token: 3978abb7-d73a-44d6-8006-bae57dd6c7aa"
			),
		));

		$output = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		return array('output' => $output, 'error' => $err);
	}


	public static function randomGenerateString()
	{
		$result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$uniqueKey = substr(str_shuffle($result), 0, 8);

		return $uniqueKey;
	}

	public static function sendRazorPaymentLink($paymentTransaction)
	{

		$keyId = env('RAZORPAY_KEY_ID', '');
		$keySecret =  env('RAZORPAY_KEY_SECRET', '');
		$razorpay = new RazorPay($keyId, $keySecret);

		$payloadData = array(
			'type' => 'link',
			'amount' => ($paymentTransaction->amount * 100),
			'description' => 'For sale invoice',
			'customer' => array(
				'email' => $paymentTransaction->payee_email,
				'contact' => $paymentTransaction->payee_mobile,
				'name' => $paymentTransaction->payee_name
			)
		);
		try {
			$result = $razorpay->invoice->create($payloadData);
			if ($result) {
				$paymentTransaction->status = "issued"; //$result->status;
				$paymentTransaction->channel_invoice_id = $result->id;
				$paymentTransaction->channel_order_id = $result->order_id;
				// $payment_link->amount = floatval($result->amount)/100;
				// $payment_link->sms_status = $result->sms_status;
				// $payment_link->email_status = $result->email_status;
				$paymentTransaction->payment_link = $result->short_url;
				// $payment_link->expire_by = date("Y-m-d H:i:s", $result->expire_by);
				// $payment_link->expired_at = null;
				$paymentTransaction->save();
				return true;
			} else return false;
		} catch (\Exception $e) {
			return false;
		}
	}

	public static function createRazorpayOrder($paymentTransaction)
	{

		$keyId = env('RAZORPAY_KEY_ID', '');
		$keySecret =  env('RAZORPAY_KEY_SECRET', '');
		$razorpay = new RazorPay($keyId, $keySecret);
		$payloadData = array(
			'receipt' => $paymentTransaction->id,
			'currency' => $paymentTransaction->currency,
			'amount' => ($paymentTransaction->amount * 100)
		);
		try {
			$result = $razorpay->order->create($payloadData);

			if ($result) {
				$paymentTransaction->status = "created";
				$paymentTransaction->channel_order_id = $result->id;
				$paymentTransaction->save();
				return $paymentTransaction;
			} else return false;
		} catch (\Exception $e) {
			dd($e);
			return false;
		}
	}

	public static function verifyRazorpayPayment($paymentId)
	{

		$keyId = env('RAZORPAY_KEY_ID', '');
		$keySecret =  env('RAZORPAY_KEY_SECRET', '');
		$razorpay = new RazorPay($keyId, $keySecret);

		try {
			return $razorpay->payment->fetch($paymentId);
		} catch (\Exception $e) {
			return false;
		}
	}

	public static function cancelRazorPaymentLink($paymentTransaction)
	{

		$keyId = env('RAZORPAY_KEY_ID', '');
		$keySecret =  env('RAZORPAY_KEY_SECRET', '');
		$razorpay = new RazorPay($keyId, $keySecret);

		try {
			$link = $razorpay->invoice->fetch($paymentTransaction->channel_invoice_id);
			$result = $link->cancel();
			if ($result) {
				$paymentTransaction->status = "cancelled";
				$paymentTransaction->save();
				return true;
			} else return false;
		} catch (\Exception $e) {
			return false;
		}
	}

	public static function numberToWords($amount)
	{

		$f = new \NumberFormatter(locale_get_default(), \NumberFormatter::SPELLOUT);
		$amountInWord = $f->format($amount);

		return $amountInWord;
	}

	public static function convertAmountCurrencyHtml($amount, $currencyOld)
	{
		$user = \Auth::user();
		$currencyNew = (($user && $user->currency) ? $user->currency->alias : 'aud');
		$amount = self::convertAmountCurrency($amount, $currencyOld, $currencyNew);
		$currencySign = '$';
		if ($currencyNew == 'inr') {
			$currencySign = 'Rs.';
		}
		return $currencySign . ' ' . $amount;
	}

	public static function convertAmountCurrency($amount, $currencyOld, $currencyNew)
	{
		$currencyRate = CurrencyRate::first();

		if (!$currencyRate) {
			return $amount;
		}

		if ($currencyOld == 'INR' && $currencyNew == 'USD') {
			return  (int)(round($amount / $currencyRate->value, 2));
		}

		if ($currencyOld == 'USD' && $currencyNew == 'INR') {
			return  (int)($amount * $currencyRate->value);
		}

		return $amount;
	}

	public static function saveOrderForClient($clientOrder)
	{
		$billingAddress = Address::with(['city', 'state', 'country'])
			->where('addressable_id', '=', $clientOrder->reseller_id)
			->first();

		$reseller = User::find($clientOrder->reseller_id);

		$clientOrder->load('items');
		$order = new Order();
		$order->fill($clientOrder->toArray());
		$order->created_by = $clientOrder->reseller_id;
		$order->save();


		$invoice = $order->invoice()->create([
			'user_id' => $clientOrder->reseller_id,
			'invoice_type' => 'new_order',
			'due_date' => date('Y-m-d'),
			'created_by' => $clientOrder->reseller_id
		]);
		$itcx = 0;
		foreach ($clientOrder->items as $k =>  $item) {

			$record = $item->toArray();
			$record['order_id'] = $order->id;
			$orderItem = new OrderItem();
			$orderItem->fill($record);

			$orderItem->unit_price = GeneralHelper::getProductServiceUnitPrice($orderItem->product_service_id, $order->mode, $reseller->currency_id);
			$orderItem->save();

			$productService = ProductService::with('attributes')
				->find($orderItem->product_service_id);

			$itemName = "<strong> $orderItem->product_service_name </strong>";

			if ($orderItem->host_name) {
				$itemName .= "<br/> Hostname: " . $orderItem->host_name;
			}
			if ($orderItem->ns1_prefix) {
				$itemName .= "<br/> ns1 prefix: " . $orderItem->ns1_prefix;
			}
			if ($orderItem->ns2_prefix) {
				$itemName .= "<br/> ns2 prefix: " . $orderItem->ns2_prefix;
			}

			if ($orderItem->ns3_prefix) {
				$itemName .= "<br/> ns4 prefix: " . $orderItem->ns3_prefix;
			}

			if ($orderItem->ns4_prefix) {
				$itemName .= "<br/> ns4 prefix: " . $orderItem->ns4_prefix;
			}

			foreach ($productService->attributes as  $val) {
				$itemName .= "<br/>$val->name";
			}
			$itcx = $itcx + 1;
			$invoiceItem = new InvoiceItem();
			$invoiceItem->fill([
				'invoice_id' => $invoice->id,
				'item_sequence' => $itcx,
				'item_code' => "TEST001",
				'item' => $itemName,
				'unit_price' => $orderItem->unit_price,
				'quantity' => 1,
				'is_taxable' => $productService->tax_applicable,
			]);

			$invoiceItem->save();

			$clientOrderItemConfigOptions = ClientOrderItemOption::where('item_id', $item->id)->get();

			$configOptionTotal = 0;
			foreach ($clientOrderItemConfigOptions as $configOption) {

				$option = $configOption->toArray();
				$option['item_id'] = $orderItem->id;
				$orderItemConfigOption = new OrderItemConfigOption();
				$orderItemConfigOption->fill($option);
				$orderItemConfigOption->unit_price = GeneralHelper::getConfigServiceOptionUnitPrice($orderItemConfigOption->config_service_option_id, $order->mode, $reseller->currency_id);
				$orderItemConfigOption->total_amount = ($orderItemConfigOption->unit_price * $orderItemConfigOption->quantity);
				$orderItemConfigOption->save();

				$configOptionTotal += $orderItemConfigOption->total_amount;

				//  $itemName = $orderItemConfigOption->config_group_service_name ." :: ". $orderItemConfigOption->config_service_option_name;
				$itemName = $orderItemConfigOption->config_group_service_name;
				$invoiceItem = new InvoiceItem();

				$invoiceItem->fill([
					'invoice_id' => $invoice->id,
					'item_sequence' => $itcx,
					'item_code' => "TEST001",
					'item' => $itemName,
					'unit_price' => $orderItemConfigOption->unit_price,
					'quantity' => $orderItemConfigOption->quantity,
					'is_taxable' => $productService->tax_applicable,
				]);
				$invoiceItem->save();
			}

			$orderItem->config_total = $configOptionTotal;
			$orderItem->save();
		}

		$order->order_number = $order->id;

		$order->save();

		$invoice->invoice_number = '#INV/' . $invoice->id;
		$invoice->calculateInvoice();
		$invoice->calculatePayments();
		$invoice->save();

		$invoice->sendInvoiceConfirmationMail();

		$payableAmount = $invoice->invoice_total;
		$clientInvoice = ClientInvoice::where('invoiceable_id', $clientOrder->id)->first();
		$paymentTransaction = PaymentTransaction::where('payable_id', $clientInvoice->id)->first();
		if ($paymentTransaction->payment_channel_id  && $payableAmount > 0) {

			$paymentChannel = PaymentChannel::find($paymentTransaction->payment_channel_id);

			$paymentTransaction = $invoice->paymentTransactions()->create(
				[
					'payment_channel_id' => $paymentChannel->id,
					'user_id' => $order->created_by,
					'payee_name' => $billingAddress->name,
					'payee_email' => $billingAddress->email,
					'payee_mobile' => $billingAddress->mobile,
					'amount' => $payableAmount,
					'currency' => $invoice->currency
				]
			);
		}

		if ($payableAmount == 0) {

			$order->status = 'approved';
			$order->save();

			$invoice->payment_method = 'wallet';
			$invoice->payment_status = 'paid';
			$invoice->status = 'complete';
			$invoice->save();

			GeneralHelper::generateUserService($order);
			$order->sendOrderConfirmationMail();
		}

		$message = "You have successfuly placed your order with order no : " . $order->order_number;
		return $order;
	}

	public static function productCategory()
	{

		return $productCategory = ProductCategory::with('childs')
			->whereNull('parent_id')->orderBy('id', 'DESC');
	}

	public static function getFileType($fileRequestData)
	{
		$type = $fileRequestData->getMimeType();
		return explode("/", $type)[0];
	}

	public static function getTimeSlots($duration, $start, $end)
	{

		$time = array();
		$start = new \DateTime($start);
		$end = new \DateTime($end);
		$start_time = $start->format('H:i');
		$end_time = $end->format('H:i');
		$currentTime = strtotime(Date('Y-m-d H:i'));
		$i = 0;

		while (strtotime($start_time) <= strtotime($end_time)) {
			$start = $start_time;
			$end = date('H:i', strtotime('+' . $duration . ' minutes', strtotime($start_time)));
			$start_time = date('H:i', strtotime('+' . $duration . ' minutes', strtotime($start_time)));

			$today = Date('Y-m-d');
			$slotTime = strtotime($today . ' ' . $start);

			//if($slotTime > $currentTime){
			if (strtotime($start_time) <= strtotime($end_time)) {
				$time[$i]['start'] = date('h:i a', strtotime($start));
				$time[$i]['end'] = date('h:i a', strtotime($end));
				$time[$i]['value'] = date('h:i:s A', strtotime($start));
			}
			$i++;
			//}

		}
		return $time;
	}



	/**
	 * Each request to start or join a meeting / webinar must be verified by an encrypted signature authorizing
	 * each user to enter. A signature must be generated each time you join a meeting or webinar on a backed
	 * service where your credentials can be stored securely.
	 * @param $meeting_number integer Meeting number being joined
	 * @param $role integer 1 for meeting host, 0 for participants & joining webinars
	 * @return string signature
	 */
	public static function generateZoomSignature(int $meeting_number, int $role): string
	{
		//Set the timezone to UTC
		date_default_timezone_set("UTC");
		$time = time() * 1000 - 30000; //time in milliseconds (or close enough)
		$data = base64_encode(env('ZOOM_JWT_KEY', '') . $meeting_number . $time . $role);
		$hash = hash_hmac('sha256', $data, env('ZOOM_JWT_SECRET', ''), true);
		$_sig = env('ZOOM_JWT_KEY', '') . "." . $meeting_number . "." . $time . "." . $role . "." . base64_encode($hash);
		//return signature, url safe base64 encoded
		return rtrim(strtr(base64_encode($_sig), '+/', '-_'), '=');
	}

	public static function modules()
	{

		$user = \Auth::guard('designer')->user();

		$designerModules = Module::whereHas(
			'designerModules',
			function ($q) use ($user) {
				$q->where('designer_id', $user->id);
			}
		)->get();

		return $designerModules;
	}

	// send Push notifications
	public static function sendNotification($data)
	{
		try {
			$notification = new Notification();
			$notification->equipment_detail_type = $data['equipment_detail_type'];
			$notification->equipment_detail_id = $data['equipment_detail_id'];
			$notification->admin_type = $data['admin_type'];
			$notification->admin_id = $data['admin_id'];
			$notification->status = $data['status'];
			$notification->description = $data['description'];
			$notification->created_by = $data['created_by'];
			$notification->save();

			if ($data['admin_ids'] && !empty($data['admin_ids'])) {
				foreach ($data['admin_ids'] as $adminId) {
					$mappingData = NotificationAdminMapping::where('notification_id', $notification->id)
						->where('admin_id', $adminId)
						->first();
					if ($mappingData) {
						continue;
					} else {
						$newMapping = new NotificationAdminMapping();
						$newMapping->notification_id = $notification->id;
						$newMapping->admin_id = $adminId;
						$newMapping->save();
					}
				}
			}

			return true;
		} catch (\Exception $e) {
			return false;
		}
	}

	// send Push notifications
	public static function sendPushNotification($data)
	{
		$accessTokens = OauthAccessToken::whereIn('admin_id', $data['admin_ids'])
			->whereNotNull('firebase_id')
			->orderBy('updated_at', 'DESC')
			->get();

		$notification = new Notification();
		$notification->equipment_detail_type = $data['equipment_detail_type'];
		$notification->equipment_detail_id = $data['equipment_detail_id'];
		$notification->admin_type = $data['admin_type'];
		$notification->admin_id = $data['admin_id'];
		$notification->status = $data['status'];
		$notification->description = $data['description'];
		$notification->created_by = $data['created_by'];
		$notification->save();

		if ($accessTokens && !empty($accessTokens)) {
			foreach ($accessTokens as $accessToken) {
				$mappingData = NotificationAdminMapping::where('notification_id', $notification->id)
					->where('admin_id', $accessToken->admin_id)
					->first();
				if ($mappingData) {
					continue;
				} else {
					$newMapping = new NotificationAdminMapping();
					$newMapping->notification_id = $notification->id;
					$newMapping->admin_id = $accessToken->admin_id;
					$newMapping->save();
				}
			}
		}

		$headers = [
			'Authorization: key=' . env('FIREBASE_KEY', ''),
			'Content-Type: application/json'
		];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,  env('FIREBASE_URL', ''));
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

		$output = curl_exec($ch);
		$err = curl_error($ch);

		curl_close($ch);
		return array('output' => $output, 'error' => $err);
	}

	public static function calculateWxrkCoins($price)
	{
		$poolMaster = PoolMaster::latest()->first();
		$dayWisePoolMaster = DayWisePoolMaster::whereDate('pool_date', '=', date('Y-m-d'))->latest()->first();

		if ($poolMaster && $dayWisePoolMaster) {

			$wxrk_pool = $poolMaster->wxrk_pool;
			$base_value_against_usd = $poolMaster->base_value_against_usd;
			$pool_balance = $dayWisePoolMaster->pool_balance;
			$wxrk_balance = DayWiseSummary::whereDate('created_at', '=', date('Y-m-d'))->sum('wxrk_balance');

			$value_of_wxrk = $wxrk_pool / ($pool_balance - $wxrk_balance) * $base_value_against_usd;
			$price_in_wxrk = $price / $value_of_wxrk;
			
			return number_format((float)$price_in_wxrk, 2, '.', '');
		}
		return "0.00";
	}
}
