<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', 'HomeController@index');
// Route::get('home', 'HomeController@index');
Route::get('imap', 'IMAPController@index');



// WebHooks Routes
Route::post('indipay/response', 'WebhookController@indipayResponse');
Route::post('razorpay/response', 'WebhookController@razorpayResponse');
Route::post('paypal-response', 'WebhookController@paypalResponse');
Route::get('discord-callback', 'WebhookController@discordResponse');

Route::group(['middleware' => ['auth']], function () {
    Route::get('stripe', 'Payment\StripeController@index');
    Route::post('stripe', 'Payment\StripeController@makePayment')->name('make-stripe-payment');
    Route::get('stripe/cancel', 'Payment\StripeController@cancel')->name('cancel-stripe-payment');
    Route::get('stripe/success', 'Payment\StripeController@success')->name('success-stripe-payment');
});


Auth::routes();

// Route::pattern('domain', '(reseller-abhishek.uat.miditech.co.in|rsl01.midihost.com)');
// Route::group(['domain' => '{domain}'], function() {
//Route::domain('{reseller}.' . env('BASE_URL'))->group(function () {

