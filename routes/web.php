<?php

use Illuminate\Support\Facades\Route;

Route::get('/complete-batch', 'App\Http\Controllers\HomeController@completeBatch')->name('completeBatch');
Route::get('/run-payment-cron', 'App\Http\Controllers\HomeController@runCron')->name('runCron');
Route::post('/save-contact-inquiry', 'App\Http\Controllers\HomeController@saveContactInquiry')->name('saveContactInquiry');
Route::post('/check-login-email', 'App\Http\Controllers\UserController@checkLoginEmail')->name('checkLoginEmail');
Route::post('/check-signup-email', 'App\Http\Controllers\UserController@checkSignupEmail')->name('checkSignupEmail');
Route::get('/workshop-reminder', 'App\Http\Controllers\HomeController@workshopReminder')->name('workshopReminder');
Route::get('/change-billing', 'App\Http\Controllers\HomeController@changeBilling')->name('changeBilling');
Route::get('/loop', 'App\Http\Controllers\HomeController@emailLoop')->name('emailLoop');
Route::get('/sns-notification', 'App\Http\Controllers\HomeController@snsNotification')->name('snsNotification');

Route::post('/bounces-production-notification', 'App\Http\Controllers\EmailController@bouncesProduction')->name('bouncesProduction');
Route::post('/complaints-production-notification', 'App\Http\Controllers\EmailController@complaintsProduction')->name('complaintsProduction');
Route::post('/deliveries-production-notification', 'App\Http\Controllers\EmailController@deliveriesProduction')->name('deliveriesProduction');

Route::post('/get-state-list', 'App\Http\Controllers\HomeController@getStateList')->name('getStateList');
Route::post('/get-city-list', 'App\Http\Controllers\HomeController@getCityList')->name('getCityList');

Route::get('/country-code', 'App\Http\Controllers\HomeController@countryCode')->name('countryCode');
Route::get('/invoice-issue', 'App\Http\Controllers\HomeController@solveInvoiceIssue')->name('solveInvoiceIssue');

// User Dashboard
Route::get('/home', 'App\Http\Controllers\UserController@index')->name('home');
Route::post('/save-workshop-batch-details', 'App\Http\Controllers\HomeController@saveBatchDetail')->name('saveBatchDetail'); 
Route::get('/remove-pending-invoice', 'App\Http\Controllers\HomeController@removePendingInvoice')->name('removePendingInvoice');


//Authentication
Route::group(['prefix' => 'auth'], function () {
    Route::post('/authentication', 'App\Http\Controllers\UserController@authentication')->name('authentication'); 
    Route::post('/verify-otp', 'App\Http\Controllers\UserController@verifyOtp')->name('verifyOtp'); 
    Route::post('/signup', 'App\Http\Controllers\UserController@signup')->name('signup'); 
    Route::post('/resend-otp', 'App\Http\Controllers\UserController@resendOtp')->name('resendOtp'); 
});

//User Panel Routes
Route::group(['prefix' => 'user'], function () {

    Route::get('/batches-list', 'App\Http\Controllers\UserController@batches')->name('batches'); 
    Route::get('/workshop-list', 'App\Http\Controllers\UserController@studentWorkshop')->name('studentWorkshop'); 
    Route::get('/self-learn', 'App\Http\Controllers\UserController@selfLearn')->name('selfLearn'); 
    Route::get('/update-payment/{id}', 'App\Http\Controllers\PaymentController@updateInvoice')->name('updateInvoice'); 
    Route::get('/notifications', 'App\Http\Controllers\UserController@notifications')->name('notifications'); 
    Route::get('/batch-workshop-registration/{uuid}', 'App\Http\Controllers\UserController@onlineBatchDetails')->name('onlineBatchDetails');  
    Route::get('/batch-details/{uuid}', 'App\Http\Controllers\UserController@batchDetails')->name('batchDetails');
    Route::get('/profile', 'App\Http\Controllers\UserController@profile')->name('profile');
    Route::post('/update-profile', 'App\Http\Controllers\UserController@updateProfile')->name('updateProfile'); 
    Route::post('/edit-note', 'App\Http\Controllers\UserController@editNote')->name('editNote');
    Route::post('/save-workshop-note', 'App\Http\Controllers\UserController@saveWorkshopNote')->name('saveWorkshopNote');
    Route::post('/delete-note', 'App\Http\Controllers\UserController@deleteNote')->name('deleteNote');
    Route::post('/edit-workshop-note', 'App\Http\Controllers\UserController@editWorkshopNote')->name('editWorkshopNote');
    Route::post('/enroll-batch', 'App\Http\Controllers\UserController@enrollForCourse')->name('enrollForCourse');
    Route::post('/leave-batch', 'App\Http\Controllers\UserController@leaveBatch')->name('leaveBatch');
    Route::post('/clear-notification', 'App\Http\Controllers\UserController@clearNotification')->name('clearNotification');
    Route::get('/payment', 'App\Http\Controllers\PaymentController@payment')->name('payment');
    Route::post('/invoice-filter', 'App\Http\Controllers\PaymentController@getInvoiceFilter')->name('getInvoiceFilter');
    
    Route::post('/remaining-invoice-payment', 'App\Http\Controllers\UserController@remainingInvoicePayment')->name('remainingInvoicePayment');
});

// User Logout
Route::get('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');

//Home page routes
Route::get('/', 'App\Http\Controllers\HomeController@index')->name('index');
Route::get('/about-us', 'App\Http\Controllers\HomeController@about')->name('about');
Route::get('/video', 'App\Http\Controllers\HomeController@video')->name('video');
Route::get('/contact-us', 'App\Http\Controllers\HomeController@contactUs')->name('contactUs');
Route::get('/batch-detail/{uuid}', 'App\Http\Controllers\HomeController@batchDetail')->name('batchDetail');
Route::get('/gallery', 'App\Http\Controllers\HomeController@gallery')->name('gallery');
Route::get('/work-space-details/{id}', 'App\Http\Controllers\HomeController@workSpaceDetails')->name('workSpaceDetails');
Route::post('/get-city', 'App\Http\Controllers\GlobalController@getCity')->name('getCity');
Route::post('/get-state', 'App\Http\Controllers\GlobalController@getState')->name('getState');
Route::post('/get-country', 'App\Http\Controllers\GlobalController@getCountry')->name('getCountry');

// Payment Routes
Route::post('/gateway/payment-success', 'App\Http\Controllers\PaymentController@paymentSuccess')->name('paymentSuccess');
//Return to getway
Route::post('/return-payment', 'App\Http\Controllers\PaymentController@gateway')->name('gateway');

//utilities route
Route::get('/terms-and-conditions', 'App\Http\Controllers\HomeController@termsAndConditions')->name('termsAndConditions');
Route::get('/privacy-policy', 'App\Http\Controllers\HomeController@privacyPolicy')->name('privacyPolicy');
Route::get('/refund-policy', 'App\Http\Controllers\HomeController@refundPolicy')->name('refundPolicy');
Route::get('/workshop-complete', 'App\Http\Controllers\HomeController@workshopComplete')->name('workshopComplete');

Route::get('/get-payment-status', 'App\Http\Controllers\PaymentController@getPaymentStatus')->name('getPaymentStatus');

