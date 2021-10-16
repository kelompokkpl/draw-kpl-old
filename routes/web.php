<?php
use crocodicstudio\crudbooster\controllers\AdminController as AdminController;

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

// Admin & Superadmin
Route::prefix('admin')->group(function () {
	// Preference (Event Module)
	Route::get('event/preferences/{id}', 'AdminEventController@preferences')->name('preferences');
	Route::post('event/save-preferences/{id}', 'AdminEventController@savePreferences')->name('save-preferences');

	// Disabled Category Module
	Route::get('category_disabled/add_selected_participant', 'AdminCategoryDisabledController@addSelectedParticipant');
	Route::get('category_by_event/{event}', 'AdminCategoryDisabledController@getCategory');
	Route::get('participant_by_event_category/{event}/{category}', 'AdminCategoryDisabledController@getParticipant');
	Route::post('category_disabled/save_disabled_category', 'AdminCategoryDisabledController@saveDisabledCategory');

	// Winner Module
	Route::get('winner_by_event_category/{event}/{category}', 'AdminWinnerController@getParticipant');
	Route::post('winner/save_winner', 'AdminWinnerController@saveWinner');

	// Payment Module
	Route::get('payment/invoice/{id}', 'AdminPaymentController@printInvoice');
	Route::post('payment/save_payment', 'AdminPaymentController@savePayment');
	Route::post('payment/update_payment/{id}', 'AdminPaymentController@savePayment')->name('savePayment');
});


// Event Organizer
Route::get('', 'EOController@getLogin')->name('getLoginEO');
Route::group(['middleware' => ['eo-auth', 'eo-log'], 'prefix' => 'eo'], function () {
	Route::get('/', 'EOController@getIndex')->name('indexEO');
	Route::get('profile', 'EOController@getProfile')->name('getEOProfile');
	Route::post('profile', 'EOController@updateProfile')->name('updateProfile');
	Route::get('event_delete/{id}', 'EOEventController@destroy');
	Route::get('lockscreen', 'EOController@getLockscreen')->name('getEOLockScreen');

	// Report Module
	Route::get('detail_event/{event}', 'EOReportController@getDetail');
	Route::get('report', 'EOReportController@getIndex')->name('getEOReport');
	Route::post('report', 'EOReportController@printReport')->name('print_report');

	Route::get('dashboard_event/category_delete/{id}', 'EOCategoryController@destroy');
	Route::get('dashboard_event/participant_delete/{id}', 'EOParticipantController@destroy');
	Route::get('dashboard_event/preferences', 'EOEventController@getPreferences');

	// Draw
	Route::get('dashboard_event/draw', 'DrawController@getIndex');
	Route::get('dashboard_event/recent', 'DrawController@getRecent');
	Route::get('dashboard_event/drawing', 'DrawController@getDraw');
	Route::get('dashboard_event/winner', 'DrawController@getWinner');
	Route::get('dashboard_event/winners/{id}', 'DrawController@getWinnerByCategory');
	Route::get('dashboard_event/history', 'DrawController@getHistory');
	Route::get('dashboard_event/new', 'DrawController@getNew');

	Route::get('dashboard_event/print_invoice/{id}', 'PaymentController@printInvoice')->name('printInvoice');
	Route::get('payment/cancel/{id}', 'PaymentController@cancelTransaction');

	// Category Disabled Module// Disabled Category Module
	Route::get('dashboard_event/category_disabled', 'EOCategoryDisabledController@index');
	Route::get('dashboard_event/add_selected_participant', 'EOCategoryDisabledController@addSelectedParticipant');
	Route::get('category_by_event/{event}', 'EOCategoryDisabledController@getCategory');
	Route::get('participant_by_category/{category}', 'EOCategoryDisabledController@getParticipant');
	Route::post('category_disabled/save_disabled_category', 'EOCategoryDisabledController@saveDisabledCategory')->name('save_disabled_category');
	Route::get('enable_participant/{id}', 'EOCategoryDisabledController@enableParticipant')->name('enable_participant');

	// Participant Module
	Route::get('dashboard_event/participant/import', 'EOParticipantController@getImportView');
	Route::post('dashboard_event/participant/import', 'EOParticipantController@import')->name('importParticipant');

	// Mail to Winner
	Route::get('dashboard_event/mails', 'EOMailsController@index');
	Route::get('dashboard_event/mails/create', 'EOMailsController@create');
	Route::post('dashboard_event/mails/create', 'EOMailsController@store');
	Route::get('dashboard_event/mails/{id}', 'EOMailsController@show')->name('mails.show');

	// Resources
	Route::resources([
	    'event' => 'EOEventController',
	    'dashboard_event/category' => 'EOCategoryController',
	    'dashboard_event/participant' => 'EOParticipantController',
	    'payment' => 'PaymentController'
	]);


	Route::group(['prefix' => 'dashboard_event'], function () {
		Route::get('/{id}', 'EOEventController@dashboard');
	});
});

// Demo
Route::get('demo', 'DemoController@getIndex');
Route::get('recent', 'DemoController@getRecent');
Route::get('drawing', 'DemoController@getDraw');
Route::get('winner', 'DemoController@getWinner');
Route::get('winners', 'DemoController@getWinners');
Route::get('winners/{id}', 'DemoController@getWinnerByCategory');
Route::get('history', 'DemoController@getHistory');
Route::get('new', 'DemoController@getNew');