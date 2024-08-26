<?php
/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
|All routes for admin panel
|
*/

use App\User;
use App\Models\Role;
use App\Helpers\ConstantHelper;

Route::model('user', User::class);
Route::model('role', Role::class);

Route::get('/', 'IndexController@index');
Route::post('/submit/contact-form','IndexController@submitForm');
Route::get('/login', 'LoginController@adminLogin');
Route::get('/vendor/registration/{id}/subscription-plan', 'LoginController@vendorRegistration');
Route::post('/vendor/registration/{id}/subscription-plan', 'LoginController@saveVendorRegistration');
Route::get('/discord-login', 'LoginController@discordLogin');
Route::get('/forget-password', 'AdminLoginController@forgetPassword');
Route::post('/forget-password', 'AdminLoginController@submitPassword');
Route::post('/resend-otp', 'AdminLoginController@resendOtp');
Route::get('/verify-otp', 'AdminLoginController@viewOtp');
Route::post('/verify-otp', 'AdminLoginController@verifyOtp');
Route::get('/reset-password', 'AdminLoginController@reset');
Route::post('/reset-password', 'AdminLoginController@resetPassword');
Route::post('admin-login', 'AdminLoginController@mainLogin')->name('admin-login');
Route::get('/page-not-found', 'IndexController@pagenotfound');
Route::get('/pages/{alias}','IndexController@staticContent');
Route::get('/unauthorized/view','Master\AuthorizedController@show');


//Notification Routes
Route::get('/notification', 'Master\NotificationController@index');
Route::post('notification/read', 'Master\NotificationController@markRead');
Route::get('/notification/{id}/view', 'Master\NotificationController@view');

//Twitch Modules
Route::get('/twitch-videos', 'TwitchController@index');
Route::get('/video/{id}', 'TwitchController@video');

Route::get('/app-video/{id}', 'TwitchController@appVideo');
Route::post('/twitch-time-calculation', 'TwitchController@timeCalculation');

Route::post('/ajax/states', 'AjaxController@getStates');
Route::post('/ajax/cities', 'AjaxController@getCities');
Route::post('/ajax/subscription-plans', 'AjaxController@subscriptionPlans');
Route::post('/ajax/newsletter-subscribe', 'AjaxController@newsletterSubscribe');


Route::group(['middleware' => 'admin'], function () {
    Route::pattern('id', '[0-9]+');
    Route::pattern('id2', '[0-9]+');

    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/main-logout', 'DashboardController@logout');

    Route::get('/contact-us', 'ContactUsController@index');

    // Subscription plan vendor payment
    Route::get('/subscription-plan-payment', 'DashboardController@getPayment');
    Route::post('/subscription-plan-payment', 'DashboardController@makePayment');
    Route::get('/subscription-plan-upgrade', 'DashboardController@subscriptionPlanUpgrade');
    Route::post('/subscription-plan-upgrade-payment', 'DashboardController@subscriptionPlanUpgradePayment');
    Route::get('/subscribe-plan/{id}', 'DashboardController@subscribePlan');

    // Route::delete('delete-media/{id}', 'AjaxController@destroyMedia');
    Route::post('/update-allowed-detail', 'AjaxController@updateEquipmentDetail');
    
    Route::get('/profile', 'UserController@profile');
    Route::post('/profile', 'UserController@updateAccount');
    Route::get('/change-password', 'UserController@changePassword');
    Route::post('/change-password', 'UserController@updatePassword');

    //Users
    Route::get('/users', 'UserController@index');
    Route::get('/user/create', 'UserController@create');
    Route::post('/user/create', 'UserController@store');
    Route::get('/user/{id}/edit', 'UserController@edit');
    Route::get('/user/{id}/view', 'UserController@view');
    Route::put('/user/{user}/edit', 'UserController@update');
    Route::delete('/user/{id}/delete', 'UserController@destroy');

    //Vendors
    Route::get('/vendors', 'VendorController@index');
    Route::get('/vendor/create', 'VendorController@create');
    Route::post('/vendor/create', 'VendorController@store');
    Route::delete('/vendor/{id}/delete', 'VendorController@destroy');

    //Business Categories
    Route::get('/business-categories', 'Master\BusinessCategoryController@index');
    Route::get('/business-category/create', 'Master\BusinessCategoryController@create');
    Route::post('/business-category/create', 'Master\BusinessCategoryController@store');
    Route::get('/business-category/{id}/edit', 'Master\BusinessCategoryController@edit');
    Route::put('/business-category/{id}/edit', 'Master\BusinessCategoryController@update');
    Route::delete('/business-category/{id}/delete', 'Master\BusinessCategoryController@destroy');

    //Vendor Origins
    Route::get('/vendor-origins', 'Master\VendorOriginController@index');
    Route::get('/vendor-origin/create', 'Master\VendorOriginController@create');
    Route::post('/vendor-origin/create', 'Master\VendorOriginController@store');
    Route::get('/vendor-origin/{id}/edit', 'Master\VendorOriginController@edit');
    Route::put('/vendor-origin/{id}/edit', 'Master\VendorOriginController@update');
    Route::delete('/vendor-origin/{id}/delete', 'Master\VendorOriginController@destroy');

    //Offer Types
    Route::get('/offer-types', 'Master\OfferTypeController@index');
    Route::get('/offer-type/create', 'Master\OfferTypeController@create');
    Route::post('/offer-type/create', 'Master\OfferTypeController@store');
    Route::get('/offer-type/{id}/edit', 'Master\OfferTypeController@edit');
    Route::put('/offer-type/{id}/edit', 'Master\OfferTypeController@update');
    Route::delete('/offer-type/{id}/delete', 'Master\OfferTypeController@destroy');

    //Offer Categories
    Route::get('/offer-categories', 'Master\OfferCategoryController@index');
    Route::get('/offer-category/create', 'Master\OfferCategoryController@create');
    Route::post('/offer-category/create', 'Master\OfferCategoryController@store');
    Route::get('/offer-category/{id}/edit', 'Master\OfferCategoryController@edit');
    Route::put('/offer-category/{id}/edit', 'Master\OfferCategoryController@update');
    Route::delete('/offer-category/{id}/delete', 'Master\OfferCategoryController@destroy');

    //Premium Categories
    Route::get('/premium-categories', 'Master\PremiumCategoryController@index');
    Route::get('/premium-category/create', 'Master\PremiumCategoryController@create');
    Route::post('/premium-category/create', 'Master\PremiumCategoryController@store');
    Route::get('/premium-category/{id}/edit', 'Master\PremiumCategoryController@edit');
    Route::put('/premium-category/{id}/edit', 'Master\PremiumCategoryController@update');
    Route::delete('/premium-category/{id}/delete', 'Master\PremiumCategoryController@destroy');

    //Event Types
    Route::get('/event-types', 'Master\EventTypeController@index');
    Route::get('/event-type/create', 'Master\EventTypeController@create');
    Route::post('/event-type/create', 'Master\EventTypeController@store');
    Route::get('/event-type/{id}/edit', 'Master\EventTypeController@edit');
    Route::put('/event-type/{id}/edit', 'Master\EventTypeController@update');
    Route::delete('/event-type/{id}/delete', 'Master\EventTypeController@destroy');
    
    //Token Setting
    Route::get('/token-settings', 'Master\TokenSettingController@index');
    Route::get('/token-setting/create', 'Master\TokenSettingController@create');
    Route::post('/token-setting/create', 'Master\TokenSettingController@store');
    Route::get('/token-setting/{id}/edit', 'Master\TokenSettingController@edit');
    Route::put('/token-setting/{id}/edit', 'Master\TokenSettingController@update');
    Route::delete('/token-setting/{id}/delete', 'Master\TokenSettingController@destroy');

    //newsletter subscribe
    Route::get('/newsletter-subscriber', 'NewsletterSubscriber@index');

    //Support Management
    Route::get('/supports', 'SupportTicketController@index');
    Route::get('/support/create', 'SupportTicketController@create');
    Route::post('/support/create', 'SupportTicketController@store');
    Route::get('/support/{id}/edit', 'SupportTicketController@edit');
    Route::put('/support/{id}/edit', 'SupportTicketController@update');
    Route::delete('/support/{id}/delete', 'SupportTicketController@destroy');
    Route::post('/support/save-comments', 'SupportTicketController@saveComments');
    Route::post('/ajax/get-support-sub-category', 'SupportTicketController@getSubCategories');
    Route::post('/ajax/support-chat/create', 'SupportTicketController@storeChat');
    Route::post('/ajax/get-support-chats', 'SupportTicketController@getChats');
    
    //Support Category & SubCategory Management
    Route::get('/support-categories', 'Master\SupportCategoryController@index');
    Route::get('/support-category/create', 'Master\SupportCategoryController@create');
    Route::post('/support-category/create', 'Master\SupportCategoryController@store');
    Route::get('/support-category/{id}/edit', 'Master\SupportCategoryController@edit');
    Route::post('/support-category/{id}/edit', 'Master\SupportCategoryController@update');
    Route::delete('/support-category/{id}/delete', 'Master\SupportCategoryController@destroy');
    Route::get('/sub-categories', 'Master\SupportSubCategoryController@index');
    Route::get('/sub-category/create', 'Master\SupportSubCategoryController@create');
    Route::post('/sub-category/create', 'Master\SupportSubCategoryController@store');
    Route::get('/sub-category/{id}/edit', 'Master\SupportSubCategoryController@edit');
    Route::post('/sub-category/{id}/edit', 'Master\SupportSubCategoryController@update');
    Route::delete('/sub-category/{id}/delete', 'Master\SupportSubCategoryController@destroy');


    //Sponser Routes
    Route::get('/sponsers', 'Master\SponserController@index');
    Route::get('/sponser/create', 'Master\SponserController@create');
    Route::post('/sponser/create', 'Master\SponserController@store');
    Route::get('/sponser/{id}/edit', 'Master\SponserController@edit');
    Route::put('/sponser/{id}/edit', 'Master\SponserController@update');
    Route::delete('/sponser/{id}/delete', 'Master\SponserController@destroy');

    //Sponser Routes
    Route::get('/transaction-history', 'TransactionHistoryController@index');

    //PoolMaster Routes
    Route::get('/pool-master', 'Master\PoolMasterController@index');
    Route::get('/pool-master/create', 'Master\PoolMasterController@create');
    Route::post('/pool-master/create', 'Master\PoolMasterController@store');
    Route::get('/pool-master/{id}/edit', 'Master\PoolMasterController@edit');
    Route::put('/pool-master/{id}/edit', 'Master\PoolMasterController@update');
    Route::delete('/pool-master/{id}/delete', 'Master\PoolMasterController@destroy');
    
    //PlanType Routes
    Route::get('/plan-type', 'Master\PlanTypeController@index');
    Route::get('/plan-type/create', 'Master\PlanTypeController@create');
    Route::post('/plan-type/create', 'Master\PlanTypeController@store');
    Route::get('/plan-type/{id}/edit', 'Master\PlanTypeController@edit');
    Route::put('/plan-type/{id}/edit', 'Master\PlanTypeController@update');
    Route::delete('/plan-type/{id}/delete', 'Master\PlanTypeController@destroy');
    
    //PlanName Routes
    Route::get('/plan-name', 'Master\PlanNameController@index');
    Route::get('/plan-name/create', 'Master\PlanNameController@create');
    Route::post('/plan-name/create', 'Master\PlanNameController@store');
    Route::get('/plan-name/{id}/edit', 'Master\PlanNameController@edit');
    Route::put('/plan-name/{id}/edit', 'Master\PlanNameController@update');
    Route::delete('/plan-name/{id}/delete', 'Master\PlanNameController@destroy');

    //DayWisePoolMaster
    Route::get('/day-wise-pool-master', 'Master\DayWisePoolMasterController@index');
    Route::get('/day-wise-pool-master/calculate', 'Master\DayWisePoolMasterController@calculate');
    Route::get('/day-wise-pool-master/create', 'Master\DayWisePoolMasterController@create');
    Route::post('/day-wise-pool-master/create', 'Master\DayWisePoolMasterController@store');
    Route::get('/day-wise-pool-master/{id}/edit', 'Master\DayWisePoolMasterController@edit');
    Route::put('/day-wise-pool-master/{id}/edit', 'Master\DayWisePoolMasterController@update');
    Route::delete('/day-wise-pool-master/{id}/delete', 'Master\DayWisePoolMasterController@destroy');

    //Price View Routes
    Route::get('/price-views', 'Master\PriceViewController@index');
    Route::get('/price-view/create', 'Master\PriceViewController@create');
    Route::post('/price-view/create', 'Master\PriceViewController@store');
    Route::get('/price-view/{id}/edit', 'Master\PriceViewController@edit');
    Route::put('/price-view/{id}/edit', 'Master\PriceViewController@update');
    Route::delete('/price-view/{id}/delete', 'Master\PriceViewController@destroy');
    
    //Countries
    Route::get('/countries', 'Master\Location\CountryController@index');
    // Route::get('/country/create', 'Master\Location\CountryController@create');
    // Route::post('/country/create', 'Master\Location\CountryController@store');
    // Route::get('/country/{id}/edit', 'Master\Location\CountryController@edit');
    // Route::put('/country/{id}/edit', 'Master\Location\CountryController@update');
    // Route::delete('/country/{id}/delete', 'Master\Location\CountryController@destroy');
    
    //States
    Route::get('/states', 'Master\Location\StateController@index');
    // Route::get('/state/create', 'Master\Location\StateController@create');
    // Route::post('/state/create', 'Master\Location\StateController@store');
    // Route::get('/state/{id}/edit', 'Master\Location\StateController@edit');
    // Route::put('/state/{id}/edit', 'Master\Location\StateController@update');
    // Route::delete('/state/{id}/delete', 'Master\Location\StateController@destroy');
    
    //Cities
    Route::get('/cities', 'Master\Location\CityController@index');
    // Route::get('/city/create', 'Master\Location\CityController@create');
    // Route::post('/city/create', 'Master\Location\CityController@store');
    // Route::get('/city/{id}/edit', 'Master\Location\CityController@edit');
    // Route::put('/city/{id}/edit', 'Master\Location\CityController@update');
    // Route::delete('/city/{id}/delete', 'Master\Location\CityController@destroy');

    Route::delete('/delete-media/{media}', 'DashboardController@destroyMedia');

    //Subscription Plan Routes
    Route::get('/subscription-plans', 'Master\SubscriptionPlanController@index');
    Route::get('/subscription-plan/create', 'Master\SubscriptionPlanController@create');
    Route::post('/subscription-plan/create', 'Master\SubscriptionPlanController@store');
    Route::get('/subscription-plan/{id}/edit', 'Master\SubscriptionPlanController@edit');
    Route::put('/subscription-plan/{id}/edit', 'Master\SubscriptionPlanController@update');
    Route::delete('/subscription-plan/{id}/delete', 'Master\SubscriptionPlanController@destroy');
    Route::post('/get-subscription-plan', 'Master\SubscriptionPlanController@getSubscriptionPlans');

    //Events
    Route::get('/events', 'EventController@index');
    Route::get('/event/create', 'EventController@create');
    Route::post('/event/create', 'EventController@store');
    Route::get('/event/{id}/edit', 'EventController@edit');
    Route::put('/event/{id}/edit', 'EventController@update');
    Route::delete('/event/{id}/delete', 'EventController@destroy');

    //Banners
    Route::get('/banners', 'BannerController@index');
    Route::get('/banner/create', 'BannerController@create');
    Route::post('/banner/create', 'BannerController@store');
    Route::get('/banner/{id}/edit', 'BannerController@edit');
    Route::put('/banner/{id}/edit', 'BannerController@update');
    Route::delete('/banner/{id}/delete', 'BannerController@destroy');
    
    //Static contents
    Route::get('/static-contents', 'Master\StaticContentController@index');
    Route::get('/static-content/create', 'Master\StaticContentController@create');
    Route::post('/static-content/create', 'Master\StaticContentController@store');
    Route::get('/static-content/{id}/edit', 'Master\StaticContentController@edit');
    Route::put('/static-content/{id}/edit', 'Master\StaticContentController@update');
    Route::delete('/static-content/{id}/delete', 'Master\StaticContentController@destroy');

    //User Tokens
    Route::get('/user-wallets', 'Master\UserWalletController@index');
    Route::get('/user-wallet/{id}/day-wise-summary', 'Master\UserWalletController@dayWiseSummary');
    Route::get('/user-wallet/{id}/transactions/{type}', 'Master\UserWalletController@transactions');
});

Route::group(['roles' => [ConstantHelper::ROLE_ADMIN, ConstantHelper::ROLE_VENDOR], 'middleware' => 'admin'], function () {

    //Marketplaces
    Route::get('/marketplaces', 'MarketplaceController@index');
    Route::get('/marketplace/create', 'MarketplaceController@create');
    Route::post('/marketplace/create', 'MarketplaceController@store');
    Route::get('/marketplace/{id}/edit', 'MarketplaceController@edit');
    Route::get('/marketplace/{id}/view', 'MarketplaceController@view');
    Route::put('/marketplace/{id}/edit', 'MarketplaceController@update');
    Route::delete('/marketplace/{id}/delete', 'MarketplaceController@destroy');

    //Orders
    Route::get('/orders', 'OrderController@index');
    Route::get('/order/create', 'OrderController@create');
    Route::post('/order/create', 'OrderController@store');
    Route::get('/order/{id}/edit', 'OrderController@edit');
    Route::put('/order/{id}/edit', 'OrderController@update');
    Route::get('/order/{id}/view', 'OrderController@view');
    Route::delete('/order/{id}/delete', 'OrderController@destroy');

    //Promocodes Routes
    Route::post('/promo-codes/submit', 'PromoCodeController@store');
    Route::delete('/promo-code/{id}/delete', 'PromoCodeController@destroy');
    
    //Vendor Edit/Update Routes
    Route::get('/vendor/{id}/edit', 'VendorController@edit');
    Route::put('/vendor/{id}/edit', 'VendorController@update');

    //Get Price Values Routes
    Route::post('/get-price-values', 'AjaxController@getPriceValue');
    Route::post('/store-low-stock', 'AjaxController@storeLowStock');   
});

Route::group(['admin', 'roles' => ConstantHelper::ADMIN_ROLES, 'middleware' => 'apiresponse'], function () {
    // API Based Product Service Routes
    Route::get('api/product-service/{productServiceId}/attributes', 'Api\ProductServiceController@productServiceAttributes');
    Route::post('api/product-service/attribute', 'Api\ProductServiceController@addProductServiceAttribute');
    Route::get('api/product-service/attribute/{id}/delete', 'Api\ProductServiceController@deleteProductServiceAttribute');

    // API Based Config Service Option Routes
    Route::get('api/config-service/{configServiceId}/options', 'Api\ServiceOptionController@configServiceOptions');
    Route::post('api/config-service/option', 'Api\ServiceOptionController@addConfigServiceOption');
    Route::get('api/config-service/{configServiceId}/option/{id}/delete', 'Api\ServiceOptionController@deleteConfigServiceOption');

    // API Based Config Service Option Price Routes
    Route::get('api/config-service-option/{optionId}/pricing', 'Api\ServiceOptionController@serviceOptionPricing');
    Route::post('api/config-service-option/{optionId}/save-pricing', 'Api\ServiceOptionController@addConfigServiceOptionPrice');

    // API Based Support Ticket Routes
    Route::get('api/support-ticket/{ticketId}/comments', 'Api\SupportTicketController@supportTickets');
    Route::post('api/support-ticket/comment', 'Api\SupportTicketController@addsupportTicket');
    
    // API Based SEO Detail Routes
    Route::get('api/product-service/{productServiceId}/seo-details', 'Api\ProductServiceController@seoDetail');
    Route::post('api/product-service/seo-detail', 'Api\ProductServiceController@addSeoDetail');
});

