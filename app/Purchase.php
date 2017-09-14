<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;
DB::enableQueryLog();


class Purchase extends Model{


	public static function purchaseInvoiceData($gstin_id){
		$from_date = date('Y')."-04-01";
		$to_date = date('Y', strtotime('+1 years'))."-03-31";
		$purchaseInvoiceData = DB::table('purchase_invoice')
		->select('purchase_invoice.*')
		->where('purchase_invoice.gstin_id',$gstin_id)
		->where('purchase_invoice.status',1)
		->whereBetween('purchase_invoice.created_date', [$from_date, $to_date])
		->get();

		return $purchaseInvoiceData;
	}



	public static function getBusinessByGstin($gstin_id){

		$business = DB::table('gstin')
		->select('business_id')
		->where('gstin_id',$gstin_id)
		->where('status',1)
		->get();

		return $business;
	}



	public static function getPurchaseInvoiceCount($gstin_id){

		$business = DB::table('invoice_count')
		->where('gstin_id',$gstin_id)
		->where('invoice_type',4)
		->get();

		return $business;
	}



	public static function getGstinInfo($gstin_id){
		$getGstinInfo = DB::table('gstin')
		->where('gstin_id',$gstin_id)
		->get();

		return $getGstinInfo;
	}



	public static function getContact($business_id){

		$contact = DB::table('contact')
		->select('contact_id','contact_name')
		->where('business_id',$business_id)
		->where('status',1)
		->get();

		return $contact;
	}



	public static function getStates(){

		$states = DB::table('states')
		->get();
		return $states;
	}



	public static function getUnit(){

		$unit = DB::table('unit')
		->get();
		return $unit;
	}



	public static function getContactInfo($contact_id){

		$getContactInfo = DB::table('contact')
		->where('contact_id',$contact_id)
		->where('status',1)
		->get();

		return $getContactInfo;
	}



	public static function getItem($business_id){

		$item = DB::table('item')
		->select('item_id','item_description')
		->where('business_id',$business_id)
		->where('status',1)
		->get();

		return $item;
	}



	public static function getItemInfo($item_id){

		$getItemInfo = DB::table('item')
		->where('item_id',$item_id)
		->where('status',1)
		->get();

		return $getItemInfo;
	}



	public static function checkInvoiceNumber($gstin_id,$invoice_no){

		$checkInvoiceNumber = DB::table('purchase_invoice')
		->where('gstin_id',$gstin_id)
		->where('invoice_no',$invoice_no)
		->get();

		return $checkInvoiceNumber;
	}



	public static function insertPurchaseInvoice($purchaseInvoiceData){

		$purchaseInvoiceData['created_at'] = date('Y-m-d H:i:s');
		$purchaseInvoiceData['created_date'] = date('Y-m-d');
		$insertPurchaseInvoice = DB::table('purchase_invoice')
		->insertGetId($purchaseInvoiceData);

		return $insertPurchaseInvoice;
	}



	public static function insertInvoiceDetails($invoiceDetailData){
		
		$invoiceDetailData['created_at'] = date('Y-m-d H:i:s');
		$insertInvoiceDetails = DB::table('invoice_details')
		->insertGetId($invoiceDetailData);

		return $insertInvoiceDetails;
	}



	public static function getSIC($gstin_id){
		$getIC = DB::table('invoice_count')
		->where('invoice_type',4)
		->where('gstin_id',$gstin_id)
		->get();

		return $getIC;
	}



	public static function updateIC($data){
		$updateData = DB::table('invoice_count')
		->where('invoice_type',4)
		->where('gstin_id', $data['gstin_id'])
		->update($data);

		return  $updateData;
	}



	public static function addIC($input){
		$input['invoice_type'] = '4';
		$addIC = DB::table('invoice_count')
		->insert($input);

		return $addIC;
	}



	public static function cancelPurchaseInvoice($pi_id){

		$data['status'] = '0';
		$updateData = DB::table('purchase_invoice')
		->where('pi_id', $pi_id)
		->update($data);

		return  $updateData;
	}



	public static function getPurchaseInvoiceData($invoice_id){
		
		$getData = DB::table('purchase_invoice')
		->where('invoice_no',$invoice_id)
		->where('status',1)
		->get();

		return $getData;
	}



	public static function getInvoiceDetail($invoice_no){
		
		$getData = DB::table('invoice_details')
		->where('invoice_no',$invoice_no)
		->where('status',1)
		->get();

		return $getData;
	}



	public static function deleteInvoiceDetail($id_no){

		$data['status'] = '0';
		$updateData = DB::table('invoice_details')
		->where('id_no', $id_no)
		->update($data);

		return  $updateData;
	}



	public static function updatePurchaseInvoice($data,$pi_id){

		$updateData = DB::table('purchase_invoice')
		->where('pi_id', $pi_id)
		->update($data);

		return  $updateData;
	}



	public static function updateInvoiceDetails($data,$id_no){
		
		$updateData = DB::table('invoice_details')
		->where('id_no', $id_no)
		->update($data);

		return  $updateData;
	}



	public static function deleteInvoiceDetailBySiId($invoice_no){
		
		$data['status'] = '0';
		$updateData = DB::table('invoice_details')
		->where('invoice_no', $invoice_no)
		->update($data);

		return  $updateData;
	}



	public static function getVcdnoteInvoiceCount($gstin_id){

		$business = DB::table('invoice_count')
		->where('gstin_id',$gstin_id)
		->where('invoice_type',5)
		->get();

		return $business;
	}



	public static function getInvoice($gstin){

		$invoice = DB::table('purchase_invoice')
		->select('pi_id','invoice_no')
		->where('gstin_id',$gstin)
		->where('status',1)
		->get();

		return $invoice;
	}



	public static function getPurchaseInvoiceInfo($pi_id){

		$invoice = DB::table('purchase_invoice')
		->where('pi_id',$pi_id)
		->where('status',1)
		->get();

		return $invoice;
	}



	public static function checkCdnoteNumber($gstin_id,$note_no){

		$checkCdnoteNumber = DB::table('cd_note')
		->where('gstin_id',$gstin_id)
		->where('note_no',$note_no)
		->get();

		return $checkCdnoteNumber;
	}



	public static function getCDNC($gstin_id){
		$getCDNC = DB::table('invoice_count')
		->where('invoice_type',5)
		->where('gstin_id',$gstin_id)
		->get();

		return $getCDNC;
	}



	public static function updateCDNC($data){
		$updateData = DB::table('invoice_count')
		->where('invoice_type',5)
		->where('gstin_id', $data['gstin_id'])
		->update($data);

		return  $updateData;
	}



	public static function addCDNC($input){
		$input['invoice_type'] = '5';
		$addCDNC = DB::table('invoice_count')
		->insert($input);

		return $addCDNC;
	}



	public static function insertVcdnote($cdnData){

		$cdnData['created_at'] = date('Y-m-d H:i:s');
		$cdnData['created_date'] = date('Y-m-d');
		$insertCdnote = DB::table('vendor_cd_note')
		->insertGetId($cdnData);

		return $insertCdnote;
	}



	public static function creditDebitNoteData($gstin_id){
		$from_date = date('Y')."-04-01";
		$to_date = date('Y', strtotime('+1 years'))."-03-31";
		$creditDebitNoteData = DB::table('vendor_cd_note')
		->where('gstin_id',$gstin_id)
		->where('status',1)
		->whereBetween('created_date', [$from_date, $to_date])
		->get();

		return $creditDebitNoteData;
	}



	public static function cancelCdnote($cdn_id){

		$data['status'] = '0';
		$updateData = DB::table('vendor_cd_note')
		->where('vcdn_id', $cdn_id)
		->update($data);

		return  $updateData;
	}



	public static function getVcdnoteData($note_no){
		
		$getData = DB::table('vendor_cd_note')
		->where('note_no',$note_no)
		->where('status',1)
		->get();

		return $getData;
	}



	public static function updateVcdnote($data,$vcdn_id){

		$updateData = DB::table('vendor_cd_note')
		->where('vcdn_id', $vcdn_id)
		->update($data);

		return  $updateData;
	}



	public static function deleteNoteDetailByDcnId($invoice_no){
		
		$data['status'] = '0';
		$updateData = DB::table('invoice_details')
		->where('invoice_no', $invoice_no)
		->update($data);

		return  $updateData;
	}



	public static function getAdvancePaymentCount($gstin_id){

		$business = DB::table('invoice_count')
		->where('gstin_id',$gstin_id)
		->where('invoice_type',6)
		->get();

		return $business;
	}



	public static function getARC($gstin_id){
		$getARC = DB::table('invoice_count')
		->where('invoice_type',6)
		->where('gstin_id',$gstin_id)
		->get();

		return $getARC;
	}



	public static function updateARC($data){
		$updateData = DB::table('invoice_count')
		->where('invoice_type',6)
		->where('gstin_id', $data['gstin_id'])
		->update($data);

		return  $updateData;
	}



	public static function addARC($input){
		$input['invoice_type'] = '6';
		$addARC = DB::table('invoice_count')
		->insert($input);

		return $addARC;
	}



	public static function insertAdvancePayment($salesInvoiceData){

		$salesInvoiceData['created_at'] = date('Y-m-d H:i:s');
		$salesInvoiceData['created_date'] = date('Y-m-d');
		$insertAdvanceReceipt = DB::table('advance_payment')
		->insertGetId($salesInvoiceData);

		return $insertAdvanceReceipt;
	}



	public static function advanceReceiptData($gstin_id){
		$from_date = date('Y')."-04-01";
		$to_date = date('Y', strtotime('+1 years'))."-03-31";
		$advanceReceiptData = DB::table('advance_payment')
		->where('gstin_id',$gstin_id)
		->where('status',1)
		->whereBetween('created_date', [$from_date, $to_date])
		->get();

		return $advanceReceiptData;
	}



	public static function cancelAdvancePayment($ar_id){

		$data['status'] = '0';
		$updateData = DB::table('advance_payment')
		->where('ap_id', $ap_id)
		->update($data);

		return  $updateData;
	}



	public static function getAdvanceReceiptData($receipt_no){
		
		$getData = DB::table('advance_payment')
		->where('payment_no',$receipt_no)
		->where('status',1)
		->get();

		return $getData;
	}



	public static function updateAdvanceReceipt($data,$ap_id){

		$updateData = DB::table('advance_payment')
		->where('ap_id', $ap_id)
		->update($data);

		return  $updateData;
	}



	public static function deleteReceiptDetailByArId($invoice_no){
		
		$data['status'] = '0';
		$updateData = DB::table('invoice_details')
		->where('invoice_no', $invoice_no)
		->update($data);

		return  $updateData;
	}


}