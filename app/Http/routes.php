<?php

use Illuminate\Support\Facades\Input;
use App\Gst;
use App\Invoice;

$api = app('Dingo\Api\Routing\Router');




/*
|--------------------------------------------------------------------------
| GST PAGES AND API'S
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
	return view('gst.index');
});

Route::get('/index', function () {
	return view('gst.index');
});

Route::get('/login', function () {
	return view('gst.login');
});

Route::get('/forgotpassword', function () {
	return view('gst.forgotpassword');
});

Route::get('/signup', function () {
	return view('gst.signup');
});

Route::get('/welcome', function () {
	return view('gst.welcome');
});

Route::get('/importcontact', function () {
	return view('gst.importcontact');
});

Route::get('/importitem', function () {
	return view('gst.importitem');
});

Route::get('business', [
	'as' => 'gst.business', 'uses' => 'Api\V1\GstController@business'
	]);

Route::get('setting', [
	'as' => 'gst.setting', 'uses' => 'Api\V1\GstController@setting'
	]);

Route::get('gstn/{id}', [
	'as' => 'gstn/{id}', 'uses' => 'Api\V1\GstController@getBusinessGstin'
	]);

Route::get('/addCustomer', function () {
	return view('gst.addCustomer');
});

Route::get('/addservices', function () {
	return view('gst.addservices');
});

Route::post('importContactFile', [
	'as' => 'gst.importContactFile', 'uses' => 'Api\V1\GstController@importContactFile'
	]);

Route::post('importItemFile', [
	'as' => 'gst.importItemFile', 'uses' => 'Api\V1\GstController@importItemFile'
	]);

Route::post ( '/items', function () {
	$business_id = Input::get ('business_id');
	$data = Gst::items($business_id);
	return view('gst.items',['data'=>$data]);
} );

Route::get('editItem/{id}', [
	'as' => 'editItem/{id}', 'uses' => 'Api\V1\GstController@editItem'
	]);

Route::get('contacts/{id}', [
	'as' => 'gst.contacts/{id}', 'uses' => 'Api\V1\GstController@contacts'
	]);

Route::get('editCustomer/{id}', [
	'as' => 'editCustomer/{id}', 'uses' => 'Api\V1\GstController@editContact'
	]);

Route::get('customerInfo/{id}', [
	'as' => 'customerInfo/{id}', 'uses' => 'Api\V1\GstController@customerInfo'
	]);

Route::get('resetPassword/{id}/{forget_password_id}', [
	'as' => 'resetPassword/{id}/{forget_password_id}', 'uses' => 'Api\V1\GstController@resetPassword'
	]);

Route::get('verifyMail/{id}', [
	'as' => 'verifyMail/{id}', 'uses' => 'Api\V1\GstController@verifyMail'
	]);

Route::get('select/{id}', [
	'as' => 'select/{id}', 'uses' => 'Api\V1\GstController@select'
	]);

Route::get('/importError', function () {
	return view('gst.importError');
});



$api->version('v1', function ($api) {
	$api->post('signup', 'App\Http\Controllers\Api\V1\GstController@signup');
});

$api->version('v1', function ($api) {
	$api->post('viewUsers', 'App\Http\Controllers\Api\V1\GstController@viewUsers');
});

$api->version('v1', function ($api) {
	$api->post('updateUser/{id}', 'App\Http\Controllers\Api\V1\GstController@updateUser');
});

$api->version('v1', function ($api) {
	$api->post('login', 'App\Http\Controllers\Api\V1\GstController@login');
});

$api->version('v1', function ($api) {
	$api->post('forgotpassword', 'App\Http\Controllers\Api\V1\GstController@forgotpassword');
});

$api->version('v1', function ($api) {
	$api->post('updatepassword/{id}', 'App\Http\Controllers\Api\V1\GstController@updatepassword');
});

$api->version('v1', function ($api) {
	$api->post('logout', 'App\Http\Controllers\Api\V1\GstController@logout');
});

$api->version('v1', function ($api) {
	$api->post('addBusiness', 'App\Http\Controllers\Api\V1\GstController@addBusiness');
});

$api->version('v1', function ($api) {
	$api->get('getBusinessData/{id}', 'App\Http\Controllers\Api\V1\GstController@getBusinessData');
});

$api->version('v1', function ($api) {
	$api->post('updateBusiness/{id}', 'App\Http\Controllers\Api\V1\GstController@updateBusiness');
});

$api->version('v1', function ($api) {
	$api->post('deleteBusiness/{id}', 'App\Http\Controllers\Api\V1\GstController@deleteBusiness');
});

$api->version('v1', function ($api) {
	$api->get('getBusinessGstin/{id}', 'App\Http\Controllers\Api\V1\GstController@getBusinessGstin');
});

$api->version('v1', function ($api) {
	$api->post('addGstin', 'App\Http\Controllers\Api\V1\GstController@addGstin');
});

$api->version('v1', function ($api) {
	$api->get('getGstinData/{id}', 'App\Http\Controllers\Api\V1\GstController@getGstinData');
});

$api->version('v1', function ($api) {
	$api->post('updateGstin/{id}', 'App\Http\Controllers\Api\V1\GstController@updateGstin');
});

$api->version('v1', function ($api) {
	$api->post('deleteGstin/{id}', 'App\Http\Controllers\Api\V1\GstController@deleteGstin');
});

$api->version('v1', function ($api) {
	$api->post('getBusiness', 'App\Http\Controllers\Api\V1\GstController@getBusiness');
});

$api->version('v1', function ($api) {
	$api->post('addCustomer', 'App\Http\Controllers\Api\V1\GstController@addCustomer');
});

$api->version('v1', function ($api) {
	$api->post('deleteContact/{id}', 'App\Http\Controllers\Api\V1\GstController@deleteContact');
});

$api->version('v1', function ($api) {
	$api->post('requestInfo/{id}', 'App\Http\Controllers\Api\V1\GstController@requestInfo');
});

$api->version('v1', function ($api) {
	$api->post('updateContact/{id}', 'App\Http\Controllers\Api\V1\GstController@updateContact');
});

$api->version('v1', function ($api) {
	$api->post('addItem', 'App\Http\Controllers\Api\V1\GstController@addItem');
});

$api->version('v1', function ($api) {
	$api->post('deleteItem/{id}', 'App\Http\Controllers\Api\V1\GstController@deleteItem');
});

$api->version('v1', function ($api) {
	$api->post('updateItem/{id}', 'App\Http\Controllers\Api\V1\GstController@updateItem');
});






/*
|--------------------------------------------------------------------------
| SALES PAGES AND API'S
|--------------------------------------------------------------------------
*/


Route::get('sales/{id}', [
	'as' => 'sales/{id}', 'uses' => 'Api\V1\SalesController@sales'
	]);

Route::get('selectSalesInvoice/{id}', [
	'as' => 'selectSalesInvoice/{id}', 'uses' => 'Api\V1\SalesController@selectSalesInvoice'
	]);

Route::get('goodsSalesInvoice/{id}', [
	'as' => 'goodsSalesInvoice/{id}', 'uses' => 'Api\V1\SalesController@goodsSalesInvoice'
	]);

Route::get('sales/editSalesInvoice/{id}', [
	'as' => 'sales/editSalesInvoice/{id}', 'uses' => 'Api\V1\SalesController@editSalesInvoice'
	]);

Route::get('cdnote/{id}', [
	'as' => 'cdnote/{id}', 'uses' => 'Api\V1\SalesController@cdnote'
	]);

$api->version('v1', function ($api) {
	$api->get('getContact/{business_id}', 'App\Http\Controllers\Api\V1\SalesController@getContact');
});

$api->version('v1', function ($api) {
	$api->get('getStates', 'App\Http\Controllers\Api\V1\SalesController@getStates');
});

$api->version('v1', function ($api) {
	$api->get('getContactInfo/{contact_id}', 'App\Http\Controllers\Api\V1\SalesController@getContactInfo');
});

$api->version('v1', function ($api) {
	$api->get('getItem/{business_id}', 'App\Http\Controllers\Api\V1\SalesController@getItem');
});

$api->version('v1', function ($api) {
	$api->get('getItemInfo/{item_id}', 'App\Http\Controllers\Api\V1\SalesController@getItemInfo');
});

$api->version('v1', function ($api) {
	$api->post('saveSalesInvoice', 'App\Http\Controllers\Api\V1\SalesController@saveSalesInvoice');
});

$api->version('v1', function ($api) {
	$api->post('cancelInvoice/{id}', 'App\Http\Controllers\Api\V1\SalesController@cancelInvoice');
});

$api->version('v1', function ($api) {
	$api->post('deleteInvoiceDetail/{id}', 'App\Http\Controllers\Api\V1\SalesController@deleteInvoiceDetail');
});

$api->version('v1', function ($api) {
	$api->post('updateSalesInvoice/{si_id}', 'App\Http\Controllers\Api\V1\SalesController@updateSalesInvoice');
});












/*
|--------------------------------------------------------------------------
| PURCHASE PAGES AND API'S
|--------------------------------------------------------------------------
*/






/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
