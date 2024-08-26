<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});

Route::group(
	['prefix' => 'v1','middleware' => ['apiresponse']], function () {

	Route::get('/', 'IndexController@index');
	Route::post('login', 'API\AuthController@login');
	Route::get('release', 'API\V1\ReleaseManagementController@index');
	Route::get('country-codes', 'API\DashboardController@countryCodes');

	Route::post('forgot-password', 'API\AuthController@submitPassword');
	Route::get('verify-otp', 'API\AuthController@viewOtp');
	Route::get('reset-password', 'API\AuthController@reset');
	Route::post('reset-password', 'API\AuthController@resetPassword');
	
	Route::post('send-otp', 'API\AuthController@sendOtp');
	Route::post('verify-otp', 'API\AuthController@verifyOtp');

});

Route::group(
	['prefix' => 'v1','middleware' => ['apiresponse', 'auth:api']], function () {

	Route::get('reset-data', 'API\V1\EmployeeController@resetData');
	Route::post('change-password', 'API\V1\EmployeeController@updatePassword');
	
	// Dashboard And Master API's
	Route::get('/logout', 'API\DashboardController@logout');
	Route::get('/deactivate/user', 'API\DashboardController@deactivateUser');
	
	//Dashboard
	Route::get('dashboard', 'API\DashboardController@index');
	Route::get('/watch-time', 'API\DashboardController@todayWatchTime');
	Route::get('dashboard-performance', 'API\DashboardController@indexPerformance');
	Route::get('android-app-performance', 'API\DashboardController@androidAppPerformance');
	Route::get('ios-app-performance', 'API\DashboardController@iosAppPerformance');
	Route::get('top-transactions', 'API\DashboardController@topTransactions');
	Route::get('transactions', 'API\DashboardController@transactions');
	Route::get('/offer/{id}/promo-code', 'API\DashboardController@getPromoCode');

	//Offers API's
	Route::get('/offer-categories', 'API\OfferController@offerCategories');
	Route::get('/offers', 'API\OfferController@index');
	Route::get('/offer/{id}/view', 'API\OfferController@show');
	Route::post('/buy-offer', 'API\OfferController@buyOffer');

	//Events API's
	Route::get('/events', 'API\EventController@index');
	Route::get('/event/{id}/view', 'API\EventController@show');
	Route::post('/join-event', 'API\EventController@joinEvent');

	// Submit Android Apps Data Routes
    Route::post('/android/app-logs', 'API\DashboardController@saveAndroidAppLogs');
	// Submit Ios Apps Data Routes
    Route::post('/ios/app-logs', 'API\DashboardController@saveIosAppLogs');
	
	//Profile Routes
	Route::get('/profile', 'API\UserController@profile');
	Route::post('/profile', 'API\UserController@updateAccount');
	Route::post('/change-password', 'API\UserController@updatePassword');
	
	// Main Admin And Contractor Routes
    Route::get('admin-roles', 'API\AdminController@roles');
    Route::get('main/{type}', 'API\AdminController@index');
    Route::get('main/{type}/{id}/view', 'API\AdminController@show');
    Route::post('main/{type}/create', 'API\AdminController@store');
    Route::post('main/{type}/{id}/edit', 'API\AdminController@update');

	Route::get('notifications', 'API\\NotificationController@index');
	Route::post('notification/read', 'API\NotificationController@markRead');
	Route::get('notifications/test', 'API\NotificationController@test');
	Route::get('notification/{notification}/view', 'API\NotificationController@view');
	Route::get('notification/{notification}/clear', 'API\NotificationController@clear');
	Route::get('notification/read-all', 'API\NotificationController@markAllRead');
	Route::get('notification/clear-all', 'API\NotificationController@clearAll');
	Route::post('send-push-notification', 'API\DashboardController@pushNotification');
	
	//For root user only
	Route::post('notification', 'API\V1\NotificationController@store');

	Route::get('notice', 'API\V1\NoticeController@get');

	Route::post('account/settingsupdate', 'API\V1\EmployeeController@settingsupdate');
	Route::post('sos_call', 'API\V1\EmployeeController@sosUpdate');

	//Twitch Videos API's
	Route::get('/twitch-videos', 'API\TwitchVideoController@index');

});

Route::group(
	['prefix' => 'v2','middleware' => ['apiresponse']], function () {

	Route::post('device-attendance', 'API\V2\AttendanceController@deviceAttendance');
	
});
