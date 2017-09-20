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

Route::get('itemList/{business_id}', [
	'as' => 'itemList/{business_id}', 'uses' => 'Api\V1\GstController@itemList'
	]);

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

Route::get('sales/editSalesInvoice/{id}/{gstin_id}', [
	'as' => 'sales/editSalesInvoice/{id}/{gstin_id}', 'uses' => 'Api\V1\SalesController@editSalesInvoice'
	]);

Route::get('sales/viewSalesInvoice/{id}/{gstin_id}', [
	'as' => 'sales/viewSalesInvoice/{id}/{gstin_id}', 'uses' => 'Api\V1\SalesController@viewSalesInvoice'
	]);

Route::get('printSalesInvoice/{id}/{gstin_id}',array('as'=>'printSalesInvoice','uses'=>'Api\V1\SalesController@printSalesInvoice'));

Route::get('servicesSalesInvoice/{id}', [
	'as' => 'servicesSalesInvoice/{id}', 'uses' => 'Api\V1\SalesController@servicesSalesInvoice'
	]);

Route::get('sales/editServicesSalesInvoice/{id}/{gstin_id}', [
	'as' => 'sales/editServicesSalesInvoice/{id}/{gstin_id}', 'uses' => 'Api\V1\SalesController@editServicesSalesInvoice'
	]);

Route::get('sales/viewServicesSalesInvoice/{id}/{gstin_id}', [
	'as' => 'sales/viewServicesSalesInvoice/{id}/{gstin_id}', 'uses' => 'Api\V1\SalesController@viewServicesSalesInvoice'
	]);

Route::get('printServicesSalesInvoice/{id}/{gstin_id}',array('as'=>'printServicesSalesInvoice','uses'=>'Api\V1\SalesController@printServicesSalesInvoice'));

Route::get('uploadSalesInvoice/{id}', [
	'as' => 'uploadSalesInvoice/{id}', 'uses' => 'Api\V1\SalesController@uploadSalesInvoice'
	]);

Route::get('createCdnote/{id}', [
	'as' => 'createCdnote/{id}', 'uses' => 'Api\V1\SalesController@createCdnote'
	]);

Route::get('cdnote/{id}', [
	'as' => 'cdnote/{id}', 'uses' => 'Api\V1\SalesController@cdnote'
	]);

Route::get('cdnote/editCdnote/{id}/{gstin_id}', [
	'as' => 'cdnote/editCdnote/{id}/{gstin_id}', 'uses' => 'Api\V1\SalesController@editCdnote'
	]);

Route::get('cdnote/viewCdnote/{id}/{gstin_id}', [
	'as' => 'cdnote/viewCdnote/{id}/{gstin_id}', 'uses' => 'Api\V1\SalesController@viewCdnote'
	]);

Route::get('printCdnote/{id}/{gstin_id}',array('as'=>'printCdnote','uses'=>'Api\V1\SalesController@printCdnote'));

Route::get('createAdvanceReceipt/{id}', [
	'as' => 'createAdvanceReceipt/{id}', 'uses' => 'Api\V1\SalesController@createAdvanceReceipt'
	]);

Route::get('advanceReceipt/{id}', [
	'as' => 'advanceReceipt/{id}', 'uses' => 'Api\V1\SalesController@advanceReceipt'
	]);

Route::get('advanceReceipt/editAdvanceReceipt/{id}/{gstin_id}', [
	'as' => 'advanceReceipt/editAdvanceReceipt/{id}/{gstin_id}', 'uses' => 'Api\V1\SalesController@editAdvanceReceipt'
	]);

Route::get('advanceReceipt/viewAdvanceReceipt/{id}/{gstin_id}', [
	'as' => 'advanceReceipt/viewAdvanceReceipt/{id}/{gstin_id}', 'uses' => 'Api\V1\SalesController@viewAdvanceReceipt'
	]);

Route::get('printAdvanceReceipt/{id}/{gstin_id}',array('as'=>'printAdvanceReceipt','uses'=>'Api\V1\SalesController@printAdvanceReceipt'));

$api->version('v1', function ($api) {
	$api->get('getContact/{business_id}', 'App\Http\Controllers\Api\V1\SalesController@getContact');
});

$api->version('v1', function ($api) {
	$api->get('getStates', 'App\Http\Controllers\Api\V1\SalesController@getStates');
});

$api->version('v1', function ($api) {
	$api->get('getUnit', 'App\Http\Controllers\Api\V1\SalesController@getUnit');
});

$api->version('v1', function ($api) {
	$api->get('getContactInfo/{contact_id}', 'App\Http\Controllers\Api\V1\SalesController@getContactInfo');
});

$api->version('v1', function ($api) {
	$api->post('addItemInvoice', 'App\Http\Controllers\Api\V1\SalesController@addItemInvoice');
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
	$api->post('saveServicesSalesInvoice', 'App\Http\Controllers\Api\V1\SalesController@saveServicesSalesInvoice');
});

$api->version('v1', function ($api) {
	$api->post('cancelInvoice/{id}/{gstin_id}', 'App\Http\Controllers\Api\V1\SalesController@cancelInvoice');
});

$api->version('v1', function ($api) {
	$api->post('deleteInvoiceDetail/{id}', 'App\Http\Controllers\Api\V1\SalesController@deleteInvoiceDetail');
});

$api->version('v1', function ($api) {
	$api->post('updateSalesInvoice/{si_id}', 'App\Http\Controllers\Api\V1\SalesController@updateSalesInvoice');
});

$api->version('v1', function ($api) {
	$api->post('updateServicesSalesInvoice/{si_id}', 'App\Http\Controllers\Api\V1\SalesController@updateServicesSalesInvoice');
});

$api->version('v1', function ($api) {
	$api->get('getSalesInvoice/{gstin}', 'App\Http\Controllers\Api\V1\SalesController@getInvoice');
});

$api->version('v1', function ($api) {
	$api->get('getInvoiceInfo/{si_id}', 'App\Http\Controllers\Api\V1\SalesController@getInvoiceInfo');
});

$api->version('v1', function ($api) {
	$api->post('saveCdnote', 'App\Http\Controllers\Api\V1\SalesController@saveCdnote');
});

$api->version('v1', function ($api) {
	$api->post('cancelCdnote/{id}/{gstin_id}', 'App\Http\Controllers\Api\V1\SalesController@cancelCdnote');
});

$api->version('v1', function ($api) {
	$api->post('updateCdnote/{cdn_id}', 'App\Http\Controllers\Api\V1\SalesController@updateCdnote');
});

$api->version('v1', function ($api) {
	$api->post('saveAdvanceReceipt', 'App\Http\Controllers\Api\V1\SalesController@saveAdvanceReceipt');
});

$api->version('v1', function ($api) {
	$api->post('cancelAdvanceReceipt/{id}/{gstin_id}', 'App\Http\Controllers\Api\V1\SalesController@cancelAdvanceReceipt');
});

$api->version('v1', function ($api) {
	$api->post('updateAdvanceReceipt/{ar_id}', 'App\Http\Controllers\Api\V1\SalesController@updateAdvanceReceipt');
});







/*
|--------------------------------------------------------------------------
| PURCHASE PAGES AND API'S
|--------------------------------------------------------------------------
*/


Route::get('purchase/{id}', [
	'as' => 'purchase/{id}', 'uses' => 'Api\V1\PurchaseController@purchase'
	]);

Route::get('selectPurchaseInvoice/{id}', [
	'as' => 'selectPurchaseInvoice/{id}', 'uses' => 'Api\V1\PurchaseController@selectPurchaseInvoice'
	]);

Route::get('goodsPurchaseInvoice/{id}', [
	'as' => 'goodsPurchaseInvoice/{id}', 'uses' => 'Api\V1\PurchaseController@goodsPurchaseInvoice'
	]);

Route::get('purchase/editPurchaseInvoice/{id}', [
	'as' => 'purchase/editPurchaseInvoice/{id}', 'uses' => 'Api\V1\PurchaseController@editPurchaseInvoice'
	]);

Route::get('purchase/viewPurchaseInvoice/{id}', [
	'as' => 'purchase/viewPurchaseInvoice/{id}', 'uses' => 'Api\V1\PurchaseController@viewPurchaseInvoice'
	]);

Route::get('printPurchaseInvoice/{id}',array('as'=>'printPurchaseInvoice','uses'=>'Api\V1\PurchaseController@printPurchaseInvoice'));

Route::get('createVcdnote/{id}', [
	'as' => 'createVcdnote/{id}', 'uses' => 'Api\V1\PurchaseController@createVcdnote'
	]);

Route::get('vcdnote/{id}', [
	'as' => 'vcdnote/{id}', 'uses' => 'Api\V1\PurchaseController@vcdnote'
	]);

Route::get('vcdnote/editVcdnote/{id}', [
	'as' => 'vcdnote/editVcdnote/{id}', 'uses' => 'Api\V1\PurchaseController@editVcdnote'
	]);

Route::get('vcdnote/viewVcdnote/{id}', [
	'as' => 'vcdnote/viewVcdnote/{id}', 'uses' => 'Api\V1\PurchaseController@viewVcdnote'
	]);

Route::get('printVcdnote/{id}',array('as'=>'printVcdnote','uses'=>'Api\V1\PurchaseController@printVcdnote'));

Route::get('createAdvancePayment/{id}', [
	'as' => 'createAdvancePayment/{id}', 'uses' => 'Api\V1\PurchaseController@createAdvancePayment'
	]);

Route::get('advancePayment/{id}', [
	'as' => 'advancePayment/{id}', 'uses' => 'Api\V1\PurchaseController@advancePayment'
	]);

Route::get('advancePayment/editAdvancePayment/{id}', [
	'as' => 'advancePayment/editAdvancePayment/{id}', 'uses' => 'Api\V1\PurchaseController@editAdvancePayment'
	]);

Route::get('advancePayment/viewAdvancePayment/{id}', [
	'as' => 'advancePayment/viewAdvancePayment/{id}', 'uses' => 'Api\V1\PurchaseController@viewAdvancePayment'
	]);

Route::get('printAdvancePayment/{id}',array('as'=>'printAdvancePayment','uses'=>'Api\V1\PurchaseController@printAdvancePayment'));


$api->version('v1', function ($api) {
	$api->get('getContact/{business_id}', 'App\Http\Controllers\Api\V1\PurchaseController@getContact');
});

$api->version('v1', function ($api) {
	$api->get('getStates', 'App\Http\Controllers\Api\V1\PurchaseController@getStates');
});

$api->version('v1', function ($api) {
	$api->get('getContactInfo/{contact_id}', 'App\Http\Controllers\Api\V1\PurchaseController@getContactInfo');
});

$api->version('v1', function ($api) {
	$api->get('getItem/{business_id}', 'App\Http\Controllers\Api\V1\PurchaseController@getItem');
});

$api->version('v1', function ($api) {
	$api->get('getItemInfo/{item_id}', 'App\Http\Controllers\Api\V1\PurchaseController@getItemInfo');
});

$api->version('v1', function ($api) {
	$api->post('savePurchaseInvoice', 'App\Http\Controllers\Api\V1\PurchaseController@savePurchaseInvoice');
});

$api->version('v1', function ($api) {
	$api->post('cancelPurchaseInvoice/{id}', 'App\Http\Controllers\Api\V1\PurchaseController@cancelPurchaseInvoice');
});

$api->version('v1', function ($api) {
	$api->post('deleteInvoiceDetail/{id}', 'App\Http\Controllers\Api\V1\PurchaseController@deleteInvoiceDetail');
});

$api->version('v1', function ($api) {
	$api->post('updatePurchaseInvoice/{pi_id}', 'App\Http\Controllers\Api\V1\PurchaseController@updatePurchaseInvoice');
});

$api->version('v1', function ($api) {
	$api->get('getInvoice/{gstin}', 'App\Http\Controllers\Api\V1\PurchaseController@getInvoice');
});

$api->version('v1', function ($api) {
	$api->get('getPurchaseInvoiceInfo/{pi_id}', 'App\Http\Controllers\Api\V1\PurchaseController@getPurchaseInvoiceInfo');
});

$api->version('v1', function ($api) {
	$api->post('saveVcdnote', 'App\Http\Controllers\Api\V1\PurchaseController@saveVcdnote');
});

$api->version('v1', function ($api) {
	$api->post('cancelVcdnote/{id}', 'App\Http\Controllers\Api\V1\PurchaseController@cancelVcdnote');
});

$api->version('v1', function ($api) {
	$api->post('updateVcdnote/{vcdn_id}', 'App\Http\Controllers\Api\V1\PurchaseController@updateVcdnote');
});

$api->version('v1', function ($api) {
	$api->post('saveAdvancePayment', 'App\Http\Controllers\Api\V1\PurchaseController@saveAdvancePayment');
});

$api->version('v1', function ($api) {
	$api->post('cancelAdvancePayment/{id}', 'App\Http\Controllers\Api\V1\PurchaseController@cancelAdvancePayment');
});

$api->version('v1', function ($api) {
	$api->post('updateAdvancePayment/{ap_id}', 'App\Http\Controllers\Api\V1\PurchaseController@updateAdvancePayment');
});