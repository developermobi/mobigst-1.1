<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;
DB::enableQueryLog();


class Sales extends Model{


	public static function salesInvoiceData($gstin_id){
		$from_date = date('Y')."-04-01";
		$to_date = date('Y', strtotime('+1 years'))."-03-31";
		$salesInvoiceData = DB::table('sales_invoice')
		->select('sales_invoice.*')
		->where('sales_invoice.gstin_id',$gstin_id)
		->where('sales_invoice.status',1)
		->whereBetween('sales_invoice.created_date', [$from_date, $to_date])
		->orderBy('si_id', 'desc')
		->get();

		return $salesInvoiceData;
	}



	public static function getBusinessByGstin($gstin_id){

		$business = DB::table('gstin')
		->select('business_id')
		->where('gstin_id',$gstin_id)
		->where('status',1)
		->get();

		return $business;
	}



	public static function getSalesInvoiceCount($gstin_id){

		$business = DB::table('invoice_count')
		->where('gstin_id',$gstin_id)
		->where('invoice_type',1)
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
		->select('contact_id','contact_name','city')
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



	public static function addItem($input){
		$input['created_at'] = date('Y-m-d H:i:s');
		//$input['discount_price'] = $input['item_sale_price'] - $input['item_discount'];
		$addItem = DB::table('item')
		->insertGetId($input);

		return $addItem;
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

		$checkInvoiceNumber = DB::table('sales_invoice')
		->where('gstin_id',$gstin_id)
		->where('invoice_no',$invoice_no)
		->get();

		return $checkInvoiceNumber;
	}



	public static function insertSalesInvoice($salesInvoiceData){

		$salesInvoiceData['created_at'] = date('Y-m-d H:i:s');
		$salesInvoiceData['created_date'] = date('Y-m-d');
		$insertSalesInvoice = DB::table('sales_invoice')
		->insertGetId($salesInvoiceData);

		return $insertSalesInvoice;
	}



	public static function insertInvoiceDetails($invoiceDetailData){
		
		$invoiceDetailData['created_at'] = date('Y-m-d H:i:s');
		$insertInvoiceDetails = DB::table('invoice_details')
		->insertGetId($invoiceDetailData);

		return $insertInvoiceDetails;
	}



	public static function getSIC($gstin_id){
		$getIC = DB::table('invoice_count')
		->where('invoice_type',1)
		->where('gstin_id',$gstin_id)
		->get();

		return $getIC;
	}



	public static function updateIC($data){
		$updateData = DB::table('invoice_count')
		->where('invoice_type',1)
		->where('gstin_id', $data['gstin_id'])
		->update($data);

		return  $updateData;
	}



	public static function addIC($input){
		$input['invoice_type'] = '1';
		$addIC = DB::table('invoice_count')
		->insert($input);

		return $addIC;
	}



	public static function cancelInvoice($id,$gstin_id){

		$updateData = DB::table('sales_invoice')
		->where('invoice_no', $id)
		->where('gstin_id', $gstin_id)
		->delete();

		$deleteData = DB::table('invoice_details')
		->where('invoice_no', $id)
		->where('gstin_id', $gstin_id)
		->delete();

		return  $deleteData;
	}



	public static function getSalesInvoiceData($invoice_id,$gstin_id){
		
		$getData = DB::table('sales_invoice')
		->where('invoice_no',$invoice_id)
		->where('gstin_id',$gstin_id)
		->where('status',1)
		->get();

		return $getData;
	}



	public static function getInvoiceDetail($invoice_no,$gstin_id){
		
		$getData = DB::table('invoice_details')
		->where('invoice_no',$invoice_no)
		->where('gstin_id',$gstin_id)
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



	public static function updateSalesInvoice($data,$si_id){

		$updateData = DB::table('sales_invoice')
		->where('si_id', $si_id)
		->update($data);

		return  $updateData;
	}



	public static function updateInvoiceDetails($data,$id_no){
		
		$updateData = DB::table('invoice_details')
		->where('id_no', $id_no)
		->update($data);

		return  $updateData;
	}



	public static function deleteInvoiceDetailBySiId($invoice_no,$gstin_id){
		
		$data['status'] = '0';
		$updateData = DB::table('invoice_details')
		->where('gstin_id', $gstin_id)
		->where('invoice_no', $invoice_no)
		->update($data);

		return  $updateData;
	}



	public static function getCdnoteInvoiceCount($gstin_id){

		$business = DB::table('invoice_count')
		->where('gstin_id',$gstin_id)
		->where('invoice_type',2)
		->get();

		return $business;
	}



	public static function getInvoice($gstin){

		$invoice = DB::table('sales_invoice')
		->select('si_id','invoice_no')
		->where('gstin_id',$gstin)
		->where('status',1)
		->get();

		return $invoice;
	}



	public static function getInvoiceInfo($si_id){

		$invoice = DB::table('sales_invoice')
		->where('si_id',$si_id)
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
		->where('invoice_type',2)
		->where('gstin_id',$gstin_id)
		->get();

		return $getCDNC;
	}



	public static function updateCDNC($data){
		$updateData = DB::table('invoice_count')
		->where('invoice_type',2)
		->where('gstin_id', $data['gstin_id'])
		->update($data);

		return  $updateData;
	}



	public static function addCDNC($input){
		$input['invoice_type'] = '2';
		$addCDNC = DB::table('invoice_count')
		->insert($input);

		return $addCDNC;
	}



	public static function insertCdnote($cdnData){

		$cdnData['created_at'] = date('Y-m-d H:i:s');
		$cdnData['created_date'] = date('Y-m-d');
		$insertCdnote = DB::table('cd_note')
		->insertGetId($cdnData);

		return $insertCdnote;
	}



	public static function creditDebitNoteData($gstin_id){
		$from_date = date('Y')."-04-01";
		$to_date = date('Y', strtotime('+1 years'))."-03-31";
		$creditDebitNoteData = DB::table('cd_note')
		->where('gstin_id',$gstin_id)
		->where('status',1)
		->whereBetween('created_date', [$from_date, $to_date])
		->orderBy('cdn_id', 'desc')
		->get();

		return $creditDebitNoteData;
	}



	public static function cancelCdnote($id,$gstin_id){

		$updateData = DB::table('cd_note')
		->where('note_no', $id)
		->where('gstin_id', $gstin_id)
		->delete();

		$deleteData = DB::table('invoice_details')
		->where('invoice_no', $id)
		->where('gstin_id', $gstin_id)
		->delete();

		return  $deleteData;
	}



	public static function getCdnoteData($note_no,$gstin_id){
		
		$getData = DB::table('cd_note')
		->where('note_no',$note_no)
		->where('gstin_id',$gstin_id)
		->where('status',1)
		->get();

		return $getData;
	}



	public static function updateCdnote($data,$cdn_id){

		$updateData = DB::table('cd_note')
		->where('cdn_id', $cdn_id)
		->update($data);

		return  $updateData;
	}



	public static function deleteNoteDetailByDcnId($invoice_no,$gstin_id){
		
		$data['status'] = '0';
		$updateData = DB::table('invoice_details')
		->where('gstin_id', $gstin_id)
		->where('invoice_no', $invoice_no)
		->update($data);

		return  $updateData;
	}



	public static function getAdvanceReceiptCount($gstin_id){

		$business = DB::table('invoice_count')
		->where('gstin_id',$gstin_id)
		->where('invoice_type',3)
		->get();

		return $business;
	}



	public static function getARC($gstin_id){
		$getARC = DB::table('invoice_count')
		->where('invoice_type',3)
		->where('gstin_id',$gstin_id)
		->get();

		return $getARC;
	}



	public static function updateARC($data){
		$updateData = DB::table('invoice_count')
		->where('invoice_type',3)
		->where('gstin_id', $data['gstin_id'])
		->update($data);

		return  $updateData;
	}



	public static function addARC($input){
		$input['invoice_type'] = '3';
		$addARC = DB::table('invoice_count')
		->insert($input);

		return $addARC;
	}



	public static function insertAdvanceReceipt($salesInvoiceData){

		$salesInvoiceData['created_at'] = date('Y-m-d H:i:s');
		$salesInvoiceData['created_date'] = date('Y-m-d');
		$insertAdvanceReceipt = DB::table('advance_receipt')
		->insertGetId($salesInvoiceData);

		return $insertAdvanceReceipt;
	}



	public static function advanceReceiptData($gstin_id){
		$from_date = date('Y')."-04-01";
		$to_date = date('Y', strtotime('+1 years'))."-03-31";
		$advanceReceiptData = DB::table('advance_receipt')
		->where('gstin_id',$gstin_id)
		->where('status',1)
		->whereBetween('created_date', [$from_date, $to_date])
		->orderBy('ar_id', 'desc')
		->get();

		return $advanceReceiptData;
	}



	public static function cancelAdvanceReceipt($ar_id,$gstin_id){
		$updateData = DB::table('advance_receipt')
		->where('receipt_no', $ar_id)
		->where('gstin_id', $gstin_id)
		->delete();

		$deleteData = DB::table('invoice_details')
		->where('invoice_no', $ar_id)
		->where('gstin_id', $gstin_id)
		->delete();
		
		return  $deleteData;
	}



	public static function getAdvanceReceiptData($receipt_no){
		
		$getData = DB::table('advance_receipt')
		->where('receipt_no',$receipt_no)
		->where('status',1)
		->get();

		return $getData;
	}



	public static function updateAdvanceReceipt($data,$ar_id){

		$updateData = DB::table('advance_receipt')
		->where('ar_id', $ar_id)
		->update($data);

		return  $updateData;
	}



	public static function deleteReceiptDetailByArId($invoice_no,$gstin_id){
		
		$data['status'] = '0';
		$updateData = DB::table('invoice_details')
		->where('gstin_id', $gstin_id)
		->where('invoice_no', $invoice_no)
		->update($data);

		return  $updateData;
	}



	public static function getBusinessInfo($business_id){
		$getData = DB::table('business')
		->where('business_id',$business_id)
		->where('status',1)
		->get();

		return $getData;
	}



	public static function contact_serach($data,$business_id){

		$contact = DB::table('contact')
		->select(DB::raw('CONCAT (contact_name, " - " ,city) AS LABEL'),'contact_id AS ID')
		->orWhere(function ($query) use ($data) {
			$query->where('contact_name', 'like', '%'.$data.'%')
			->orWhere('city', 'like', '%'.$data.'%');
		})
		->where('business_id', $business_id)
		->get();

		return $contact;
	}





	public static function item_serach($data,$business_id){
		$item = DB::table('item')
		->select(DB::raw('CONCAT (item_description) AS LABEL'),'item_id AS ID')
		->where('item_description', 'like', '%'.$data.'%')
		->where('business_id', $business_id)
		->get();
		return $item;
	}



	public static function purchase_invoice_serach($data,$gstin_id){
		$invice = DB::table('purchase_invoice')
		->select(DB::raw('CONCAT (invoice_no) AS LABEL'),'pi_id AS ID')
		->where('invoice_no', 'like', '%'.$data.'%')
		->where('gstin_id', $gstin_id)
		->get();
		return $invice;
	}



	public static function sales_invoice_serach($data,$gstin_id){
		$invice = DB::table('sales_invoice')
		->select(DB::raw('CONCAT (invoice_no) AS LABEL'),'si_id AS ID')
		->where('invoice_no', 'like', '%'.$data.'%')
		->where('gstin_id', $gstin_id)
		->get();
		return $invice;
	}

}