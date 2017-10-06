<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;
use App\Http\Requests;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use League\Csv\Reader;
use File;
use Mail;
use App\Purchase;
use Session;
use View;
use DB;
use PDF;


class PurchaseController extends Controller{



	public function purchase($id){
		$gstin_id = decrypt($id);

		$purchaseInvoiceData = Purchase::purchaseInvoiceData($gstin_id);
		$getBusinessByGstin = Purchase::getBusinessByGstin($gstin_id);
		if(sizeof($purchaseInvoiceData) > 0){
			$totalSGST = 0;
			$totalCGST = 0;
			$totalIGST = 0;
			$totalCESS = 0;
			$totalValue = 0;
			foreach ($purchaseInvoiceData as $key => $value) {
				$totalSGST += $value->total_sgst_amount;
				$totalCGST += $value->total_cgst_amount;
				$totalIGST += $value->total_igst_amount;
				$totalCESS += $value->total_cess_amount;
				$totalValue += $value->grand_total;
			}
			$total = array();
			$total['totalTransactions'] = sizeof($purchaseInvoiceData);
			$total['totalSGST'] = $totalSGST;
			$total['totalCGST'] = $totalCGST;
			$total['totalIGST'] = $totalIGST;
			$total['totalCESS'] = $totalCESS;
			$total['totalValue'] = $totalValue;

			$data = array();
			$data['total'] = $total;
			$data['purchaseInvoiceData'] = $purchaseInvoiceData;

			$returnResponse['status'] = "success";
			$returnResponse['code'] = "302";
			$returnResponse['gstin_id'] = $id;
			$returnResponse['business_id'] = $getBusinessByGstin[0]->business_id;
			$returnResponse['message'] = "All Transactions.";
			$returnResponse['data'] = $data;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['gstin_id'] = $id;
			$returnResponse['business_id'] = $getBusinessByGstin[0]->business_id;
			$returnResponse['message'] = "No Data Found.";
			$returnResponse['data'] = '';
		}
		return view('purchase.purchase')->with('data', $returnResponse);
	}



	public function selectPurchaseInvoice($id){
		$gstin_id = decrypt($id);
		return view('purchase.selectPurchaseInvoice')->with('data', $gstin_id);
	}



	public function goodsPurchaseInvoice($id){
		$gstin_id = decrypt($id);

		$data = array();
		$getBusinessByGstin = Purchase::getBusinessByGstin($gstin_id);
		$getPurchaseInvoiceCount = Purchase::getPurchaseInvoiceCount($gstin_id);
		$getGstinInfo = Purchase::getGstinInfo($gstin_id);
		$getUnit = Purchase::getUnit();

		if(sizeof($getPurchaseInvoiceCount) > 0){
			$data['invoice_no'] = "PINV".($getPurchaseInvoiceCount[0]->count + 1);
		}else{
			$data['invoice_no'] = "PINV1";
		}

		if(sizeof($getBusinessByGstin) > 0){
			$data['gstin_id'] = $gstin_id;
			$data['business_id'] = $getBusinessByGstin[0]->business_id;
		}

		if(sizeof($getGstinInfo) > 0){
			$data['state_code'] = $getGstinInfo[0]->state_code;
			$data['state_name'] = $getGstinInfo[0]->state_name;
		}
		$data['unit'] = $getUnit;
		return view('purchase.goodsPurchaseInvoice')->with('data', $data);
	}



	public function servicesPurchaseInvoice($id){
		$gstin_id = decrypt($id);

		$data = array();
		$getBusinessByGstin = Purchase::getBusinessByGstin($gstin_id);
		$getPurchaseInvoiceCount = Purchase::getPurchaseInvoiceCount($gstin_id);
		$getGstinInfo = Purchase::getGstinInfo($gstin_id);
		$getUnit = Purchase::getUnit();

		if(sizeof($getPurchaseInvoiceCount) > 0){
			$data['invoice_no'] = "PINV".($getPurchaseInvoiceCount[0]->count + 1);
		}else{
			$data['invoice_no'] = "PINV1";
		}

		if(sizeof($getBusinessByGstin) > 0){
			$data['gstin_id'] = $gstin_id;
			$data['business_id'] = $getBusinessByGstin[0]->business_id;
		}

		if(sizeof($getGstinInfo) > 0){
			$data['state_code'] = $getGstinInfo[0]->state_code;
			$data['state_name'] = $getGstinInfo[0]->state_name;
		}
		$data['unit'] = $getUnit;
		return view('purchase.servicesPurchaseInvoice')->with('data', $data);
	}



	public function getContact($business_id){

		$getContact = Purchase::getContact($business_id);
		if(sizeof($getContact) > 0){
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "302";
			$returnResponse['message'] = "Data Found.";
			$returnResponse['data'] = $getContact;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No Content.";
			$returnResponse['data'] = $getContact;
		}
		return $returnResponse;
	}



	public function getStates(){

		$getStates = Purchase::getStates();
		if(sizeof($getStates) > 0){
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "302";
			$returnResponse['message'] = "Data Found.";
			$returnResponse['data'] = $getStates;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No Content.";
			$returnResponse['data'] = $getStates;
		}
		return $returnResponse;
	}



	public function getUnit(){

		$getUnit = Sales::getUnit();
		if(sizeof($getUnit) > 0){
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "302";
			$returnResponse['message'] = "Data Found.";
			$returnResponse['data'] = $getUnit;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No Content.";
			$returnResponse['data'] = $getUnit;
		}
		return $returnResponse;
	}



	public function getContactInfo($contact_id){

		$getContactInfo = Purchase::getContactInfo($contact_id);
		if(sizeof($getContactInfo) > 0){
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "302";
			$returnResponse['message'] = "Data Found.";
			$returnResponse['data'] = $getContactInfo;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No Content.";
			$returnResponse['data'] = $getContactInfo;
		}
		return $returnResponse;
	}



	public function getItem($business_id){

		$getItem = Purchase::getItem($business_id);
		if(sizeof($getItem) > 0){
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "302";
			$returnResponse['message'] = "Data Found.";
			$returnResponse['data'] = $getItem;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No Content.";
			$returnResponse['data'] = $getItem;
		}
		return $returnResponse;
	}



	public function getItemInfo($item_id){

		$getItemInfo = Purchase::getItemInfo($item_id);
		if(sizeof($getItemInfo) > 0){
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "302";
			$returnResponse['message'] = "Data Found.";
			$returnResponse['data'] = $getItemInfo;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No Content.";
			$returnResponse['data'] = $getItemInfo;
		}
		return $returnResponse;
	}



	public function savePurchaseInvoice(Request $request){
		$input = $request->all();

		$checkInvoiceNumber = Purchase::checkInvoiceNumber($input['gstin_id'],$input['invoice_no']);

		if(sizeof($checkInvoiceNumber) > 0){
			$returnResponse['status'] = "failed";
			$returnResponse['code'] = "400";
			$returnResponse['message'] = "Duplicate invoice number. Please change invoice number.";
			$returnResponse['data'] = $checkInvoiceNumber;
			return $returnResponse;
		}else{
			$purchaseInvoiceData = array();
			$purchaseInvoiceData['gstin_id'] = $input['gstin_id'];
			$purchaseInvoiceData['invoice_type'] = '1';
			$purchaseInvoiceData['invoice_no'] = $input['invoice_no'];
			$purchaseInvoiceData['invoice_date'] = $input['invoice_date'];
			$purchaseInvoiceData['reference'] = $input['reference'];
			$purchaseInvoiceData['contact_gstin'] = $input['contact_gstin'];
			$purchaseInvoiceData['place_of_supply'] = $input['place_of_supply'];
			$purchaseInvoiceData['due_date'] = $input['due_date'];
			$purchaseInvoiceData['contact_name'] = $input['contact_name'];
			$purchaseInvoiceData['total_discount'] = isset($input['total_discount']) ? $input['total_discount'] : "0";
			$purchaseInvoiceData['total_cgst_amount'] = isset($input['total_cgst_amount']) ? $input['total_cgst_amount'] : "0";
			$purchaseInvoiceData['total_sgst_amount'] = isset($input['total_sgst_amount']) ? $input['total_sgst_amount'] : "0";
			$purchaseInvoiceData['total_igst_amount'] = isset($input['total_igst_amount']) ? $input['total_igst_amount'] : "0";
			$purchaseInvoiceData['total_cess_amount'] = isset($input['total_cess_amount']) ? $input['total_cess_amount'] : "0";
			$purchaseInvoiceData['total_amount'] = $input['total_amount'];
			if(isset($input['tax_type_applied']) && $input['tax_type_applied'] == "on"){
				$purchaseInvoiceData['tax_type_applied'] = '1';
			}else{
				$purchaseInvoiceData['tax_type_applied'] = '0';
			}
			$purchaseInvoiceData['tt_taxable_value'] = isset($input['tt_taxable_value']) ? $input['tt_taxable_value'] : "0";
			$purchaseInvoiceData['tt_cgst_amount'] = isset($input['tt_cgst_amount']) ? $input['tt_cgst_amount'] : "0";
			$purchaseInvoiceData['tt_sgst_amount'] = isset($input['tt_sgst_amount']) ? $input['tt_sgst_amount'] : "0";
			$purchaseInvoiceData['tt_igst_amount'] = isset($input['tt_igst_amount']) ? $input['tt_igst_amount'] : "0";
			$purchaseInvoiceData['tt_cess_amount'] = isset($input['tt_cess_amount']) ? $input['tt_cess_amount'] : "0";
			$purchaseInvoiceData['tt_total'] = isset($input['tt_total']) ? $input['tt_total'] : "0";
			if(isset($input['is_freight_charge']) && $input['is_freight_charge'] == "on"){
				$purchaseInvoiceData['is_freight_charge'] = '1';
			}else{
				$purchaseInvoiceData['is_freight_charge'] = '0';
			}
			$purchaseInvoiceData['freight_charge'] = isset($input['freight_charge']) ? $input['freight_charge'] : "0";
			if(isset($input['is_lp_charge']) && $input['is_lp_charge'] == "on"){
				$purchaseInvoiceData['is_lp_charge'] = '1';
			}else{
				$purchaseInvoiceData['is_lp_charge'] = '0';
			}
			$purchaseInvoiceData['lp_charge'] = isset($input['lp_charge']) ? $input['lp_charge'] : "0";
			if(isset($input['is_insurance_charge']) && $input['is_insurance_charge'] == "on"){
				$purchaseInvoiceData['is_insurance_charge'] = '1';
			}else{
				$purchaseInvoiceData['is_insurance_charge'] = '0';
			}
			$purchaseInvoiceData['insurance_charge'] = isset($input['insurance_charge']) ? $input['insurance_charge'] : "0";
			if(isset($input['is_other_charge']) && $input['is_other_charge'] == "on"){
				$purchaseInvoiceData['is_other_charge'] = '1';
			}else{
				$purchaseInvoiceData['is_other_charge'] = '0';
			}
			$purchaseInvoiceData['other_charge'] = isset($input['other_charge']) ? $input['other_charge'] : "0";
			$purchaseInvoiceData['other_charge_name'] = isset($input['other_charge_name']) ? $input['other_charge_name'] : "";
			if(isset($input['is_roundoff']) && $input['is_roundoff'] == "on"){
				$purchaseInvoiceData['is_roundoff'] = '1';
			}else{
				$purchaseInvoiceData['is_roundoff'] = '0';
			}
			$purchaseInvoiceData['roundoff'] = isset($input['roundoff']) ? $input['roundoff'] : "0";
			$purchaseInvoiceData['total_in_words'] = $input['total_in_words'];
			$purchaseInvoiceData['total_tax'] = $input['total_tax'];
			$purchaseInvoiceData['grand_total'] = $input['grand_total'];

			$insertPurchaseInvoice = Purchase::insertPurchaseInvoice($purchaseInvoiceData);
			if($insertPurchaseInvoice > 0){

				$getSIC = Purchase::getSIC($input['gstin_id']);
				if(sizeof($getSIC) > 0){
					$count_data = array();
					$count_data['gstin_id'] = $input['gstin_id'];
					$count_data['invoice_type'] = 4;
					$count_data['count'] = $getSIC[0]->count + 1;
					$updateIC = Purchase::updateIC($count_data);
				}else{
					$add_count_data = array();
					$add_count_data['gstin_id'] = $input['gstin_id'];
					$count_data['invoice_type'] = 4;
					$add_count_data['count'] = '1';
					$addIC = Purchase::addIC($add_count_data);
				}

				$invoiceDetailData = array();

				if(is_array($input['total'])){
					foreach ($input['total'] as $key => $value) {
						$invoiceDetailData['gstin_id'] = $input['gstin_id'];
						$invoiceDetailData['invoice_no'] = $input['invoice_no'];
						$invoiceDetailData['invoice_type'] = '4';
						$invoiceDetailData['unit'] = $input['unit'][$key];
						$invoiceDetailData['item_name'] = $input['item_name'][$key];
						$invoiceDetailData['item_value'] = $input['item_value'][$key];
						$invoiceDetailData['item_type'] = "Goods";
						$invoiceDetailData['hsn_sac_no'] = $input['hsn_sac_no'][$key];
						$invoiceDetailData['quantity'] = $input['quantity'][$key];
						$invoiceDetailData['rate'] = $input['rate'][$key];
						$invoiceDetailData['discount'] = $input['discount'][$key];
						$invoiceDetailData['cgst_percentage'] = isset($input['cgst_percentage'][$key]) ? $input['cgst_percentage'][$key] : "0";
						$invoiceDetailData['cgst_amount'] = isset($input['cgst_amount'][$key]) ? $input['cgst_amount'][$key] : "0";
						$invoiceDetailData['sgst_percentage'] = isset($input['sgst_percentage'][$key]) ? $input['sgst_percentage'][$key] : "0";
						$invoiceDetailData['sgst_amount'] = isset($input['sgst_amount'][$key]) ? $input['sgst_amount'][$key] : "0";
						$invoiceDetailData['igst_percentage'] = isset($input['igst_percentage'][$key]) ? $input['igst_percentage'][$key] : "0";
						$invoiceDetailData['igst_amount'] = isset($input['igst_amount'][$key]) ? $input['igst_amount'][$key] : "0";
						$invoiceDetailData['cess_percentage'] = isset($input['cess_percentage'][$key]) ? $input['cess_percentage'][$key] : "0";
						$invoiceDetailData['cess_amount'] = isset($input['cess_amount'][$key]) ? $input['cess_amount'][$key] : "0";
						$invoiceDetailData['total'] = $input['total'][$key];
						$insertInvoiceDetails = Purchase::insertInvoiceDetails($invoiceDetailData);
					}
					$returnResponse['status'] = "success";
					$returnResponse['code'] = "201";
					$returnResponse['message'] = "Invoice created successfully.";
					$returnResponse['data'] = $insertPurchaseInvoice;
					return $returnResponse;
				}else{
					$invoiceDetailData['gstin_id'] = $input['gstin_id'];
					$invoiceDetailData['invoice_no'] = $input['invoice_no'];
					$invoiceDetailData['invoice_type'] = '4';
					$invoiceDetailData['unit'] = $input['unit'];
					$invoiceDetailData['item_name'] = $input['item_name'];
					$invoiceDetailData['item_value'] = $input['item_value'];
					$invoiceDetailData['item_type'] = "Goods";
					$invoiceDetailData['hsn_sac_no'] = $input['hsn_sac_no'];
					$invoiceDetailData['quantity'] = $input['quantity'];
					$invoiceDetailData['rate'] = $input['rate'];
					$invoiceDetailData['discount'] = $input['discount'];
					$invoiceDetailData['cgst_percentage'] = isset($input['cgst_percentage']) ? $input['cgst_percentage'] : "0";
					$invoiceDetailData['cgst_amount'] = isset($input['cgst_amount']) ? $input['cgst_amount'] : "0";
					$invoiceDetailData['sgst_percentage'] = isset($input['sgst_percentage']) ? $input['sgst_percentage'] : "0";
					$invoiceDetailData['sgst_amount'] = isset($input['sgst_amount']) ? $input['sgst_amount'] : "0";
					$invoiceDetailData['igst_percentage'] = isset($input['igst_percentage']) ? $input['igst_percentage'] : "0";
					$invoiceDetailData['igst_amount'] = isset($input['igst_amount']) ? $input['igst_amount'] : "0";
					$invoiceDetailData['cess_percentage'] = isset($input['cess_percentage']) ? $input['cess_percentage'] : "0";
					$invoiceDetailData['cess_amount'] = isset($input['cess_amount']) ? $input['cess_amount'] : "0";
					$invoiceDetailData['total'] = $input['total'];
					$insertInvoiceDetails = Purchase::insertInvoiceDetails($invoiceDetailData);

					$returnResponse['status'] = "success";
					$returnResponse['code'] = "201";
					$returnResponse['message'] = "Invoice created successfully.";
					$returnResponse['data'] = $insertPurchaseInvoice;
					return $returnResponse;
				}
			}else{
				$returnResponse['status'] = "failed";
				$returnResponse['code'] = "400";
				$returnResponse['message'] = "Error while creating invoice. Please try again.";
				$returnResponse['data'] = $insertPurchaseInvoice;
				return $returnResponse;
			}
		}
		return $returnResponse;
	}



	public function saveServicesPurchaseInvoice(Request $request){
		$input = $request->all();

		$checkInvoiceNumber = Purchase::checkInvoiceNumber($input['gstin_id'],$input['invoice_no']);

		if(sizeof($checkInvoiceNumber) > 0){
			$returnResponse['status'] = "failed";
			$returnResponse['code'] = "400";
			$returnResponse['message'] = "Duplicate invoice number. Please change invoice number.";
			$returnResponse['data'] = $checkInvoiceNumber;
			return $returnResponse;
		}else{
			$purchaseInvoiceData = array();
			$purchaseInvoiceData['gstin_id'] = $input['gstin_id'];
			$purchaseInvoiceData['invoice_type'] = '2';
			$purchaseInvoiceData['invoice_no'] = $input['invoice_no'];
			$purchaseInvoiceData['invoice_date'] = $input['invoice_date'];
			$purchaseInvoiceData['reference'] = $input['reference'];
			$purchaseInvoiceData['contact_gstin'] = $input['contact_gstin'];
			$purchaseInvoiceData['place_of_supply'] = $input['place_of_supply'];
			$purchaseInvoiceData['due_date'] = $input['due_date'];
			$purchaseInvoiceData['contact_name'] = $input['contact_name'];
			$purchaseInvoiceData['total_discount'] = isset($input['total_discount']) ? $input['total_discount'] : "0";
			$purchaseInvoiceData['total_cgst_amount'] = isset($input['total_cgst_amount']) ? $input['total_cgst_amount'] : "0";
			$purchaseInvoiceData['total_sgst_amount'] = isset($input['total_sgst_amount']) ? $input['total_sgst_amount'] : "0";
			$purchaseInvoiceData['total_igst_amount'] = isset($input['total_igst_amount']) ? $input['total_igst_amount'] : "0";
			$purchaseInvoiceData['total_cess_amount'] = isset($input['total_cess_amount']) ? $input['total_cess_amount'] : "0";
			$purchaseInvoiceData['total_amount'] = $input['total_amount'];
			if(isset($input['tax_type_applied']) && $input['tax_type_applied'] == "on"){
				$purchaseInvoiceData['tax_type_applied'] = '1';
			}else{
				$purchaseInvoiceData['tax_type_applied'] = '0';
			}
			$purchaseInvoiceData['tt_taxable_value'] = isset($input['tt_taxable_value']) ? $input['tt_taxable_value'] : "0";
			$purchaseInvoiceData['tt_cgst_amount'] = isset($input['tt_cgst_amount']) ? $input['tt_cgst_amount'] : "0";
			$purchaseInvoiceData['tt_sgst_amount'] = isset($input['tt_sgst_amount']) ? $input['tt_sgst_amount'] : "0";
			$purchaseInvoiceData['tt_igst_amount'] = isset($input['tt_igst_amount']) ? $input['tt_igst_amount'] : "0";
			$purchaseInvoiceData['tt_cess_amount'] = isset($input['tt_cess_amount']) ? $input['tt_cess_amount'] : "0";
			$purchaseInvoiceData['tt_total'] = isset($input['tt_total']) ? $input['tt_total'] : "0";
			if(isset($input['is_roundoff']) && $input['is_roundoff'] == "on"){
				$purchaseInvoiceData['is_roundoff'] = '1';
			}else{
				$purchaseInvoiceData['is_roundoff'] = '0';
			}
			$purchaseInvoiceData['roundoff'] = isset($input['roundoff']) ? $input['roundoff'] : "0";
			$purchaseInvoiceData['total_in_words'] = $input['total_in_words'];
			$purchaseInvoiceData['total_tax'] = $input['total_tax'];
			$purchaseInvoiceData['grand_total'] = $input['grand_total'];

			$insertPurchaseInvoice = Purchase::insertPurchaseInvoice($purchaseInvoiceData);
			if($insertPurchaseInvoice > 0){

				$getSIC = Purchase::getSIC($input['gstin_id']);
				if(sizeof($getSIC) > 0){
					$count_data = array();
					$count_data['gstin_id'] = $input['gstin_id'];
					$count_data['invoice_type'] = 4;
					$count_data['count'] = $getSIC[0]->count + 1;
					$updateIC = Purchase::updateIC($count_data);
				}else{
					$add_count_data = array();
					$add_count_data['gstin_id'] = $input['gstin_id'];
					$count_data['invoice_type'] = 4;
					$add_count_data['count'] = '1';
					$addIC = Purchase::addIC($add_count_data);
				}

				$invoiceDetailData = array();

				if(is_array($input['total'])){
					foreach ($input['total'] as $key => $value) {
						$invoiceDetailData['gstin_id'] = $input['gstin_id'];
						$invoiceDetailData['invoice_no'] = $input['invoice_no'];
						$invoiceDetailData['invoice_type'] = '4';
						$invoiceDetailData['unit'] = $input['unit'][$key];
						$invoiceDetailData['item_name'] = $input['item_name'][$key];
						$invoiceDetailData['item_value'] = $input['item_value'][$key];
						$invoiceDetailData['item_type'] = "Goods";
						$invoiceDetailData['hsn_sac_no'] = $input['hsn_sac_no'][$key];
						$invoiceDetailData['quantity'] = $input['quantity'][$key];
						$invoiceDetailData['rate'] = $input['rate'][$key];
						$invoiceDetailData['discount'] = $input['discount'][$key];
						$invoiceDetailData['cgst_percentage'] = isset($input['cgst_percentage'][$key]) ? $input['cgst_percentage'][$key] : "0";
						$invoiceDetailData['cgst_amount'] = isset($input['cgst_amount'][$key]) ? $input['cgst_amount'][$key] : "0";
						$invoiceDetailData['sgst_percentage'] = isset($input['sgst_percentage'][$key]) ? $input['sgst_percentage'][$key] : "0";
						$invoiceDetailData['sgst_amount'] = isset($input['sgst_amount'][$key]) ? $input['sgst_amount'][$key] : "0";
						$invoiceDetailData['igst_percentage'] = isset($input['igst_percentage'][$key]) ? $input['igst_percentage'][$key] : "0";
						$invoiceDetailData['igst_amount'] = isset($input['igst_amount'][$key]) ? $input['igst_amount'][$key] : "0";
						$invoiceDetailData['cess_percentage'] = isset($input['cess_percentage'][$key]) ? $input['cess_percentage'][$key] : "0";
						$invoiceDetailData['cess_amount'] = isset($input['cess_amount'][$key]) ? $input['cess_amount'][$key] : "0";
						$invoiceDetailData['total'] = $input['total'][$key];
						$insertInvoiceDetails = Purchase::insertInvoiceDetails($invoiceDetailData);
					}
					$returnResponse['status'] = "success";
					$returnResponse['code'] = "201";
					$returnResponse['message'] = "Invoice created successfully.";
					$returnResponse['data'] = $insertPurchaseInvoice;
					return $returnResponse;
				}else{
					$invoiceDetailData['gstin_id'] = $input['gstin_id'];
					$invoiceDetailData['invoice_no'] = $input['invoice_no'];
					$invoiceDetailData['invoice_type'] = '4';
					$invoiceDetailData['unit'] = $input['unit'];
					$invoiceDetailData['item_name'] = $input['item_name'];
					$invoiceDetailData['item_value'] = $input['item_value'];
					$invoiceDetailData['item_type'] = "Goods";
					$invoiceDetailData['hsn_sac_no'] = $input['hsn_sac_no'];
					$invoiceDetailData['quantity'] = $input['quantity'];
					$invoiceDetailData['rate'] = $input['rate'];
					$invoiceDetailData['discount'] = $input['discount'];
					$invoiceDetailData['cgst_percentage'] = isset($input['cgst_percentage']) ? $input['cgst_percentage'] : "0";
					$invoiceDetailData['cgst_amount'] = isset($input['cgst_amount']) ? $input['cgst_amount'] : "0";
					$invoiceDetailData['sgst_percentage'] = isset($input['sgst_percentage']) ? $input['sgst_percentage'] : "0";
					$invoiceDetailData['sgst_amount'] = isset($input['sgst_amount']) ? $input['sgst_amount'] : "0";
					$invoiceDetailData['igst_percentage'] = isset($input['igst_percentage']) ? $input['igst_percentage'] : "0";
					$invoiceDetailData['igst_amount'] = isset($input['igst_amount']) ? $input['igst_amount'] : "0";
					$invoiceDetailData['cess_percentage'] = isset($input['cess_percentage']) ? $input['cess_percentage'] : "0";
					$invoiceDetailData['cess_amount'] = isset($input['cess_amount']) ? $input['cess_amount'] : "0";
					$invoiceDetailData['total'] = $input['total'];
					$insertInvoiceDetails = Purchase::insertInvoiceDetails($invoiceDetailData);

					$returnResponse['status'] = "success";
					$returnResponse['code'] = "201";
					$returnResponse['message'] = "Invoice created successfully.";
					$returnResponse['data'] = $insertPurchaseInvoice;
					return $returnResponse;
				}
			}else{
				$returnResponse['status'] = "failed";
				$returnResponse['code'] = "400";
				$returnResponse['message'] = "Error while creating invoice. Please try again.";
				$returnResponse['data'] = $insertPurchaseInvoice;
				return $returnResponse;
			}
		}
		return $returnResponse;
	}



	public function cancelPurchaseInvoice($id,$gstin_id){
		$getData = Purchase::cancelPurchaseInvoice($id,$gstin_id);

		if (sizeof($getData) > 0) {
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Invoice cncelled successfully.";
			$returnResponse['data'] = $getData;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "Something went wrong while cancelling invoice.";
			$returnResponse['data'] = $getData;
		}
		return response()->json($returnResponse);
	}



	public function viewPurchaseInvoice($id,$gstin_id){
		$invoice_id = decrypt($id);
		$gstin_id = decrypt($gstin_id);
		$getData = Purchase::getPurchaseInvoiceData($invoice_id,$gstin_id);

		if (sizeof($getData) > 0) {
			$getInvoiceDetail = Purchase::getInvoiceDetail($getData[0]->invoice_no,$getData[0]->gstin_id);
			$getBusinessByGstin = Purchase::getBusinessByGstin($getData[0]->gstin_id);
			$getGstinInfo = Purchase::getGstinInfo($getData[0]->gstin_id);
			if(sizeof($getGstinInfo) > 0){
				$returnResponse['state_code'] = $getGstinInfo[0]->state_code;
				$returnResponse['state_name'] = $getGstinInfo[0]->state_name;
			}

			$data = array();
			$data['invoice_data'] = $getData;
			$data['invoice_details'] = $getInvoiceDetail;

			if(sizeof($getBusinessByGstin) > 0){
				$returnResponse['business_id'] = $getBusinessByGstin[0]->business_id;
			}

			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Data found.";
			$returnResponse['data'] = $data;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No data found.";
			$returnResponse['data'] = $getData;
		}
		return view('purchase.viewPurchaseInvoice')->with('data', $returnResponse);
	}



	public function viewServicesPurchaseInvoice($id,$gstin_id){
		$invoice_id = decrypt($id);
		$gstin_id = decrypt($gstin_id);
		$getData = Purchase::getPurchaseInvoiceData($invoice_id,$gstin_id);

		if (sizeof($getData) > 0) {
			$getInvoiceDetail = Purchase::getInvoiceDetail($getData[0]->invoice_no,$getData[0]->gstin_id);
			$getBusinessByGstin = Purchase::getBusinessByGstin($getData[0]->gstin_id);
			$getGstinInfo = Purchase::getGstinInfo($getData[0]->gstin_id);
			if(sizeof($getGstinInfo) > 0){
				$returnResponse['state_code'] = $getGstinInfo[0]->state_code;
				$returnResponse['state_name'] = $getGstinInfo[0]->state_name;
			}

			$data = array();
			$data['invoice_data'] = $getData;
			$data['invoice_details'] = $getInvoiceDetail;

			if(sizeof($getBusinessByGstin) > 0){
				$returnResponse['business_id'] = $getBusinessByGstin[0]->business_id;
			}

			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Data found.";
			$returnResponse['data'] = $data;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No data found.";
			$returnResponse['data'] = $getData;
		}
		return view('purchase.viewServicesPurchaseInvoice')->with('data', $returnResponse);
	}



	public function printPurchaseInvoice(Request $request,$id){
		$invoice_id = decrypt($id);
		$getData = Purchase::getPurchaseInvoiceData($invoice_id);

		if (sizeof($getData) > 0) {
			$getInvoiceDetail = Purchase::getInvoiceDetail($getData[0]->invoice_no,$getData[0]->gstin_id);
			$getBusinessByGstin = Purchase::getBusinessByGstin($getData[0]->gstin_id);
			$getGstinInfo = Purchase::getGstinInfo($getData[0]->gstin_id);
			if(sizeof($getGstinInfo) > 0){
				$returnResponse['state_code'] = $getGstinInfo[0]->state_code;
				$returnResponse['state_name'] = $getGstinInfo[0]->state_name;
			}

			$data = array();
			$data['invoice_data'] = $getData;
			$data['invoice_details'] = $getInvoiceDetail;

			if(sizeof($getBusinessByGstin) > 0){
				$returnResponse['business_id'] = $getBusinessByGstin[0]->business_id;
			}

			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Data found.";
			$returnResponse['data'] = $data;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No data found.";
			$returnResponse['data'] = $getData;
		}

		/*view()->share('data',$returnResponse);
		$pdf = PDF::loadView('purchase.printPurchaseInvoice');

		if($request->has('download')){
			$pdf = PDF::loadView('purchase.printPurchaseInvoice');
			return $pdf->download('PurchaseInvoice.pdf');
		}
		return $pdf->stream('PurchaseInvoice.pdf');
		return view('purchase.printPurchaseInvoice');*/
		return view('purchase.printPurchaseInvoice')->with('data', $returnResponse);
	}



	public function editPurchaseInvoice($id,$gstin_id){
		$invoice_id = decrypt($id);
		$gstin_id = decrypt($gstin_id);
		$getData = Purchase::getPurchaseInvoiceData($invoice_id,$gstin_id);

		if (sizeof($getData) > 0) {
			$getInvoiceDetail = Purchase::getInvoiceDetail($getData[0]->invoice_no,$getData[0]->gstin_id);
			$getBusinessByGstin = Purchase::getBusinessByGstin($getData[0]->gstin_id);
			$getGstinInfo = Purchase::getGstinInfo($getData[0]->gstin_id);
			$getUnit = Purchase::getUnit();
			if(sizeof($getGstinInfo) > 0){
				$returnResponse['state_code'] = $getGstinInfo[0]->state_code;
				$returnResponse['state_name'] = $getGstinInfo[0]->state_name;
			}

			$data = array();
			$data['invoice_data'] = $getData;
			$data['invoice_details'] = $getInvoiceDetail;
			$data['units'] = $getUnit;

			if(sizeof($getBusinessByGstin) > 0){
				$returnResponse['business_id'] = $getBusinessByGstin[0]->business_id;
			}

			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Data found.";
			$returnResponse['data'] = $data;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No data found.";
			$returnResponse['data'] = $getData;
		}
		return view('purchase.editPurchaseInvoice')->with('data', $returnResponse);
	}



	public function editServicesPurchaseInvoice($id,$gstin_id){
		$invoice_id = decrypt($id);
		$gstin_id = decrypt($gstin_id);
		$getData = Purchase::getPurchaseInvoiceData($invoice_id,$gstin_id);

		if (sizeof($getData) > 0) {
			$getInvoiceDetail = Purchase::getInvoiceDetail($getData[0]->invoice_no,$getData[0]->gstin_id);
			$getBusinessByGstin = Purchase::getBusinessByGstin($getData[0]->gstin_id);
			$getGstinInfo = Purchase::getGstinInfo($getData[0]->gstin_id);
			$getUnit = Purchase::getUnit();
			if(sizeof($getGstinInfo) > 0){
				$returnResponse['state_code'] = $getGstinInfo[0]->state_code;
				$returnResponse['state_name'] = $getGstinInfo[0]->state_name;
			}

			$data = array();
			$data['invoice_data'] = $getData;
			$data['invoice_details'] = $getInvoiceDetail;
			$data['units'] = $getUnit;

			if(sizeof($getBusinessByGstin) > 0){
				$returnResponse['business_id'] = $getBusinessByGstin[0]->business_id;
			}

			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Data found.";
			$returnResponse['data'] = $data;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No data found.";
			$returnResponse['data'] = $getData;
		}
		return view('purchase.editServicesPurchaseInvoice')->with('data', $returnResponse);
	}



	public function deleteInvoiceDetail($id){
		$getData = Purchase::deleteInvoiceDetail($id);

		if (sizeof($getData) > 0) {
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Invoice detail deleted successfully.";
			$returnResponse['data'] = $getData;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "Something went wrong while deleting invoice details.";
			$returnResponse['data'] = $getData;
		}
		return response()->json($returnResponse);
	}



	public function updatePurchaseInvoice(Request $request,$pi_id){
		$input = $request->all();

		$purchaseInvoiceData = array();
		$purchaseInvoiceData['gstin_id'] = $input['gstin_id'];
		$purchaseInvoiceData['invoice_type'] = '1';
		$purchaseInvoiceData['invoice_no'] = $input['invoice_no'];
		$purchaseInvoiceData['invoice_date'] = $input['invoice_date'];
		$purchaseInvoiceData['reference'] = $input['reference'];
		$purchaseInvoiceData['contact_gstin'] = $input['contact_gstin'];
		$purchaseInvoiceData['place_of_supply'] = $input['place_of_supply'];
		$purchaseInvoiceData['due_date'] = $input['due_date'];
		$purchaseInvoiceData['contact_name'] = $input['contact_name'];
		$purchaseInvoiceData['total_discount'] = isset($input['total_discount']) ? $input['total_discount'] : "0";
		$purchaseInvoiceData['total_cgst_amount'] = isset($input['total_cgst_amount']) ? $input['total_cgst_amount'] : "0";
		$purchaseInvoiceData['total_sgst_amount'] = isset($input['total_sgst_amount']) ? $input['total_sgst_amount'] : "0";
		$purchaseInvoiceData['total_igst_amount'] = isset($input['total_igst_amount']) ? $input['total_igst_amount'] : "0";
		$purchaseInvoiceData['total_cess_amount'] = isset($input['total_cess_amount']) ? $input['total_cess_amount'] : "0";
		$purchaseInvoiceData['total_amount'] = $input['total_amount'];
		if(isset($input['tax_type_applied']) && $input['tax_type_applied'] == "on"){
			$purchaseInvoiceData['tax_type_applied'] = '1';
		}else{
			$purchaseInvoiceData['tax_type_applied'] = '0';
		}
		$purchaseInvoiceData['tt_taxable_value'] = isset($input['tt_taxable_value']) ? $input['tt_taxable_value'] : "0";
		$purchaseInvoiceData['tt_cgst_amount'] = isset($input['tt_cgst_amount']) ? $input['tt_cgst_amount'] : "0";
		$purchaseInvoiceData['tt_sgst_amount'] = isset($input['tt_sgst_amount']) ? $input['tt_sgst_amount'] : "0";
		$purchaseInvoiceData['tt_igst_amount'] = isset($input['tt_igst_amount']) ? $input['tt_igst_amount'] : "0";
		$purchaseInvoiceData['tt_cess_amount'] = isset($input['tt_cess_amount']) ? $input['tt_cess_amount'] : "0";
		$purchaseInvoiceData['tt_total'] = isset($input['tt_total']) ? $input['tt_total'] : "0";
		if(isset($input['is_roundoff']) && $input['is_roundoff'] == "on"){
			$purchaseInvoiceData['is_roundoff'] = '1';
		}else{
			$purchaseInvoiceData['is_roundoff'] = '0';
		}
		$purchaseInvoiceData['roundoff'] = isset($input['roundoff']) ? $input['roundoff'] : "0";
		if(isset($input['is_freight_charge']) && $input['is_freight_charge'] == "on"){
			$purchaseInvoiceData['is_freight_charge'] = '1';
		}else{
			$purchaseInvoiceData['is_freight_charge'] = '0';
		}
		$purchaseInvoiceData['freight_charge'] = isset($input['freight_charge']) ? $input['freight_charge'] : "0";
		if(isset($input['is_lp_charge']) && $input['is_lp_charge'] == "on"){
			$purchaseInvoiceData['is_lp_charge'] = '1';
		}else{
			$purchaseInvoiceData['is_lp_charge'] = '0';
		}
		$purchaseInvoiceData['lp_charge'] = isset($input['lp_charge']) ? $input['lp_charge'] : "0";
		if(isset($input['is_insurance_charge']) && $input['is_insurance_charge'] == "on"){
			$purchaseInvoiceData['is_insurance_charge'] = '1';
		}else{
			$purchaseInvoiceData['is_insurance_charge'] = '0';
		}
		$purchaseInvoiceData['insurance_charge'] = isset($input['insurance_charge']) ? $input['insurance_charge'] : "0";
		if(isset($input['is_other_charge']) && $input['is_other_charge'] == "on"){
			$purchaseInvoiceData['is_other_charge'] = '1';
		}else{
			$purchaseInvoiceData['is_other_charge'] = '0';
		}
		$purchaseInvoiceData['other_charge'] = isset($input['other_charge']) ? $input['other_charge'] : "0";
		$purchaseInvoiceData['other_charge_name'] = isset($input['other_charge_name']) ? $input['other_charge_name'] : "0";
		$purchaseInvoiceData['total_in_words'] = $input['total_in_words'];
		$purchaseInvoiceData['total_tax'] = $input['total_tax'];
		$purchaseInvoiceData['grand_total'] = $input['grand_total'];
		
		$updatePurchaseInvoice = Purchase::updatePurchaseInvoice($purchaseInvoiceData,$pi_id);

		$invoiceDetailData = array();
		$deleteInvoiceDetailBySiId = Purchase::deleteInvoiceDetailBySiId($input['invoice_no']);

		if(is_array($input['total'])){
			foreach ($input['total'] as $key => $value) {
				$invoiceDetailData['gstin_id'] = $input['gstin_id'];
				$invoiceDetailData['invoice_no'] = $input['invoice_no'];
				$invoiceDetailData['invoice_type'] = '4';
				$invoiceDetailData['unit'] = $input['unit'][$key];
				$invoiceDetailData['item_name'] = $input['item_name'][$key];
				$invoiceDetailData['item_value'] = $input['item_value'][$key];
				$invoiceDetailData['item_type'] = "Goods";
				$invoiceDetailData['hsn_sac_no'] = $input['hsn_sac_no'][$key];
				$invoiceDetailData['quantity'] = $input['quantity'][$key];
				$invoiceDetailData['rate'] = $input['rate'][$key];
				$invoiceDetailData['discount'] = $input['discount'][$key];
				$invoiceDetailData['cgst_percentage'] = isset($input['cgst_percentage'][$key]) ? $input['cgst_percentage'][$key] : "0";
				$invoiceDetailData['cgst_amount'] = isset($input['cgst_amount'][$key]) ? $input['cgst_amount'][$key] : "0";
				$invoiceDetailData['sgst_percentage'] = isset($input['sgst_percentage'][$key]) ? $input['sgst_percentage'][$key] : "0";
				$invoiceDetailData['sgst_amount'] = isset($input['sgst_amount'][$key]) ? $input['sgst_amount'][$key] : "0";
				$invoiceDetailData['igst_percentage'] = isset($input['igst_percentage'][$key]) ? $input['igst_percentage'][$key] : "0";
				$invoiceDetailData['igst_amount'] = isset($input['igst_amount'][$key]) ? $input['igst_amount'][$key] : "0";
				$invoiceDetailData['cess_percentage'] = isset($input['cess_percentage'][$key]) ? $input['cess_percentage'][$key] : "0";
				$invoiceDetailData['cess_amount'] = isset($input['cess_amount'][$key]) ? $input['cess_amount'][$key] : "0";
				$invoiceDetailData['total'] = $input['total'][$key];
				$insertInvoiceDetails = Purchase::insertInvoiceDetails($invoiceDetailData);
			}
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "201";
			$returnResponse['message'] = "Invoice updated successfully.";
			$returnResponse['data'] = $insertInvoiceDetails;
			return $returnResponse;
		}else{
			$invoiceDetailData['gstin_id'] = $input['gstin_id'];
			$invoiceDetailData['invoice_no'] = $input['invoice_no'];
			$invoiceDetailData['invoice_type'] = '4';
			$invoiceDetailData['unit'] = $input['unit'];
			$invoiceDetailData['item_name'] = $input['item_name'];
			$invoiceDetailData['item_value'] = $input['item_value'];
			$invoiceDetailData['item_type'] = "Goods";
			$invoiceDetailData['hsn_sac_no'] = $input['hsn_sac_no'];
			$invoiceDetailData['quantity'] = $input['quantity'];
			$invoiceDetailData['rate'] = $input['rate'];
			$invoiceDetailData['discount'] = $input['discount'];
			$invoiceDetailData['cgst_percentage'] = isset($input['cgst_percentage']) ? $input['cgst_percentage'] : "0";
			$invoiceDetailData['cgst_amount'] = isset($input['cgst_amount']) ? $input['cgst_amount'] : "0";
			$invoiceDetailData['sgst_percentage'] = isset($input['sgst_percentage']) ? $input['sgst_percentage'] : "0";
			$invoiceDetailData['sgst_amount'] = isset($input['sgst_amount']) ? $input['sgst_amount'] : "0";
			$invoiceDetailData['igst_percentage'] = isset($input['igst_percentage']) ? $input['igst_percentage'] : "0";
			$invoiceDetailData['igst_amount'] = isset($input['igst_amount']) ? $input['igst_amount'] : "0";
			$invoiceDetailData['cess_percentage'] = isset($input['cess_percentage']) ? $input['cess_percentage'] : "0";
			$invoiceDetailData['cess_amount'] = isset($input['cess_amount']) ? $input['cess_amount'] : "0";
			$invoiceDetailData['total'] = $input['total'];
			$insertInvoiceDetails = Purchase::insertInvoiceDetails($invoiceDetailData);

			$returnResponse['status'] = "success";
			$returnResponse['code'] = "201";
			$returnResponse['message'] = "Invoice updated successfully.";
			$returnResponse['data'] = $insertInvoiceDetails;
			return $returnResponse;
		}
		return $returnResponse;
	}



	public function updateServicesPurchaseInvoice(Request $request,$pi_id){
		$input = $request->all();

		$purchaseInvoiceData = array();
		$purchaseInvoiceData['gstin_id'] = $input['gstin_id'];
		$purchaseInvoiceData['invoice_type'] = '2';
		$purchaseInvoiceData['invoice_no'] = $input['invoice_no'];
		$purchaseInvoiceData['invoice_date'] = $input['invoice_date'];
		$purchaseInvoiceData['reference'] = $input['reference'];
		$purchaseInvoiceData['contact_gstin'] = $input['contact_gstin'];
		$purchaseInvoiceData['place_of_supply'] = $input['place_of_supply'];
		$purchaseInvoiceData['due_date'] = $input['due_date'];
		$purchaseInvoiceData['contact_name'] = $input['contact_name'];
		$purchaseInvoiceData['total_discount'] = isset($input['total_discount']) ? $input['total_discount'] : "0";
		$purchaseInvoiceData['total_cgst_amount'] = isset($input['total_cgst_amount']) ? $input['total_cgst_amount'] : "0";
		$purchaseInvoiceData['total_sgst_amount'] = isset($input['total_sgst_amount']) ? $input['total_sgst_amount'] : "0";
		$purchaseInvoiceData['total_igst_amount'] = isset($input['total_igst_amount']) ? $input['total_igst_amount'] : "0";
		$purchaseInvoiceData['total_cess_amount'] = isset($input['total_cess_amount']) ? $input['total_cess_amount'] : "0";
		$purchaseInvoiceData['total_amount'] = $input['total_amount'];
		if(isset($input['tax_type_applied']) && $input['tax_type_applied'] == "on"){
			$purchaseInvoiceData['tax_type_applied'] = '1';
		}else{
			$purchaseInvoiceData['tax_type_applied'] = '0';
		}
		$purchaseInvoiceData['tt_taxable_value'] = isset($input['tt_taxable_value']) ? $input['tt_taxable_value'] : "0";
		$purchaseInvoiceData['tt_cgst_amount'] = isset($input['tt_cgst_amount']) ? $input['tt_cgst_amount'] : "0";
		$purchaseInvoiceData['tt_sgst_amount'] = isset($input['tt_sgst_amount']) ? $input['tt_sgst_amount'] : "0";
		$purchaseInvoiceData['tt_igst_amount'] = isset($input['tt_igst_amount']) ? $input['tt_igst_amount'] : "0";
		$purchaseInvoiceData['tt_cess_amount'] = isset($input['tt_cess_amount']) ? $input['tt_cess_amount'] : "0";
		$purchaseInvoiceData['tt_total'] = isset($input['tt_total']) ? $input['tt_total'] : "0";
		if(isset($input['is_roundoff']) && $input['is_roundoff'] == "on"){
			$purchaseInvoiceData['is_roundoff'] = '1';
		}else{
			$purchaseInvoiceData['is_roundoff'] = '0';
		}
		$purchaseInvoiceData['roundoff'] = isset($input['roundoff']) ? $input['roundoff'] : "0";
		$purchaseInvoiceData['total_in_words'] = $input['total_in_words'];
		$purchaseInvoiceData['total_tax'] = $input['total_tax'];
		$purchaseInvoiceData['grand_total'] = $input['grand_total'];
		
		$updatePurchaseInvoice = Purchase::updatePurchaseInvoice($purchaseInvoiceData,$pi_id);

		$invoiceDetailData = array();
		$deleteInvoiceDetailBySiId = Purchase::deleteInvoiceDetailBySiId($input['invoice_no']);

		if(is_array($input['total'])){
			foreach ($input['total'] as $key => $value) {
				$invoiceDetailData['gstin_id'] = $input['gstin_id'];
				$invoiceDetailData['invoice_no'] = $input['invoice_no'];
				$invoiceDetailData['invoice_type'] = '4';
				$invoiceDetailData['unit'] = $input['unit'][$key];
				$invoiceDetailData['item_name'] = $input['item_name'][$key];
				$invoiceDetailData['item_value'] = $input['item_value'][$key];
				$invoiceDetailData['item_type'] = "Goods";
				$invoiceDetailData['hsn_sac_no'] = $input['hsn_sac_no'][$key];
				$invoiceDetailData['quantity'] = $input['quantity'][$key];
				$invoiceDetailData['rate'] = $input['rate'][$key];
				$invoiceDetailData['discount'] = $input['discount'][$key];
				$invoiceDetailData['cgst_percentage'] = isset($input['cgst_percentage'][$key]) ? $input['cgst_percentage'][$key] : "0";
				$invoiceDetailData['cgst_amount'] = isset($input['cgst_amount'][$key]) ? $input['cgst_amount'][$key] : "0";
				$invoiceDetailData['sgst_percentage'] = isset($input['sgst_percentage'][$key]) ? $input['sgst_percentage'][$key] : "0";
				$invoiceDetailData['sgst_amount'] = isset($input['sgst_amount'][$key]) ? $input['sgst_amount'][$key] : "0";
				$invoiceDetailData['igst_percentage'] = isset($input['igst_percentage'][$key]) ? $input['igst_percentage'][$key] : "0";
				$invoiceDetailData['igst_amount'] = isset($input['igst_amount'][$key]) ? $input['igst_amount'][$key] : "0";
				$invoiceDetailData['cess_percentage'] = isset($input['cess_percentage'][$key]) ? $input['cess_percentage'][$key] : "0";
				$invoiceDetailData['cess_amount'] = isset($input['cess_amount'][$key]) ? $input['cess_amount'][$key] : "0";
				$invoiceDetailData['total'] = $input['total'][$key];
				$insertInvoiceDetails = Purchase::insertInvoiceDetails($invoiceDetailData);
			}
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "201";
			$returnResponse['message'] = "Invoice updated successfully.";
			$returnResponse['data'] = $insertInvoiceDetails;
			return $returnResponse;
		}else{
			$invoiceDetailData['gstin_id'] = $input['gstin_id'];
			$invoiceDetailData['invoice_no'] = $input['invoice_no'];
			$invoiceDetailData['invoice_type'] = '4';
			$invoiceDetailData['unit'] = $input['unit'];
			$invoiceDetailData['item_name'] = $input['item_name'];
			$invoiceDetailData['item_value'] = $input['item_value'];
			$invoiceDetailData['item_type'] = "Goods";
			$invoiceDetailData['hsn_sac_no'] = $input['hsn_sac_no'];
			$invoiceDetailData['quantity'] = $input['quantity'];
			$invoiceDetailData['rate'] = $input['rate'];
			$invoiceDetailData['discount'] = $input['discount'];
			$invoiceDetailData['cgst_percentage'] = isset($input['cgst_percentage']) ? $input['cgst_percentage'] : "0";
			$invoiceDetailData['cgst_amount'] = isset($input['cgst_amount']) ? $input['cgst_amount'] : "0";
			$invoiceDetailData['sgst_percentage'] = isset($input['sgst_percentage']) ? $input['sgst_percentage'] : "0";
			$invoiceDetailData['sgst_amount'] = isset($input['sgst_amount']) ? $input['sgst_amount'] : "0";
			$invoiceDetailData['igst_percentage'] = isset($input['igst_percentage']) ? $input['igst_percentage'] : "0";
			$invoiceDetailData['igst_amount'] = isset($input['igst_amount']) ? $input['igst_amount'] : "0";
			$invoiceDetailData['cess_percentage'] = isset($input['cess_percentage']) ? $input['cess_percentage'] : "0";
			$invoiceDetailData['cess_amount'] = isset($input['cess_amount']) ? $input['cess_amount'] : "0";
			$invoiceDetailData['total'] = $input['total'];
			$insertInvoiceDetails = Purchase::insertInvoiceDetails($invoiceDetailData);

			$returnResponse['status'] = "success";
			$returnResponse['code'] = "201";
			$returnResponse['message'] = "Invoice updated successfully.";
			$returnResponse['data'] = $insertInvoiceDetails;
			return $returnResponse;
		}
		return $returnResponse;
	}



	public function vcdnote($id){
		$gstin_id = decrypt($id);
		$creditDebitNoteData = Purchase::creditDebitNoteData($gstin_id);
		$getBusinessByGstin = Purchase::getBusinessByGstin($gstin_id);
		if(sizeof($creditDebitNoteData) > 0){
			$creditTransaction = 0;
			$creditValue = 0;
			$debitTransaction = 0;
			$debitValue = 0;
			foreach ($creditDebitNoteData as $key => $value) {
				if($value->note_type == 1){
					$key = 1;
					$creditTransaction += $key;
					$creditValue += $value->grand_total;
				}
				if($value->note_type == 2){
					$key = 1;
					$debitTransaction += $key;
					$debitValue += $value->grand_total;
				}
			}
			$total = array();
			$total['totalTransactions'] = sizeof($creditDebitNoteData);
			$total['creditTransaction'] = $creditTransaction;
			$total['creditValue'] = $creditValue;
			$total['debitTransaction'] = $debitTransaction;
			$total['debitValue'] = $debitValue;

			$data = array();
			$data['total'] = $total;
			$data['creditDebitNoteData'] = $creditDebitNoteData;

			$returnResponse['status'] = "success";
			$returnResponse['code'] = "302";
			$returnResponse['gstin_id'] = $id;
			$returnResponse['business_id'] = $getBusinessByGstin[0]->business_id;
			$returnResponse['message'] = "All Transactions.";
			$returnResponse['data'] = $data;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['gstin_id'] = $id;
			$returnResponse['business_id'] = $getBusinessByGstin[0]->business_id;
			$returnResponse['message'] = "No Data Found.";
			$returnResponse['data'] = '';
		}
		return view('purchase.vcdnote')->with('data', $returnResponse);
	}



	public function createVcdnote($id){
		$gstin_id = decrypt($id);

		$data = array();
		$getBusinessByGstin = Purchase::getBusinessByGstin($gstin_id);
		$getCdnoteInvoiceCount = Purchase::getVcdnoteInvoiceCount($gstin_id);
		$getGstinInfo = Purchase::getGstinInfo($gstin_id);
		$getUnit = Purchase::getUnit();

		if(sizeof($getCdnoteInvoiceCount) > 0){
			$data['note_no'] = "VCN".($getCdnoteInvoiceCount[0]->count + 1);
		}else{
			$data['note_no'] = "VCN1";
		}

		if(sizeof($getBusinessByGstin) > 0){
			$data['gstin_id'] = $gstin_id;
			$data['business_id'] = $getBusinessByGstin[0]->business_id;
		}

		if(sizeof($getGstinInfo) > 0){
			$data['state_code'] = $getGstinInfo[0]->state_code;
			$data['state_name'] = $getGstinInfo[0]->state_name;
		}
		$data['unit'] = $getUnit;
		return view('purchase.createVcdnote')->with('data', $data);
	}



	public function getInvoice($gstin){
		
		$getInvoice = Purchase::getInvoice($gstin);
		if(sizeof($getInvoice) > 0){
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "302";
			$returnResponse['message'] = "Data Found.";
			$returnResponse['data'] = $getInvoice;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No Content.";
			$returnResponse['data'] = $getInvoice;
		}
		return $returnResponse;
	}



	public function getPurchaseInvoiceInfo($pi_id){

		$getInvoiceInfo = Purchase::getPurchaseInvoiceInfo($pi_id);
		if(sizeof($getInvoiceInfo) > 0){
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "302";
			$returnResponse['message'] = "Data Found.";
			$returnResponse['data'] = $getInvoiceInfo;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No Content.";
			$returnResponse['data'] = $getInvoiceInfo;
		}
		return $returnResponse;
	}



	public function saveVcdnote(Request $request){
		$input = $request->all();

		$checkCdnoteNumber = Purchase::checkCdnoteNumber($input['gstin_id'],$input['note_no']);

		if(sizeof($checkCdnoteNumber) > 0){
			$returnResponse['status'] = "failed";
			$returnResponse['code'] = "400";
			$returnResponse['message'] = "Duplicate note number. Please change note number.";
			$returnResponse['data'] = $checkCdnoteNumber;
			return $returnResponse;
		}else{
			$cdnoteData = array();
			$cdnoteData['gstin_id'] = $input['gstin_id'];
			$cdnoteData['note_type'] = $input['note_type'];
			$cdnoteData['note_no'] = $input['note_no'];
			$cdnoteData['invoice_no'] = $input['invoice_no'];
			$cdnoteData['contact_name'] = $input['contact_name'];
			$cdnoteData['note_issue_date'] = $input['note_issue_date'];
			$cdnoteData['contact_gstin'] = $input['contact_gstin'];
			$cdnoteData['place_of_supply'] = $input['place_of_supply'];
			$cdnoteData['total_discount'] = isset($input['total_discount']) ? $input['total_discount'] : "0";
			$cdnoteData['total_cgst_amount'] = isset($input['total_cgst_amount']) ? $input['total_cgst_amount'] : "0";
			$cdnoteData['total_sgst_amount'] = isset($input['total_sgst_amount']) ? $input['total_sgst_amount'] : "0";
			$cdnoteData['total_igst_amount'] = isset($input['total_igst_amount']) ? $input['total_igst_amount'] : "0";
			$cdnoteData['total_cess_amount'] = isset($input['total_cess_amount']) ? $input['total_cess_amount'] : "0";
			if(isset($input['tax_type_applied']) && $input['tax_type_applied'] == "on"){
				$cdnoteData['tax_type_applied'] = '1';
			}else{
				$cdnoteData['tax_type_applied'] = '0';
			}
			$cdnoteData['tt_taxable_value'] = isset($input['tt_taxable_value']) ? $input['tt_taxable_value'] : "0";
			$cdnoteData['tt_cgst_amount'] = isset($input['tt_cgst_amount']) ? $input['tt_cgst_amount'] : "0";
			$cdnoteData['tt_sgst_amount'] = isset($input['tt_sgst_amount']) ? $input['tt_sgst_amount'] : "0";
			$cdnoteData['tt_igst_amount'] = isset($input['tt_igst_amount']) ? $input['tt_igst_amount'] : "0";
			$cdnoteData['tt_cess_amount'] = isset($input['tt_cess_amount']) ? $input['tt_cess_amount'] : "0";
			$cdnoteData['tt_total'] = isset($input['tt_total']) ? $input['tt_total'] : "0";
			if(isset($input['is_freight_charge']) && $input['is_freight_charge'] == "on"){
				$cdnoteData['is_freight_charge'] = '1';
			}else{
				$cdnoteData['is_freight_charge'] = '0';
			}
			$cdnoteData['freight_charge'] = isset($input['freight_charge']) ? $input['freight_charge'] : "0";
			if(isset($input['is_lp_charge']) && $input['is_lp_charge'] == "on"){
				$cdnoteData['is_lp_charge'] = '1';
			}else{
				$cdnoteData['is_lp_charge'] = '0';
			}
			$cdnoteData['lp_charge'] = isset($input['lp_charge']) ? $input['lp_charge'] : "0";
			if(isset($input['is_insurance_charge']) && $input['is_insurance_charge'] == "on"){
				$cdnoteData['is_insurance_charge'] = '1';
			}else{
				$cdnoteData['is_insurance_charge'] = '0';
			}
			$cdnoteData['insurance_charge'] = isset($input['insurance_charge']) ? $input['insurance_charge'] : "0";
			if(isset($input['is_other_charge']) && $input['is_other_charge'] == "on"){
				$cdnoteData['is_other_charge'] = '1';
			}else{
				$cdnoteData['is_other_charge'] = '0';
			}
			$cdnoteData['other_charge'] = isset($input['other_charge']) ? $input['other_charge'] : "0";
			$cdnoteData['other_charge_name'] = isset($input['other_charge_name']) ? $input['other_charge_name'] : "";
			if(isset($input['is_roundoff']) && $input['is_roundoff'] == "on"){
				$cdnoteData['is_roundoff'] = '1';
			}else{
				$cdnoteData['is_roundoff'] = '0';
			}
			$cdnoteData['roundoff'] = isset($input['roundoff']) ? $input['roundoff'] : "0";
			$cdnoteData['total_amount'] = $input['total_amount'];
			$cdnoteData['grand_total'] = $input['grand_total'];
			$cdnoteData['total_in_words'] = $input['total_in_words'];
			$cdnoteData['total_tax'] = $input['total_tax'];
			
			$insertCdnote = Purchase::insertVcdnote($cdnoteData);
			if($insertCdnote > 0){

				$getCDNC = Purchase::getCDNC($input['gstin_id']);
				if(sizeof($getCDNC) > 0){
					$count_data = array();
					$count_data['gstin_id'] = $input['gstin_id'];
					$count_data['invoice_type'] = 5;
					$count_data['count'] = $getCDNC[0]->count + 1;
					$updateIC = Purchase::updateCDNC($count_data);
				}else{
					$add_count_data = array();
					$add_count_data['gstin_id'] = $input['gstin_id'];
					$count_data['invoice_type'] = 5;
					$add_count_data['count'] = '1';
					$addIC = Purchase::addCDNC($add_count_data);
				}

				$cdnoteDetailData = array();

				if(is_array($input['total'])){
					foreach ($input['total'] as $key => $value) {
						$cdnoteDetailData['gstin_id'] = $input['gstin_id'];
						$cdnoteDetailData['invoice_no'] = $input['note_no'];
						$cdnoteDetailData['invoice_type'] = '5';
						$cdnoteDetailData['unit'] = $input['unit'][$key];
						$cdnoteDetailData['item_name'] = $input['item_name'][$key];
						$cdnoteDetailData['item_value'] = $input['item_value'][$key];
						$cdnoteDetailData['item_type'] = "Goods";
						$cdnoteDetailData['hsn_sac_no'] = $input['hsn_sac_no'][$key];
						$cdnoteDetailData['quantity'] = $input['quantity'][$key];
						$cdnoteDetailData['rate'] = $input['rate'][$key];
						$cdnoteDetailData['discount'] = $input['discount'][$key];
						$cdnoteDetailData['cgst_percentage'] = isset($input['cgst_percentage'][$key]) ? $input['cgst_percentage'][$key] : "0";
						$cdnoteDetailData['cgst_amount'] = isset($input['cgst_amount'][$key]) ? $input['cgst_amount'][$key] : "0";
						$cdnoteDetailData['sgst_percentage'] = isset($input['sgst_percentage'][$key]) ? $input['sgst_percentage'][$key] : "0";
						$cdnoteDetailData['sgst_amount'] = isset($input['sgst_amount'][$key]) ? $input['sgst_amount'][$key] : "0";
						$cdnoteDetailData['igst_percentage'] = isset($input['igst_percentage'][$key]) ? $input['igst_percentage'][$key] : "0";
						$cdnoteDetailData['igst_amount'] = isset($input['igst_amount'][$key]) ? $input['igst_amount'][$key] : "0";
						$cdnoteDetailData['cess_percentage'] = isset($input['cess_percentage'][$key]) ? $input['cess_percentage'][$key] : "0";
						$cdnoteDetailData['cess_amount'] = isset($input['cess_amount'][$key]) ? $input['cess_amount'][$key] : "0";
						$cdnoteDetailData['total'] = $input['total'][$key];
						$insertInvoiceDetails = Purchase::insertInvoiceDetails($cdnoteDetailData);
					}
					$returnResponse['status'] = "success";
					$returnResponse['code'] = "201";
					$returnResponse['message'] = "Note created successfully.";
					$returnResponse['data'] = $insertCdnote;
					return $returnResponse;
				}else{
					$cdnoteDetailData['gstin_id'] = $input['gstin_id'];
					$cdnoteDetailData['invoice_no'] = $input['note_no'];
					$cdnoteDetailData['invoice_type'] = '5';
					$cdnoteDetailData['unit'] = $input['unit'];
					$cdnoteDetailData['item_name'] = $input['item_name'];
					$cdnoteDetailData['item_value'] = $input['item_value'];
					$cdnoteDetailData['item_type'] = "Goods";
					$cdnoteDetailData['hsn_sac_no'] = $input['hsn_sac_no'];
					$cdnoteDetailData['quantity'] = $input['quantity'];
					$cdnoteDetailData['rate'] = $input['rate'];
					$cdnoteDetailData['discount'] = $input['discount'];
					$cdnoteDetailData['cgst_percentage'] = isset($input['cgst_percentage']) ? $input['cgst_percentage'] : "0";
					$cdnoteDetailData['cgst_amount'] = isset($input['cgst_amount']) ? $input['cgst_amount'] : "0";
					$cdnoteDetailData['sgst_percentage'] = isset($input['sgst_percentage']) ? $input['sgst_percentage'] : "0";
					$cdnoteDetailData['sgst_amount'] = isset($input['sgst_amount']) ? $input['sgst_amount'] : "0";
					$cdnoteDetailData['igst_percentage'] = isset($input['igst_percentage']) ? $input['igst_percentage'] : "0";
					$cdnoteDetailData['igst_amount'] = isset($input['igst_amount']) ? $input['igst_amount'] : "0";
					$cdnoteDetailData['cess_percentage'] = isset($input['cess_percentage']) ? $input['cess_percentage'] : "0";
					$cdnoteDetailData['cess_amount'] = isset($input['cess_amount']) ? $input['cess_amount'] : "0";
					$cdnoteDetailData['total'] = $input['total'];
					$insertInvoiceDetails = Purchase::insertInvoiceDetails($cdnoteDetailData);

					$returnResponse['status'] = "success";
					$returnResponse['code'] = "201";
					$returnResponse['message'] = "Note created successfully.";
					$returnResponse['data'] = $insertCdnote;
					return $returnResponse;
				}
			}else{
				$returnResponse['status'] = "failed";
				$returnResponse['code'] = "400";
				$returnResponse['message'] = "Error while creating invoice. Please try again.";
				$returnResponse['data'] = $insertCdnote;
				return $returnResponse;
			}
		}
		return $returnResponse;
	}



	public function cancelVcdnote($id,$gstin_id){

		$getData = Purchase::cancelCdnote($id,$gstin_id);

		if (sizeof($getData) > 0) {
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Note cncelled successfully.";
			$returnResponse['data'] = $getData;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "Something went wrong while cancelling note.";
			$returnResponse['data'] = $getData;
		}
		return response()->json($returnResponse);
	}



	public function viewVcdnote($id,$gstin_id){
		$note_no = decrypt($id);
		$gstin_id = decrypt($gstin_id);
		$getData = Purchase::getVcdnoteData($note_no,$gstin_id);

		if (sizeof($getData) > 0) {
			$getInvoiceDetail = Purchase::getInvoiceDetail($getData[0]->note_no,$getData[0]->gstin_id);
			$getBusinessByGstin = Purchase::getBusinessByGstin($getData[0]->gstin_id);
			$getGstinInfo = Purchase::getGstinInfo($getData[0]->gstin_id);
			$getUnit = Purchase::getUnit();
			if(sizeof($getGstinInfo) > 0){
				$returnResponse['state_code'] = $getGstinInfo[0]->state_code;
				$returnResponse['state_name'] = $getGstinInfo[0]->state_name;
			}

			$data = array();
			$data['invoice_data'] = $getData;
			$data['invoice_details'] = $getInvoiceDetail;

			if(sizeof($getBusinessByGstin) > 0){
				$returnResponse['business_id'] = $getBusinessByGstin[0]->business_id;
			}

			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Data found.";
			$returnResponse['data'] = $data;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No data found.";
			$returnResponse['data'] = $getData;
		}
		return view('purchase.viewVcdnote')->with('data', $returnResponse);
	}



	public function printVcdnote(Request $request,$id){
		$note_no = decrypt($id);
		$getData = Purchase::getVcdnoteData($note_no);

		if (sizeof($getData) > 0) {
			$getInvoiceDetail = Purchase::getInvoiceDetail($getData[0]->note_no,$getData[0]->gstin_id);
			$getBusinessByGstin = Purchase::getBusinessByGstin($getData[0]->gstin_id);
			$getGstinInfo = Purchase::getGstinInfo($getData[0]->gstin_id);
			if(sizeof($getGstinInfo) > 0){
				$returnResponse['state_code'] = $getGstinInfo[0]->state_code;
				$returnResponse['state_name'] = $getGstinInfo[0]->state_name;
			}

			$data = array();
			$data['invoice_data'] = $getData;
			$data['invoice_details'] = $getInvoiceDetail;

			if(sizeof($getBusinessByGstin) > 0){
				$returnResponse['business_id'] = $getBusinessByGstin[0]->business_id;
			}

			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Data found.";
			$returnResponse['data'] = $data;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No data found.";
			$returnResponse['data'] = $getData;
		}

		/*view()->share('data',$returnResponse);
		$pdf = PDF::loadView('purchase.printVcdnote');

		if($request->has('download')){
			$pdf = PDF::loadView('purchase.printVcdnote');
			return $pdf->download('Vendor-Credit-Debit-Note.pdf');
		}
		return $pdf->stream('Vendor-Credit-Debit-Note.pdf');
		return view('purchase.printVcdnote');*/
		return view('purchase.printVcdnote')->with('data', $returnResponse);
	}



	public function editVcdnote($id,$gstin_id){
		$note_no = decrypt($id);
		$gstin_id = decrypt($gstin_id);
		$getData = Purchase::getVcdnoteData($note_no,$gstin_id);

		if (sizeof($getData) > 0) {
			$getInvoiceDetail = Purchase::getInvoiceDetail($getData[0]->note_no,$getData[0]->gstin_id);
			$getBusinessByGstin = Purchase::getBusinessByGstin($getData[0]->gstin_id);
			$getGstinInfo = Purchase::getGstinInfo($getData[0]->gstin_id);
			$getUnit = Purchase::getUnit();
			if(sizeof($getGstinInfo) > 0){
				$returnResponse['state_code'] = $getGstinInfo[0]->state_code;
				$returnResponse['state_name'] = $getGstinInfo[0]->state_name;
			}

			$data = array();
			$data['invoice_data'] = $getData;
			$data['invoice_details'] = $getInvoiceDetail;
			$data['units'] = $getUnit;

			if(sizeof($getBusinessByGstin) > 0){
				$returnResponse['business_id'] = $getBusinessByGstin[0]->business_id;
			}

			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Data found.";
			$returnResponse['data'] = $data;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No data found.";
			$returnResponse['data'] = $getData;
		}
		return view('purchase.editVcdnote')->with('data', $returnResponse);
	}



	public function updateVcdnote(Request $request,$vcdn_id){
		$input = $request->all();

		$cdnoteData = array();
		$cdnoteData['gstin_id'] = $input['gstin_id'];
		$cdnoteData['note_type'] = $input['note_type'];
		$cdnoteData['note_no'] = $input['note_no'];
		$cdnoteData['invoice_no'] = $input['invoice_no'];
		$cdnoteData['contact_name'] = $input['contact_name'];
		$cdnoteData['note_issue_date'] = $input['note_issue_date'];
		$cdnoteData['contact_gstin'] = $input['contact_gstin'];
		$cdnoteData['place_of_supply'] = $input['place_of_supply'];
		$cdnoteData['total_discount'] = isset($input['total_discount']) ? $input['total_discount'] : "0";
		$cdnoteData['total_cgst_amount'] = isset($input['total_cgst_amount']) ? $input['total_cgst_amount'] : "0";
		$cdnoteData['total_sgst_amount'] = isset($input['total_sgst_amount']) ? $input['total_sgst_amount'] : "0";
		$cdnoteData['total_igst_amount'] = isset($input['total_igst_amount']) ? $input['total_igst_amount'] : "0";
		$cdnoteData['total_cess_amount'] = isset($input['total_cess_amount']) ? $input['total_cess_amount'] : "0";
		if(isset($input['tax_type_applied']) && $input['tax_type_applied'] == "on"){
			$cdnoteData['tax_type_applied'] = '1';
		}else{
			$cdnoteData['tax_type_applied'] = '0';
		}
		$cdnoteData['tt_taxable_value'] = isset($input['tt_taxable_value']) ? $input['tt_taxable_value'] : "0";
		$cdnoteData['tt_cgst_amount'] = isset($input['tt_cgst_amount']) ? $input['tt_cgst_amount'] : "0";
		$cdnoteData['tt_sgst_amount'] = isset($input['tt_sgst_amount']) ? $input['tt_sgst_amount'] : "0";
		$cdnoteData['tt_igst_amount'] = isset($input['tt_igst_amount']) ? $input['tt_igst_amount'] : "0";
		$cdnoteData['tt_cess_amount'] = isset($input['tt_cess_amount']) ? $input['tt_cess_amount'] : "0";
		$cdnoteData['tt_total'] = isset($input['tt_total']) ? $input['tt_total'] : "0";
		if(isset($input['is_freight_charge']) && $input['is_freight_charge'] == "on"){
			$cdnoteData['is_freight_charge'] = '1';
		}else{
			$cdnoteData['is_freight_charge'] = '0';
		}
		$cdnoteData['freight_charge'] = isset($input['freight_charge']) ? $input['freight_charge'] : "0";
		if(isset($input['is_lp_charge']) && $input['is_lp_charge'] == "on"){
			$cdnoteData['is_lp_charge'] = '1';
		}else{
			$cdnoteData['is_lp_charge'] = '0';
		}
		$cdnoteData['lp_charge'] = isset($input['lp_charge']) ? $input['lp_charge'] : "0";
		if(isset($input['is_insurance_charge']) && $input['is_insurance_charge'] == "on"){
			$cdnoteData['is_insurance_charge'] = '1';
		}else{
			$cdnoteData['is_insurance_charge'] = '0';
		}
		$cdnoteData['insurance_charge'] = isset($input['insurance_charge']) ? $input['insurance_charge'] : "0";
		if(isset($input['is_other_charge']) && $input['is_other_charge'] == "on"){
			$cdnoteData['is_other_charge'] = '1';
		}else{
			$cdnoteData['is_other_charge'] = '0';
		}
		$cdnoteData['other_charge'] = isset($input['other_charge']) ? $input['other_charge'] : "0";
		$cdnoteData['other_charge_name'] = isset($input['other_charge_name']) ? $input['other_charge_name'] : "0";
		if(isset($input['is_roundoff']) && $input['is_roundoff'] == "on"){
			$cdnoteData['is_roundoff'] = '1';
		}else{
			$cdnoteData['is_roundoff'] = '0';
		}
		$cdnoteData['roundoff'] = isset($input['roundoff']) ? $input['roundoff'] : "0";
		$cdnoteData['total_amount'] = $input['total_amount'];
		$cdnoteData['grand_total'] = $input['grand_total'];
		$cdnoteData['total_in_words'] = $input['total_in_words'];
		$cdnoteData['total_tax'] = $input['total_tax'];
		
		$insertCdnote = Purchase::updateVcdnote($cdnoteData,$vcdn_id);

		$invoiceDetailData = array();
		$deleteNoteDetailByDcnId = Purchase::deleteNoteDetailByDcnId($input['note_no']);

		if(is_array($input['total'])){
			foreach ($input['total'] as $key => $value) {
				$cdnoteDetailData['gstin_id'] = $input['gstin_id'];
				$cdnoteDetailData['invoice_no'] = $input['note_no'];
				$cdnoteDetailData['invoice_type'] = '5';
				$cdnoteDetailData['unit'] = $input['unit'][$key];
				$cdnoteDetailData['item_name'] = $input['item_name'][$key];
				$cdnoteDetailData['item_value'] = $input['item_value'][$key];
				$cdnoteDetailData['item_type'] = "Goods";
				$cdnoteDetailData['hsn_sac_no'] = $input['hsn_sac_no'][$key];
				$cdnoteDetailData['quantity'] = $input['quantity'][$key];
				$cdnoteDetailData['rate'] = $input['rate'][$key];
				$cdnoteDetailData['discount'] = $input['discount'][$key];
				$cdnoteDetailData['cgst_percentage'] = isset($input['cgst_percentage'][$key]) ? $input['cgst_percentage'][$key] : "0";
				$cdnoteDetailData['cgst_amount'] = isset($input['cgst_amount'][$key]) ? $input['cgst_amount'][$key] : "0";
				$cdnoteDetailData['sgst_percentage'] = isset($input['sgst_percentage'][$key]) ? $input['sgst_percentage'][$key] : "0";
				$cdnoteDetailData['sgst_amount'] = isset($input['sgst_amount'][$key]) ? $input['sgst_amount'][$key] : "0";
				$cdnoteDetailData['igst_percentage'] = isset($input['igst_percentage'][$key]) ? $input['igst_percentage'][$key] : "0";
				$cdnoteDetailData['igst_amount'] = isset($input['igst_amount'][$key]) ? $input['igst_amount'][$key] : "0";
				$cdnoteDetailData['cess_percentage'] = isset($input['cess_percentage'][$key]) ? $input['cess_percentage'][$key] : "0";
				$cdnoteDetailData['cess_amount'] = isset($input['cess_amount'][$key]) ? $input['cess_amount'][$key] : "0";
				$cdnoteDetailData['total'] = $input['total'][$key];
				$insertInvoiceDetails = Purchase::insertInvoiceDetails($cdnoteDetailData);
			}
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "201";
			$returnResponse['message'] = "Invoice updated successfully.";
			$returnResponse['data'] = $insertCdnote;
			return $returnResponse;
		}else{
			$cdnoteDetailData['gstin_id'] = $input['gstin_id'];
			$cdnoteDetailData['invoice_no'] = $input['note_no'];
			$cdnoteDetailData['invoice_type'] = '5';
			$cdnoteDetailData['unit'] = $input['unit'];
			$cdnoteDetailData['item_name'] = $input['item_name'];
			$cdnoteDetailData['item_type'] = "Goods";
			$cdnoteDetailData['hsn_sac_no'] = $input['hsn_sac_no'];
			$cdnoteDetailData['quantity'] = $input['quantity'];
			$cdnoteDetailData['rate'] = $input['rate'];
			$cdnoteDetailData['discount'] = $input['discount'];
			$cdnoteDetailData['cgst_percentage'] = isset($input['cgst_percentage']) ? $input['cgst_percentage'] : "0";
			$cdnoteDetailData['cgst_amount'] = isset($input['cgst_amount']) ? $input['cgst_amount'] : "0";
			$cdnoteDetailData['sgst_percentage'] = isset($input['sgst_percentage']) ? $input['sgst_percentage'] : "0";
			$cdnoteDetailData['sgst_amount'] = isset($input['sgst_amount']) ? $input['sgst_amount'] : "0";
			$cdnoteDetailData['igst_percentage'] = isset($input['igst_percentage']) ? $input['igst_percentage'] : "0";
			$cdnoteDetailData['igst_amount'] = isset($input['igst_amount']) ? $input['igst_amount'] : "0";
			$cdnoteDetailData['cess_percentage'] = isset($input['cess_percentage']) ? $input['cess_percentage'] : "0";
			$cdnoteDetailData['cess_amount'] = isset($input['cess_amount']) ? $input['cess_amount'] : "0";
			$cdnoteDetailData['total'] = $input['total'];
			$insertInvoiceDetails = Purchase::insertInvoiceDetails($cdnoteDetailData);

			$returnResponse['status'] = "success";
			$returnResponse['code'] = "201";
			$returnResponse['message'] = "Note updated successfully.";
			$returnResponse['data'] = $insertCdnote;
			return $returnResponse;
		}
		return $returnResponse;
	}



	public function createAdvancePayment($id){
		$gstin_id = decrypt($id);

		$data = array();
		$getBusinessByGstin = Purchase::getBusinessByGstin($gstin_id);
		$getAdvanceReceiptCount = Purchase::getAdvancePaymentCount($gstin_id);
		$getGstinInfo = Purchase::getGstinInfo($gstin_id);
		$getUnit = Purchase::getUnit();
		if(sizeof($getAdvanceReceiptCount) > 0){
			$data['receipt_no'] = "APN".($getAdvanceReceiptCount[0]->count + 1);
		}else{
			$data['receipt_no'] = "APN1";
		}

		if(sizeof($getBusinessByGstin) > 0){
			$data['gstin_id'] = $gstin_id;
			$data['business_id'] = $getBusinessByGstin[0]->business_id;
		}

		if(sizeof($getGstinInfo) > 0){
			$data['state_code'] = $getGstinInfo[0]->state_code;
			$data['state_name'] = $getGstinInfo[0]->state_name;
		}
		$data['unit'] = $getUnit;
		return view('purchase.createAdvancePayment')->with('data', $data);
	}



	public function saveAdvancePayment(Request $request){
		$input = $request->all();

		$advanceReceiptData = array();
		$advanceReceiptData['gstin_id'] = $input['gstin_id'];
		$advanceReceiptData['payment_no'] = $input['receipt_no'];
		$advanceReceiptData['payment_date'] = $input['receipt_date'];
		$advanceReceiptData['contact_gstin'] = $input['contact_gstin'];
		$advanceReceiptData['place_of_supply'] = $input['place_of_supply'];
		$advanceReceiptData['contact_name'] = $input['contact_name'];
		$advanceReceiptData['total_discount'] = isset($input['total_discount']) ? $input['total_discount'] : "0";
		$advanceReceiptData['total_cgst_amount'] = isset($input['total_cgst_amount']) ? $input['total_cgst_amount'] : "0";
		$advanceReceiptData['total_sgst_amount'] = isset($input['total_sgst_amount']) ? $input['total_sgst_amount'] : "0";
		$advanceReceiptData['total_igst_amount'] = isset($input['total_igst_amount']) ? $input['total_igst_amount'] : "0";
		$advanceReceiptData['total_cess_amount'] = isset($input['total_cess_amount']) ? $input['total_cess_amount'] : "0";
		if(isset($input['tax_type_applied']) && $input['tax_type_applied'] == "on"){
			$advanceReceiptData['tax_type_applied'] = '1';
		}else{
			$advanceReceiptData['tax_type_applied'] = '0';
		}
		$advanceReceiptData['tt_taxable_value'] = isset($input['tt_taxable_value']) ? $input['tt_taxable_value'] : "0";
		$advanceReceiptData['tt_cgst_amount'] = isset($input['tt_cgst_amount']) ? $input['tt_cgst_amount'] : "0";
		$advanceReceiptData['tt_sgst_amount'] = isset($input['tt_sgst_amount']) ? $input['tt_sgst_amount'] : "0";
		$advanceReceiptData['tt_igst_amount'] = isset($input['tt_igst_amount']) ? $input['tt_igst_amount'] : "0";
		$advanceReceiptData['tt_cess_amount'] = isset($input['tt_cess_amount']) ? $input['tt_cess_amount'] : "0";
		$advanceReceiptData['tt_total'] = isset($input['tt_total']) ? $input['tt_total'] : "0";
		if(isset($input['is_freight_charge']) && $input['is_freight_charge'] == "on"){
			$advanceReceiptData['is_freight_charge'] = '1';
		}else{
			$advanceReceiptData['is_freight_charge'] = '0';
		}
		$advanceReceiptData['freight_charge'] = isset($input['freight_charge']) ? $input['freight_charge'] : "0";
		if(isset($input['is_lp_charge']) && $input['is_lp_charge'] == "on"){
			$advanceReceiptData['is_lp_charge'] = '1';
		}else{
			$advanceReceiptData['is_lp_charge'] = '0';
		}
		$advanceReceiptData['lp_charge'] = isset($input['lp_charge']) ? $input['lp_charge'] : "0";
		if(isset($input['is_insurance_charge']) && $input['is_insurance_charge'] == "on"){
			$advanceReceiptData['is_insurance_charge'] = '1';
		}else{
			$advanceReceiptData['is_insurance_charge'] = '0';
		}
		$advanceReceiptData['insurance_charge'] = isset($input['insurance_charge']) ? $input['insurance_charge'] : "0";
		if(isset($input['is_other_charge']) && $input['is_other_charge'] == "on"){
			$advanceReceiptData['is_other_charge'] = '1';
		}else{
			$advanceReceiptData['is_other_charge'] = '0';
		}
		$advanceReceiptData['other_charge'] = isset($input['other_charge']) ? $input['other_charge'] : "0";
		$advanceReceiptData['other_charge_name'] = isset($input['other_charge_name']) ? $input['other_charge_name'] : "";
		$advanceReceiptData['total_amount'] = $input['total_amount'];
		if(isset($input['is_roundoff']) && $input['is_roundoff'] == "on"){
			$advanceReceiptData['is_roundoff'] = '1';
		}else{
			$advanceReceiptData['is_roundoff'] = '0';
		}
		$advanceReceiptData['roundoff'] = isset($input['roundoff']) ? $input['roundoff'] : "0";
		$advanceReceiptData['total_in_words'] = $input['total_in_words'];
		$advanceReceiptData['total_tax'] = $input['total_tax'];
		$advanceReceiptData['grand_total'] = $input['grand_total'];
		
		$insertAdvanceReceipt = Purchase::insertAdvancePayment($advanceReceiptData);
		if($insertAdvanceReceipt > 0){

			$getARC = Purchase::getARC($input['gstin_id']);
			if(sizeof($getARC) > 0){
				$count_data = array();
				$count_data['gstin_id'] = $input['gstin_id'];
				$count_data['invoice_type'] = 6;
				$count_data['count'] = $getARC[0]->count + 1;
				$updateIC = Purchase::updateARC($count_data);
			}else{
				$add_count_data = array();
				$add_count_data['gstin_id'] = $input['gstin_id'];
				$count_data['invoice_type'] = 6;
				$add_count_data['count'] = '1';
				$addIC = Purchase::addARC($add_count_data);
			}

			$invoiceDetailData = array();

			if(is_array($input['total'])){
				foreach ($input['total'] as $key => $value) {
					$invoiceDetailData['gstin_id'] = $input['gstin_id'];
					$invoiceDetailData['invoice_no'] = $input['receipt_no'];
					$invoiceDetailData['invoice_type'] = '6';
					$invoiceDetailData['unit'] = $input['unit'][$key];
					$invoiceDetailData['item_name'] = $input['item_name'][$key];
					$invoiceDetailData['item_value'] = $input['item_value'][$key];
					$invoiceDetailData['item_type'] = "Goods";
					$invoiceDetailData['hsn_sac_no'] = $input['hsn_sac_no'][$key];
					$invoiceDetailData['quantity'] = $input['quantity'][$key];
					$invoiceDetailData['rate'] = $input['rate'][$key];
					$invoiceDetailData['discount'] = $input['discount'][$key];
					$invoiceDetailData['cgst_percentage'] = isset($input['cgst_percentage'][$key]) ? $input['cgst_percentage'][$key] : "0";
					$invoiceDetailData['cgst_amount'] = isset($input['cgst_amount'][$key]) ? $input['cgst_amount'][$key] : "0";
					$invoiceDetailData['sgst_percentage'] = isset($input['sgst_percentage'][$key]) ? $input['sgst_percentage'][$key] : "0";
					$invoiceDetailData['sgst_amount'] = isset($input['sgst_amount'][$key]) ? $input['sgst_amount'][$key] : "0";
					$invoiceDetailData['igst_percentage'] = isset($input['igst_percentage'][$key]) ? $input['igst_percentage'][$key] : "0";
					$invoiceDetailData['igst_amount'] = isset($input['igst_amount'][$key]) ? $input['igst_amount'][$key] : "0";
					$invoiceDetailData['cess_percentage'] = isset($input['cess_percentage'][$key]) ? $input['cess_percentage'][$key] : "0";
					$invoiceDetailData['cess_amount'] = isset($input['cess_amount'][$key]) ? $input['cess_amount'][$key] : "0";
					$invoiceDetailData['total'] = $input['total'][$key];
					$insertInvoiceDetails = Purchase::insertInvoiceDetails($invoiceDetailData);
				}
				$returnResponse['status'] = "success";
				$returnResponse['code'] = "201";
				$returnResponse['message'] = "Advance payment created successfully.";
				$returnResponse['data'] = $insertAdvanceReceipt;
				return $returnResponse;
			}else{
				$invoiceDetailData['gstin_id'] = $input['gstin_id'];
				$invoiceDetailData['invoice_no'] = $input['receipt_no'];
				$invoiceDetailData['invoice_type'] = '6';
				$invoiceDetailData['unit'] = $input['unit'];
				$invoiceDetailData['item_name'] = $input['item_name'];
				$invoiceDetailData['item_type'] = "Goods";
				$invoiceDetailData['hsn_sac_no'] = $input['hsn_sac_no'];
				$invoiceDetailData['quantity'] = $input['quantity'];
				$invoiceDetailData['rate'] = $input['rate'];
				$invoiceDetailData['discount'] = $input['discount'];
				$invoiceDetailData['cgst_percentage'] = isset($input['cgst_percentage']) ? $input['cgst_percentage'] : "0";
				$invoiceDetailData['cgst_amount'] = isset($input['cgst_amount']) ? $input['cgst_amount'] : "0";
				$invoiceDetailData['sgst_percentage'] = isset($input['sgst_percentage']) ? $input['sgst_percentage'] : "0";
				$invoiceDetailData['sgst_amount'] = isset($input['sgst_amount']) ? $input['sgst_amount'] : "0";
				$invoiceDetailData['igst_percentage'] = isset($input['igst_percentage']) ? $input['igst_percentage'] : "0";
				$invoiceDetailData['igst_amount'] = isset($input['igst_amount']) ? $input['igst_amount'] : "0";
				$invoiceDetailData['cess_percentage'] = isset($input['cess_percentage']) ? $input['cess_percentage'] : "0";
				$invoiceDetailData['cess_amount'] = isset($input['cess_amount']) ? $input['cess_amount'] : "0";
				$invoiceDetailData['total'] = $input['total'];
				$insertInvoiceDetails = Purchase::insertInvoiceDetails($invoiceDetailData);

				$returnResponse['status'] = "success";
				$returnResponse['code'] = "201";
				$returnResponse['message'] = "Advance payment created successfully.";
				$returnResponse['data'] = $insertAdvanceReceipt;
				return $returnResponse;
			}
		}else{
			$returnResponse['status'] = "failed";
			$returnResponse['code'] = "400";
			$returnResponse['message'] = "Error while creating invoice. Please try again.";
			$returnResponse['data'] = $insertAdvanceReceipt;
			return $returnResponse;
		}
		return $returnResponse;
	}



	public function advancePayment($id){
		$gstin_id = decrypt($id);

		$advanceReceiptData = Purchase::advanceReceiptData($gstin_id);
		$getBusinessByGstin = Purchase::getBusinessByGstin($gstin_id);
		if(sizeof($advanceReceiptData) > 0){
			$totalSGST = 0;
			$totalCGST = 0;
			$totalIGST = 0;
			$totalCESS = 0;
			$totalValue = 0;
			foreach ($advanceReceiptData as $key => $value) {
				$totalSGST += $value->total_sgst_amount;
				$totalCGST += $value->total_cgst_amount;
				$totalIGST += $value->total_igst_amount;
				$totalCESS += $value->total_cess_amount;
				$totalValue += $value->grand_total;
			}
			$total = array();
			$total['totalTransactions'] = sizeof($advanceReceiptData);
			$total['totalSGST'] = $totalSGST;
			$total['totalCGST'] = $totalCGST;
			$total['totalIGST'] = $totalIGST;
			$total['totalCESS'] = $totalCESS;
			$total['totalValue'] = $totalValue;

			$data = array();
			$data['total'] = $total;
			$data['advanceReceiptData'] = $advanceReceiptData;

			$returnResponse['status'] = "success";
			$returnResponse['code'] = "302";
			$returnResponse['gstin_id'] = $id;
			$returnResponse['business_id'] = $getBusinessByGstin[0]->business_id;
			$returnResponse['message'] = "All Transactions.";
			$returnResponse['data'] = $data;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['gstin_id'] = $id;
			$returnResponse['business_id'] = $getBusinessByGstin[0]->business_id;
			$returnResponse['message'] = "No Data Found.";
			$returnResponse['data'] = '';
		}
		return view('purchase.advancePayment')->with('data', $returnResponse);
	}



	public function cancelAdvancePayment($id,$gstin){
		$getData = Purchase::cancelAdvancePayment($id,$gstin);

		if (sizeof($getData) > 0) {
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Receipt deleted successfully.";
			$returnResponse['data'] = $getData;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "Something went wrong while cancelling note.";
			$returnResponse['data'] = $getData;
		}
		return response()->json($returnResponse);
	}



	public function viewAdvancePayment($id,$gstin_id){
		$receipt_no = decrypt($id);
		$gstin_id = decrypt($gstin_id);
		$getData = Purchase::getAdvanceReceiptData($receipt_no,$gstin_id);

		if (sizeof($getData) > 0) {
			$getInvoiceDetail = Purchase::getInvoiceDetail($getData[0]->payment_no,$getData[0]->gstin_id);
			$getBusinessByGstin = Purchase::getBusinessByGstin($getData[0]->gstin_id);
			$getGstinInfo = Purchase::getGstinInfo($getData[0]->gstin_id);
			if(sizeof($getGstinInfo) > 0){
				$returnResponse['state_code'] = $getGstinInfo[0]->state_code;
				$returnResponse['state_name'] = $getGstinInfo[0]->state_name;
			}

			$data = array();
			$data['invoice_data'] = $getData;
			$data['invoice_details'] = $getInvoiceDetail;

			if(sizeof($getBusinessByGstin) > 0){
				$returnResponse['business_id'] = $getBusinessByGstin[0]->business_id;
			}

			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Data found.";
			$returnResponse['data'] = $data;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No data found.";
			$returnResponse['data'] = $getData;
		}
		return view('purchase.viewAdvancePayment')->with('data', $returnResponse);
	}



	public function printAdvancePayment(Request $request,$id){
		$receipt_no = decrypt($id);
		$gstin_id = decrypt($gstin_id);
		$getData = Purchase::getAdvanceReceiptData($receipt_no,$gstin_id);

		if (sizeof($getData) > 0) {
			$getInvoiceDetail = Purchase::getInvoiceDetail($getData[0]->note_no,$getData[0]->gstin_id);
			$getBusinessByGstin = Purchase::getBusinessByGstin($getData[0]->gstin_id);
			$getGstinInfo = Purchase::getGstinInfo($getData[0]->gstin_id);
			if(sizeof($getGstinInfo) > 0){
				$returnResponse['state_code'] = $getGstinInfo[0]->state_code;
				$returnResponse['state_name'] = $getGstinInfo[0]->state_name;
			}

			$data = array();
			$data['invoice_data'] = $getData;
			$data['invoice_details'] = $getInvoiceDetail;

			if(sizeof($getBusinessByGstin) > 0){
				$returnResponse['business_id'] = $getBusinessByGstin[0]->business_id;
			}

			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Data found.";
			$returnResponse['data'] = $data;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No data found.";
			$returnResponse['data'] = $getData;
		}

		/*view()->share('data',$returnResponse);
		$pdf = PDF::loadView('purchase.printAdvancePayment');

		if($request->has('download')){
			$pdf = PDF::loadView('purchase.printAdvancePayment');
			return $pdf->download('Advance-Payment.pdf');
		}
		return $pdf->stream('Advance-Payment.pdf');
		return view('purchase.printAdvancePayment');*/
		return view('purchase.printAdvancePayment')->with('data', $returnResponse);
	}



	public function editAdvancePayment($id,$gstin_id){
		$receipt_no = decrypt($id);
		$gstin_id = decrypt($gstin_id);
		$getData = Purchase::getAdvanceReceiptData($receipt_no,$gstin_id);

		if (sizeof($getData) > 0) {
			$getInvoiceDetail = Purchase::getInvoiceDetail($getData[0]->payment_no,$getData[0]->gstin_id);
			$getBusinessByGstin = Purchase::getBusinessByGstin($getData[0]->gstin_id);
			$getGstinInfo = Purchase::getGstinInfo($getData[0]->gstin_id);
			$getUnit = Purchase::getUnit();
			if(sizeof($getGstinInfo) > 0){
				$returnResponse['state_code'] = $getGstinInfo[0]->state_code;
				$returnResponse['state_name'] = $getGstinInfo[0]->state_name;
			}

			$data = array();
			$data['invoice_data'] = $getData;
			$data['invoice_details'] = $getInvoiceDetail;
			$data['units'] = $getUnit;

			if(sizeof($getBusinessByGstin) > 0){
				$returnResponse['business_id'] = $getBusinessByGstin[0]->business_id;
			}

			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Data found.";
			$returnResponse['data'] = $data;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No data found.";
			$returnResponse['data'] = $getData;
		}
		return view('purchase.editAdvancePayment')->with('data', $returnResponse);
	}



	public function updateAdvancePayment(Request $request,$ap_id){
		$input = $request->all();

		$advanceReceiptData = array();
		$advanceReceiptData['gstin_id'] = $input['gstin_id'];
		$advanceReceiptData['payment_no'] = $input['payment_no'];
		$advanceReceiptData['payment_date'] = $input['payment_date'];
		$advanceReceiptData['contact_gstin'] = $input['contact_gstin'];
		$advanceReceiptData['place_of_supply'] = $input['place_of_supply'];
		$advanceReceiptData['contact_name'] = $input['contact_name'];
		$advanceReceiptData['total_discount'] = isset($input['total_discount']) ? $input['total_discount'] : "0";
		$advanceReceiptData['total_cgst_amount'] = isset($input['total_cgst_amount']) ? $input['total_cgst_amount'] : "0";
		$advanceReceiptData['total_sgst_amount'] = isset($input['total_sgst_amount']) ? $input['total_sgst_amount'] : "0";
		$advanceReceiptData['total_igst_amount'] = isset($input['total_igst_amount']) ? $input['total_igst_amount'] : "0";
		$advanceReceiptData['total_cess_amount'] = isset($input['total_cess_amount']) ? $input['total_cess_amount'] : "0";
		if(isset($input['tax_type_applied']) && $input['tax_type_applied'] == "on"){
			$advanceReceiptData['tax_type_applied'] = '1';
		}else{
			$advanceReceiptData['tax_type_applied'] = '0';
		}
		$advanceReceiptData['tt_taxable_value'] = isset($input['tt_taxable_value']) ? $input['tt_taxable_value'] : "0";
		$advanceReceiptData['tt_cgst_amount'] = isset($input['tt_cgst_amount']) ? $input['tt_cgst_amount'] : "0";
		$advanceReceiptData['tt_sgst_amount'] = isset($input['tt_sgst_amount']) ? $input['tt_sgst_amount'] : "0";
		$advanceReceiptData['tt_igst_amount'] = isset($input['tt_igst_amount']) ? $input['tt_igst_amount'] : "0";
		$advanceReceiptData['tt_cess_amount'] = isset($input['tt_cess_amount']) ? $input['tt_cess_amount'] : "0";
		$advanceReceiptData['tt_total'] = isset($input['tt_total']) ? $input['tt_total'] : "0";
		if(isset($input['is_freight_charge']) && $input['is_freight_charge'] == "on"){
			$advanceReceiptData['is_freight_charge'] = '1';
		}else{
			$advanceReceiptData['is_freight_charge'] = '0';
		}
		$advanceReceiptData['freight_charge'] = isset($input['freight_charge']) ? $input['freight_charge'] : "0";
		if(isset($input['is_lp_charge']) && $input['is_lp_charge'] == "on"){
			$advanceReceiptData['is_lp_charge'] = '1';
		}else{
			$advanceReceiptData['is_lp_charge'] = '0';
		}
		$advanceReceiptData['lp_charge'] = isset($input['lp_charge']) ? $input['lp_charge'] : "0";
		if(isset($input['is_insurance_charge']) && $input['is_insurance_charge'] == "on"){
			$advanceReceiptData['is_insurance_charge'] = '1';
		}else{
			$advanceReceiptData['is_insurance_charge'] = '0';
		}
		$advanceReceiptData['insurance_charge'] = isset($input['insurance_charge']) ? $input['insurance_charge'] : "0";
		if(isset($input['is_other_charge']) && $input['is_other_charge'] == "on"){
			$advanceReceiptData['is_other_charge'] = '1';
		}else{
			$advanceReceiptData['is_other_charge'] = '0';
		}
		$advanceReceiptData['other_charge'] = isset($input['other_charge']) ? $input['other_charge'] : "0";
		$advanceReceiptData['other_charge_name'] = isset($input['other_charge_name']) ? $input['other_charge_name'] : "";
		$advanceReceiptData['total_amount'] = $input['total_amount'];
		if(isset($input['is_roundoff']) && $input['is_roundoff'] == "on"){
			$advanceReceiptData['is_roundoff'] = '1';
		}else{
			$advanceReceiptData['is_roundoff'] = '0';
		}
		$advanceReceiptData['roundoff'] = isset($input['roundoff']) ? $input['roundoff'] : "0";
		$advanceReceiptData['total_in_words'] = $input['total_in_words'];
		$advanceReceiptData['total_tax'] = $input['total_tax'];
		$advanceReceiptData['grand_total'] = $input['grand_total'];
		
		$insertCdnote = Purchase::updateAdvanceReceipt($advanceReceiptData,$ap_id);

		$invoiceDetailData = array();
		$deleteReceiptDetailByArId = Purchase::deleteReceiptDetailByArId($input['payment_no']);

		if(is_array($input['total'])){
			foreach ($input['total'] as $key => $value) {
				$invoiceDetailData['gstin_id'] = $input['gstin_id'];
				$invoiceDetailData['invoice_no'] = $input['payment_no'];
				$invoiceDetailData['invoice_type'] = '6';
				$invoiceDetailData['item_name'] = $input['item_name'][$key];
				$invoiceDetailData['unit'] = $input['unit'][$key];
				$invoiceDetailData['item_value'] = $input['item_value'][$key];
				$invoiceDetailData['item_type'] = "Goods";
				$invoiceDetailData['hsn_sac_no'] = $input['hsn_sac_no'][$key];
				$invoiceDetailData['quantity'] = $input['quantity'][$key];
				$invoiceDetailData['rate'] = $input['rate'][$key];
				$invoiceDetailData['discount'] = $input['discount'][$key];
				$invoiceDetailData['cgst_percentage'] = isset($input['cgst_percentage'][$key]) ? $input['cgst_percentage'][$key] : "0";
				$invoiceDetailData['cgst_amount'] = isset($input['cgst_amount'][$key]) ? $input['cgst_amount'][$key] : "0";
				$invoiceDetailData['sgst_percentage'] = isset($input['sgst_percentage'][$key]) ? $input['sgst_percentage'][$key] : "0";
				$invoiceDetailData['sgst_amount'] = isset($input['sgst_amount'][$key]) ? $input['sgst_amount'][$key] : "0";
				$invoiceDetailData['igst_percentage'] = isset($input['igst_percentage'][$key]) ? $input['igst_percentage'][$key] : "0";
				$invoiceDetailData['igst_amount'] = isset($input['igst_amount'][$key]) ? $input['igst_amount'][$key] : "0";
				$invoiceDetailData['cess_percentage'] = isset($input['cess_percentage'][$key]) ? $input['cess_percentage'][$key] : "0";
				$invoiceDetailData['cess_amount'] = isset($input['cess_amount'][$key]) ? $input['cess_amount'][$key] : "0";
				$invoiceDetailData['total'] = $input['total'][$key];
				$insertInvoiceDetails = Purchase::insertInvoiceDetails($invoiceDetailData);
			}
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "201";
			$returnResponse['message'] = "Receipt updated successfully.";
			$returnResponse['data'] = $insertCdnote;
			return $returnResponse;
		}else{
			$invoiceDetailData['gstin_id'] = $input['gstin_id'];
			$invoiceDetailData['invoice_no'] = $input['payment_no'];
			$invoiceDetailData['invoice_type'] = '6';
			$invoiceDetailData['item_name'] = $input['item_name'];
			$invoiceDetailData['item_type'] = "Goods";
			$invoiceDetailData['unit'] = $input['unit'];
			$invoiceDetailData['hsn_sac_no'] = $input['hsn_sac_no'];
			$invoiceDetailData['quantity'] = $input['quantity'];
			$invoiceDetailData['rate'] = $input['rate'];
			$invoiceDetailData['discount'] = $input['discount'];
			$invoiceDetailData['cgst_percentage'] = isset($input['cgst_percentage']) ? $input['cgst_percentage'] : "0";
			$invoiceDetailData['cgst_amount'] = isset($input['cgst_amount']) ? $input['cgst_amount'] : "0";
			$invoiceDetailData['sgst_percentage'] = isset($input['sgst_percentage']) ? $input['sgst_percentage'] : "0";
			$invoiceDetailData['sgst_amount'] = isset($input['sgst_amount']) ? $input['sgst_amount'] : "0";
			$invoiceDetailData['igst_percentage'] = isset($input['igst_percentage']) ? $input['igst_percentage'] : "0";
			$invoiceDetailData['igst_amount'] = isset($input['igst_amount']) ? $input['igst_amount'] : "0";
			$invoiceDetailData['cess_percentage'] = isset($input['cess_percentage']) ? $input['cess_percentage'] : "0";
			$invoiceDetailData['cess_amount'] = isset($input['cess_amount']) ? $input['cess_amount'] : "0";
			$invoiceDetailData['total'] = $input['total'];
			$insertInvoiceDetails = Purchase::insertInvoiceDetails($invoiceDetailData);

			$returnResponse['status'] = "success";
			$returnResponse['code'] = "201";
			$returnResponse['message'] = "Receipt updated successfully.";
			$returnResponse['data'] = $insertCdnote;
			return $returnResponse;
		}
		return $returnResponse;
	}


}
