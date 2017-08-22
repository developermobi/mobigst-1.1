<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;
use App\Http\Requests;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use League\Csv\Reader;
use File;
use Mail;
use App\Gst;
use Session;
use View;
use DB;


class GstController extends Controller{



	public function signup(Request $request){
		$input = $request->all();

		$data = array();
		$data['email'] = $input['email'];
		$data['password'] = $input['password'];

		$mail_available = Gst::mail_available($input['email']);
		
		if(sizeof($mail_available) > 0){
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "302";
			$returnResponse['message'] = "Email address already exists. Please enter another email address. ";
			$returnResponse['data'] = $mail_available;
		}else{
			$addUser = Gst::addUser($data);

			if($addUser > 0){

				$mailInfo = array();
				$mailInfo['user_id'] = $addUser;
				$mailInfo['email'] = $input['email'];
				$mail = Mail::send('gst.verifyMail',['mailInfo' => $mailInfo], function($message) use ($mailInfo){
					$message->from('no-reply@mobisofttech.co.in', 'Mobi GST');
					$message->to($mailInfo['email'])->subject('MobiGST - Verification Link');
				});

				$returnResponse['status'] = "success";
				$returnResponse['code'] = "201";
				$returnResponse['message'] = "You have signed up Sucessfully. We have sent verification mail on your email id. Please verify your account before login.";
				$returnResponse['data'] = $addUser;
			}else{
				$returnResponse['status'] = "failed";
				$returnResponse['code'] = "400";
				$returnResponse['message'] = "Error while signing up. Please try again.";
				$returnResponse['data'] = $addUser;
			}
		}
		return response()->json($returnResponse);
	}



	public function verifyMail($id){
		$user_id = decrypt($id);
		$getData = Gst::verifyMail($user_id);
		
		if (sizeof($getData) > 0) {
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Data found.";
			$returnResponse['data'] = $getData;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "Link expired. Please try again.";
			$returnResponse['data'] = $getData;
		}
		return view('gst.mailVerification')->with('data', $returnResponse);
	}



	public function viewUsers(){
		$viewUsers = Gst::viewUsers();

		if($viewUsers > 0){
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "All users.";
			$returnResponse['data'] = $viewUsers;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No users found.";
			$returnResponse['data'] = $viewUsers;
		}
		return response()->json($returnResponse);
	}



	public function updateUser(Request $request, $id){
		$input = $request->all();

		$updateUser = Gst::updateUser($input,$id);

		if($updateUser > 0){
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "User updated successfully.";
			$returnResponse['data'] = $updateUser;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "Not updated.";
			$returnResponse['data'] = $updateUser;
		}
		return response()->json($returnResponse);
	}



	public function login(Request $request){
		$input = $request->all();
		
		$login = Gst::login($input);

		if(sizeof($login) > 0){
			if($login[0]->verify_mail == '1'){
				Session::regenerate();

				$data['remember_token'] = Session::getId();
				$data['user_id'] = $login[0]->user_id; 

				$UpdateToken = Gst::updateUserToken($data);

				if($UpdateToken > 0){
					$login = Gst::login($input);

					$returnResponse['status'] = "success";
					$returnResponse['code'] = "200";
					$returnResponse['message'] = "You have logged in Sucessfully.";
					$returnResponse['data'] = $login;
				}else{
					$returnResponse['status'] = "failed";
					$returnResponse['code'] = "204";
					$returnResponse['message'] = "Session not generated. Please try again.";
					$returnResponse['data'] = $login;
				}
				return response()->json($returnResponse);
			}else{
				$returnResponse['status'] = "failed";
				$returnResponse['code'] = "204";
				$returnResponse['message'] = "You have not verified your account. Please check your registered email id for verification link.";
				$returnResponse['data'] = $login;
			}
		}else{
			$returnResponse['status'] = "failed";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "Email or password is incorrect.";
			$returnResponse['data'] = $login;
		}
		return response()->json($returnResponse);
	}



	public function forgotpassword(Request $request){
		$input = $request->all();

		$findemsilid = Gst::findemsilid($input);

		if(sizeof($findemsilid) > 0){

			$data['forget_password_id'] = substr(md5(mt_rand()), 5, 20);
			$data['user_id'] = $findemsilid[0]->user_id; 

			$updateForgetPasswordId = Gst::updateForgetPasswordId($data);

			if($updateForgetPasswordId > 0){

				$getUserData = Gst::getUserData($findemsilid[0]->user_id);

				$mailInfo = array();
				$mailInfo['email'] = $input['email'];
				$mailInfo['user_id'] = $getUserData[0]->user_id;
				$mailInfo['forget_password_id'] = $getUserData[0]->forget_password_id;
				$mail = Mail::send('gst.forgotPasswordMail',['mailInfo' => $mailInfo], function($message) use ($mailInfo){
					$message->from('no-reply@mobisofttech.co.in', 'Mobi GST');
					$message->to($mailInfo['email'])->subject('MobiGST - Reset Password Link');
					$message->cc('prajwal.p@mobisofttech.co.in');
				});
				if($mail != ''){
					$returnResponse['status'] = "success";
					$returnResponse['code'] = "200";
					$returnResponse['message'] = "Password reset link sent to your email id.";
					$returnResponse['data'] = $findemsilid;
				}else{
					$returnResponse['status'] = "failed";
					$returnResponse['code'] = "204";
					$returnResponse['message'] = "Something went wrong while sending mail. Please try again.";
					$returnResponse['data'] = $findemsilid;
				}
			}else{
				$returnResponse['status'] = "failed";
				$returnResponse['code'] = "204";
				$returnResponse['message'] = "Something went wrong while sending mail. Please try again.";
				$returnResponse['data'] = $findemsilid;
			}
		}else{
			$returnResponse['status'] = "failed";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "Your email id is not registered with us. First sign Up.";
			$returnResponse['data'] = $findemsilid;
		}
		return response()->json($returnResponse);
	}



	public function resetPassword($id,$forget_password_id){
		$user_id = decrypt($id);
		$getData = Gst::getUserDataFP($user_id,$forget_password_id);

		if (sizeof($getData) > 0) {
			$data['forget_password_id'] = substr(md5(mt_rand()), 5, 20);
			$data['user_id'] = $user_id; 

			$updateForgetPasswordId = Gst::updateForgetPasswordId($data);

			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Data found.";
			$returnResponse['data'] = $getData;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "Link expired. Please try again.";
			$returnResponse['data'] = $getData;
		}
		return view('gst.resetPassword')->with('data', $returnResponse);
	}



	public function updatepassword(Request $request, $id){
		$input = $request->all();

		$updatepassword = Gst::updatepassword($input['password'],$id);

		if($updatepassword > 0){
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Password updated successfully.";
			$returnResponse['data'] = $updatepassword;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "Not updated.";
			$returnResponse['data'] = $updatepassword;
		}
		return response()->json($returnResponse);
	}



	public function logout(Request $request){
		$input = $request->all();

		$logout = Gst::logout($input);

		if(sizeof($logout) > 0){

			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "You have logged out Sucessfully.";
			$returnResponse['data'] = $logout;
		}else{
			$returnResponse['status'] = "failed";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "Something went wrong. Plaese try again.";
			$returnResponse['data'] = $logout;
		}
		return response()->json($returnResponse);
	}



	public function business(Request $request){
		$user_id = $request->cookie('tokenId');

		$business =  Gst::business($user_id);

		if (sizeof($business) > 0) {
			foreach ($business as $key => $value) {
				$gstin = Gst::gstin($business[$key]->business_id);
				$business[$key]->details = $gstin;
			}
		}else{
			$data['status'] = "success";
			$data['code'] = "204";
			$data['message'] = "No data found.";
			$data['data'] = '';
		}
		return view('gst.business')->with('data', $business);
	}



	public function addBusiness(Request $request){
		$input = $request->all();

		$stateCode = substr($input['gstin_no'], 0, 2);
		$getStateInfo = Gst::getStateInfo($stateCode);

		if(sizeof($getStateInfo) > 0){
			$business_data = array();
			$business_data['user_id'] = $request->cookie('tokenId');
			$business_data['name'] = $input['name'];
			$business_data['pan'] = $input['pan_no'];

			$addBusiness = Gst::addBusiness($business_data);

			if($addBusiness > 0){

				$gstin_data = array();
				$gstin_data['business_id'] = $addBusiness;
				$gstin_data['gstin_no'] = $input['gstin_no'];
				$gstin_data['display_name'] = $input['display_name'];
				$gstin_data['state_code'] = $getStateInfo[0]->state_code;
				$gstin_data['state_name'] = $getStateInfo[0]->state_name;

				$addBusiness = Gst::addGstin($gstin_data);

				if($addBusiness > 0){
					$returnResponse['status'] = "success";
					$returnResponse['code'] = "201";
					$returnResponse['message'] = "Business added Sucessfully.";
					$returnResponse['data'] = $addBusiness;
				}else{
					$returnResponse['status'] = "failed";
					$returnResponse['code'] = "302";
					$returnResponse['message'] = "Error while adding business. Please try again.";
					$returnResponse['data'] = $addBusiness;
				}
			}else{
				$returnResponse['status'] = "failed";
				$returnResponse['code'] = "302";
				$returnResponse['message'] = "Error while adding business. Please try again.";
				$returnResponse['data'] = $addUser;
			}
		}else{
			$returnResponse['status'] = "failed";
			$returnResponse['code'] = "302";
			$returnResponse['message'] = "GSTIN number is not valid. Plaese check your gstin number.";
			$returnResponse['data'] = '';
		}
		return response()->json($returnResponse);
	}



	public function addGstin(Request $request){
		$input = $request->all();

		$stateCode = substr($input['gstin_no'], 0, 2);
		$getStateInfo = Gst::getStateInfo($stateCode);
		
		if(sizeof($getStateInfo) > 0){
			$input['state_name'] = $getStateInfo[0]->state_name;
			$input['state_code'] = $getStateInfo[0]->state_code;
			$addGstin = Gst::addGstin($input);

			if($addGstin > 0){
				$returnResponse['status'] = "success";
				$returnResponse['code'] = "201";
				$returnResponse['message'] = "GSTIN number added Sucessfully.";
				$returnResponse['data'] = $addGstin;
			}else{
				$returnResponse['status'] = "failed";
				$returnResponse['code'] = "302";
				$returnResponse['message'] = "Error while adding gstin no. Please try again.";
				$returnResponse['data'] = $addGstin;
			}
		}else{
			$returnResponse['status'] = "failed";
			$returnResponse['code'] = "302";
			$returnResponse['message'] = "GSTIN number is not valid. Plaese check your gstin number.";
			$returnResponse['data'] = '';
		}
		return response()->json($returnResponse);
	}



	public function setting(Request $request){
		$user_id = $request->cookie('tokenId');

		$business =  Gst::business($user_id);

		if (sizeof($business) > 0) {
			$data['status'] = "success";
			$data['code'] = "200";
			$data['message'] = "Data found.";
			$data['data'] = $business;
		}else{
			$data['status'] = "success";
			$data['code'] = "204";
			$data['message'] = "No data found.";
			$data['data'] = '';
		}
		
		return view('gst.setting')->with('data', $data);
	}



	public function getBusinessData($id){
		$getData = Gst::getBusinessData($id);

		if (sizeof($getData) > 0) {
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Data found.";
			$returnResponse['data'] = $getData;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No data found.";
			$returnResponse['data'] = $getData;
		}
		return response()->json($returnResponse);
	}



	public function updateBusiness(Request $requestData,$id){
		$input = $requestData->all();

		$updateBusiness = Gst::updateBusiness($input,$id);

		if($updateBusiness > 0){
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Business details updated successfully.";
			$returnResponse['data'] = $updateBusiness;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "Not updated.";
			$returnResponse['data'] = $updateBusiness;
		}
		return response()->json($returnResponse);
	}



	public function deleteBusiness($id){
		$getData = Gst::deleteBusiness($id);

		if (sizeof($getData) > 0) {
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Business deleted successfully.";
			$returnResponse['data'] = $getData;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "Something went wrong while deleting business.";
			$returnResponse['data'] = $getData;
		}
		return response()->json($returnResponse);
	}



	public function getBusinessGstin($id){
		$business_id = decrypt($id);
		$getData = Gst::gstin($business_id);

		if (sizeof($getData) > 0) {
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Data found.";
			$returnResponse['data'] = $getData;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No data found.";
			$returnResponse['data'] = $getData;
		}
		return view('gst.gstin')->with('data', $returnResponse);
	}



	public function getGstinData($id){
		$getData = Gst::getGstinData($id);

		if (sizeof($getData) > 0) {
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Data found.";
			$returnResponse['data'] = $getData;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No data found.";
			$returnResponse['data'] = $getData;
		}
		return response()->json($returnResponse);
	}



	public function updateGstin(Request $requestData,$id){
		$input = $requestData->all();

		$updateGstin = Gst::updateGstin($input,$id);

		if($updateGstin > 0){
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "GSTIN details updated successfully.";
			$returnResponse['data'] = $updateGstin;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "Not updated.";
			$returnResponse['data'] = $updateGstin;
		}
		return response()->json($returnResponse);
	}



	public function deleteGstin($id){
		$getData = Gst::deleteGstin($id);

		if (sizeof($getData) > 0) {
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "GSTIN deleted successfully.";
			$returnResponse['data'] = $getData;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "Something went wrong while deleting GSTIN.";
			$returnResponse['data'] = $getData;
		}
		return response()->json($returnResponse);
	}



	public function getBusiness(Request $request){
		$user_id = $request->cookie('tokenId');

		$business =  Gst::business($user_id);

		if (sizeof($business) > 0) {
			$data['status'] = "success";
			$data['code'] = "200";
			$data['message'] = "Data found.";
			$data['data'] = $business;
		}else{
			$data['status'] = "success";
			$data['code'] = "204";
			$data['message'] = "No data found.";
			$data['data'] = '';
		}
		
		return response()->json($data);
	}



	public function importContactFile(Request $request){	

		$input = $request->all();
		try{
			if(isset($input['contact_csv'])){

				$file1 = $input['contact_csv'];

				$file_name1 = basename($file1->getClientOriginalName(), '.'.$file1->getClientOriginalExtension());
				$fileName1 = $file_name1.time().'.'.$file1->getClientOriginalExtension();
				$fileName1 = str_replace(' ', '', $fileName1);
				$fileName1 = preg_replace('/\s+/', '', $fileName1);
				$file_upload1 = $file1->move(
					base_path() . '/public/Contact/', $fileName1
					);
				$fileName['contact_csv'] = $file1;
				$input['contact_csv']=$file1;
			}
			$full_url = base_path() . '/public/Contact/'.$fileName1;
			$csv = Reader::createFromPath($full_url);

			$headers = $csv->fetchOne();

			$res = $csv->setOffset(1)->fetchAll();
			$key_value=array();

			foreach($res as $key => $val){
				$key_value[$key]['business_id'] = $input['business_id'];
				$key_value[$key]['unique_id'] = $res[$key][0];
				$key_value[$key]['contact_type'] = $res[$key][1];
				$key_value[$key]['contact_name'] = $res[$key][2];
				$key_value[$key]['gstin_no'] = $res[$key][3];
				$key_value[$key]['contact_person'] = $res[$key][4];
				$key_value[$key]['email'] = $res[$key][5];
				$key_value[$key]['pan_no'] = $res[$key][6];
				$key_value[$key]['phone_no'] = $res[$key][7];
				$key_value[$key]['alternate_no'] = $res[$key][8];
				$key_value[$key]['address'] = $res[$key][9];
				$key_value[$key]['city'] = $res[$key][10];
				$key_value[$key]['state'] = $res[$key][11];
				$key_value[$key]['pincode'] = $res[$key][12];
				$key_value[$key]['created_at'] = date('Y-m-d H:i:s');
			}

			$states = Gst::getStates();
			$name = array();
			foreach ($states as $key => $value) {
				array_push($name,$value->state_name);
			}

			/*CHECK STATE NAME*/
			foreach($res as $key => $val){
				if (in_array($res[$key][11], $name)) {

				}else{
					$response['status'] = "fail";
					$response['code'] = 400;
					$a = 'L'. ($key+2);
					$response['message'] = "You have error on cell number " . $a . " of your csv. Please write correct state name.";
					$response['data'] = $val;
					return view('gst.importContactMsg')->with('data', $response);
				}
			}

			/*CHECK GSTIN*/
			foreach($res as $key => $val){
				$validateGstin = Gst::checkGstin($res[$key][3]);
				if ($validateGstin > 0) {

				}else{
					$response['status'] = "fail";
					$response['code'] = 400;
					$a = 'D'. ($key+2);
					$response['message'] = "You have error on cell number " . $a . " of your csv. Please check your GSTIN.";
					$response['data'] = $val;
					return view('gst.importContactMsg')->with('data', $response);
				}
			}

			/*CHECK PAN*/
			foreach($res as $key => $val){
				$validatePan = Gst::checkPan($res[$key][6]);
				if ($validatePan > 0) {

				}else{
					$response['status'] = "fail";
					$response['code'] = 400;
					$a = 'G'. ($key+2);
					$response['message'] = "You have error on cell number " . $a . " of your csv. Please check your PAN.";
					$response['data'] = $val;
					return view('gst.importContactMsg')->with('data', $response);
				}
			}

			$collection = collect($key_value); 
			$infoFileInsertedData = Gst::addContactFromCSV($collection->toArray());

			if($infoFileInsertedData){
				$response['numbers'] = sizeof($collection);
				$response['status'] = "success";
				$response['code'] = 200;
				$response['message'] = "OK";
				$response['data'] = $infoFileInsertedData;
				$response['end_time'] = date("h:i:sa");
				unlink($full_url);
			}else{
				$response['numbers'] = sizeof($collection);
				$response['status'] = "fail";
				$response['code'] = 400;
				$response['message'] = "Something went wrong while uploading file. Please try again.";
				$response['data'] = $infoFileInsertedData;
				unlink($full_url);
			}
			return view('gst.importContactMsg')->with('data', $response);
		}catch (\Exception $e){
			return \Redirect::to('importError');
		} 
	}



	public function addCustomer(Request $request){
		$input = $request->all();
		$addCustomer = Gst::addCustomer($input);
		
		if($addCustomer > 0){
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "201";
			$returnResponse['message'] = "Customer added Sucessfully.";
			$returnResponse['data'] = $addCustomer;
		}else{
			$returnResponse['status'] = "failed";
			$returnResponse['code'] = "302";
			$returnResponse['message'] = "Error while adding customer. Please try again.";
			$returnResponse['data'] = $addCustomer;
		}
		return response()->json($returnResponse);
	}



	public function customerInfo($id){
		$contact_id = decrypt($id);
		$getData = Gst::getContactData($contact_id);

		if (sizeof($getData) > 0) {
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Data found.";
			$returnResponse['data'] = $getData;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No data found.";
			$returnResponse['data'] = $getData;
		}
		return view('gst.customerInfo')->with('data', $returnResponse);
	}



	public function contacts($id){
		$id = decrypt($id);
		$contacts =  Gst::contacts($id);
		$requested = Gst::requested($id);
		$unrequested = Gst::unrequested($id);
		$received = Gst::received($id);

		$info = array();
		$info['contacts'] = $contacts;
		$info['requested'] = $requested;
		$info['unrequested'] = $unrequested;
		$info['received'] = $received;

		if (sizeof($contacts) > 0) {
			$data['status'] = "success";
			$data['code'] = "200";
			$data['message'] = "Data found.";
			$data['data'] = $info;
		}else{
			$data['status'] = "success";
			$data['code'] = "204";
			$data['message'] = "No data found.";
			$data['data'] = '';
		}
		
		return view('gst.contacts')->with('data', $data);
	}



	public function editContact($id){
		$item = decrypt($id);
		$getData = Gst::getContactData($item);

		if (sizeof($getData) > 0) {
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Data found.";
			$returnResponse['data'] = $getData;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No data found.";
			$returnResponse['data'] = $getData;
		}
		return view('gst.editCustomer')->with('data', $returnResponse);
	}



	public function updateContact(Request $request, $id){
		$input = $request->all();

		$updateContact = Gst::updateContact($input,$id);

		if($updateContact > 0){
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "201";
			$returnResponse['message'] = "Contact updated successfully.";
			$returnResponse['data'] = $updateContact;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "Not updated.";
			$returnResponse['data'] = $updateContact;
		}
		return response()->json($returnResponse);
	}



	public function deleteContact($id){
		$getData = Gst::deleteContact($id);

		if (sizeof($getData) > 0) {
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Contact deleted successfully.";
			$returnResponse['data'] = $getData;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "Something went wrong while deleting contact.";
			$returnResponse['data'] = $getData;
		}
		return response()->json($returnResponse);
	}



	public function requestInfo($id){

		$getInfo = Gst::getContactData($id);

		if(sizeof($getInfo) > 0){
			if($getInfo[0]->email != ''){
				$mailInfo = array();
				$mailInfo['email'] = $getInfo[0]->email;
				$mailInfo['contact_id'] = $getInfo[0]->contact_id;
				$mail = Mail::send('gst.gstinMail',['mailInfo' => $mailInfo], function($message) use ($mailInfo){
					$message->from('no-reply@mobisofttech.co.in', 'Mobi GST');
					$message->to($mailInfo['email'])->subject('MobiGST Customer Mail');
					$message->cc('prajwal.p@mobisofttech.co.in');
				});
				if($mail != ''){
					$getData = Gst::requestInfo($id);
					if (sizeof($getData) > 0) {
						$returnResponse['status'] = "success";
						$returnResponse['code'] = "200";
						$returnResponse['message'] = "Request sent successfully.";
						$returnResponse['data'] = $getData;
					}else{
						$returnResponse['status'] = "success";
						$returnResponse['code'] = "204";
						$returnResponse['message'] = "Something went wrong while requesting. Please try again.";
						$returnResponse['data'] = $getData;
					}
				}
			}
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "Something went wrong while requesting. Please try again.";
			$returnResponse['data'] = $getData;
		}
		return response()->json($returnResponse);
	}



	public function importItemFile(Request $request){	

		$input = $request->all();
		try{
			if(isset($input['item_csv'])){

				$file1 = $input['item_csv'];

				$file_name1 = basename($file1->getClientOriginalName(), '.'.$file1->getClientOriginalExtension());
				$fileName1 = $file_name1.time().'.'.$file1->getClientOriginalExtension();
				$fileName1 = str_replace(' ', '', $fileName1);
				$fileName1 = preg_replace('/\s+/', '', $fileName1);
				$file_upload1 = $file1->move(
					base_path() . '/public/Contact/', $fileName1
					);
				$fileName['item_csv'] = $file1;
				$input['item_csv'] = $file1;
			}
			$full_url = base_path() . '/public/Contact/'.$fileName1;
			$csv = Reader::createFromPath($full_url);

			$headers = $csv->fetchOne();

			$res = $csv->setOffset(1)->fetchAll();
			$key_value=array();
			$group_id = 1;
			$user_id = 2;
			foreach($res as $key => $val){
				$key_value[$key]['business_id'] = $input['business_id'];
				$key_value[$key]['item_sku'] = $res[$key][0];
				$key_value[$key]['item_type'] = $res[$key][1];
				$key_value[$key]['item_hsn_sac'] = $res[$key][2];
				$key_value[$key]['item_description'] = $res[$key][3];
				$key_value[$key]['item_unit'] = $res[$key][4];
				$key_value[$key]['item_sale_price'] = $res[$key][5];
				$key_value[$key]['item_purchase_price'] = $res[$key][6];
				$key_value[$key]['item_discount'] = $res[$key][7];
				$key_value[$key]['item_notes'] = $res[$key][8];
				$key_value[$key]['created_at'] = date('Y-m-d H:i:s');
			}
			$key_value;
			$start_time = date("h:i:sa");

			$collection = collect($key_value); 
			$infoFileInsertedData = Gst::addItemFromCSV($collection->toArray());  

			if($infoFileInsertedData){
				$response['numbers'] = sizeof($collection);
				$response['status'] = "success";
				$response['code'] = 200;
				$response['message'] = "OK";
				$response['data'] = $infoFileInsertedData;
				$response['strat_time'] = $start_time;
				$response['end_time'] = date("h:i:sa");
				unlink($full_url);
			}else{
				$response['numbers'] = sizeof($collection);
				$response['status'] = "fail";
				$response['code'] = 400;
				$response['message'] = "Bad Request";
				$response['data'] = $infoFileInsertedData;
				unlink($full_url);
			}
			return view('gst.importmsg')->with('data', $response);
		}catch (\Exception $e){
			return \Redirect::to('importError');
		} 
	}



	public function addItem(Request $request){
		$input = $request->all();

		$addItem = Gst::addItem($input);

		if($addItem > 0){
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "201";
			$returnResponse['message'] = "Item added Sucessfully.";
			$returnResponse['data'] = $addItem;
		}else{
			$returnResponse['status'] = "failed";
			$returnResponse['code'] = "302";
			$returnResponse['message'] = "Error while adding item. Please try again.";
			$returnResponse['data'] = $addItem;
		}
		
		return response()->json($returnResponse);
	}



	public function editItem($id){
		$item = decrypt($id);
		$getData = Gst::getItemData($item);

		if (sizeof($getData) > 0) {
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Data found.";
			$returnResponse['data'] = $getData;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "No data found.";
			$returnResponse['data'] = $getData;
		}
		return view('gst.editItem')->with('data', $returnResponse);
	}



	public function updateItem(Request $request, $id){
		$input = $request->all();

		$updateItem = Gst::updateItem($input,$id);

		if($updateItem > 0){
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "201";
			$returnResponse['message'] = "Item updated successfully.";
			$returnResponse['data'] = $updateItem;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "Not updated.";
			$returnResponse['data'] = $updateItem;
		}
		return response()->json($returnResponse);
	}



	public function deleteItem($id){
		$getData = Gst::deleteItem($id);

		if (sizeof($getData) > 0) {
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "200";
			$returnResponse['message'] = "Item deleted successfully.";
			$returnResponse['data'] = $getData;
		}else{
			$returnResponse['status'] = "success";
			$returnResponse['code'] = "204";
			$returnResponse['message'] = "Something went wrong while deleting item.";
			$returnResponse['data'] = $getData;
		}
		return response()->json($returnResponse);
	}



	public function select($id){
		$id = $id;
		return view('gst.select')->with('data', $id);
	}


}
