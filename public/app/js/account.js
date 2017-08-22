$(function(){

	if (typeof $.cookie('token') === 'undefined' && typeof $.cookie('tokenId') === 'undefined'){
	} else {
		window.location.href = SERVER_NAME+"/welcome";
	}

	$('#register').click(function(){
		registration();
	});

	$('#loginButton').click(function(){
		login();
	});

	$('#forgotButton').click(function(){
		forgotpassword();
	});

	$('#resetButton').click(function(){
		updatepassword();
	});

	//REGISTRATION VALIDATION     
	$("#signupForm").validate({
		rules: {    
			password:{
				required: true,
			},
			confirm_password:{
				required: true,
			},
			email: {
				required: true,
				email: true
			},
		},
		messages: {    
			password:"Please enter password.",
			confirm_password:"Please enter confirm password.",
			email: {
				required: "Please enter a valid email address",
			},
		}
	});


    //LOGIN VALIDATION     
    $("#loginForm").validate({
    	rules: {    
    		password:{
    			required: true,
    		},
    		email: {
    			required: true,
    			email: true
    		},
    	},
    	messages: {    
    		password:"Please enter password.",
    		email: {
    			required: "Please enter a valid email address",
    		},
    	}
    });

    //FORGOT PASSWORD VALIDATION     
    $("#forgotForm").validate({
    	rules: {    
    		email: {
    			required: true,
    			email: true
    		},
    	},
    	messages: {    
    		email: {
    			required: "Please enter a valid email address",
    		},
    	}
    });

    //RESET PASSWORD VALIDATION     
	$("#resetForm").validate({
		rules: {    
			password:{
				required: true,
			},
			confirm_password:{
				required: true,
			},
		},
		messages: {    
			password:"Please enter password.",
			confirm_password:"Please enter confirm password.",
		}
	});

});


function registration(){

	var flag = true;
	flag = $("#signupForm").valid();
	if(flag==false){
		return false;
	}

	var password = $('#password').val();
	var confirm_password = $('#confirm_password').val();

	if(password != confirm_password){
		swal({
			text : 'Password and confirm password should be same.',
			type : 'warning'
		});
		return false;
	}

	var data = JSON.stringify($("#signupForm").serializeFormJSON());

	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/signup",
		type:"POST",

		"headers": {
			"content-type": "application/json",
			"cache-control": "no-cache",
			"postman-token": "5d6d42d9-9cdb-e834-6366-d217b8e77f59"
		},
		"processData": false,
		"data":data,
		"dataType":"JSON",
		beforeSend:function(){
			$("#register").prop('disabled', true).text('Please Wait...');
		},
		success:function(response){
			if(response.code == 201){
				swal({
					title: "Thank You!",
					text: response.message,
					type: "success",
					confirmButtonText: "OK",
					width:'400px',
				}).then(function () {
					window.location.href = "/login";
				});
			}else{
				swal({
					title: "Failed!",
					text: response.message,
					type: "error",
					confirmButtonText: "Close",
				});
			}
		},
		complete:function(){
			$("#register").prop('disabled', false).text('Join Now');
		}
	});
}



function login(){

	var flag = true;
	flag = $("#loginForm").valid();
	if(flag==false){
		return false;
	}

	var data = JSON.stringify($("#loginForm").serializeFormJSON());

	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/login",
		type:"POST",

		"headers": {
			"content-type": "application/json",
			"cache-control": "no-cache",
			"postman-token": "5d6d42d9-9cdb-e834-6366-d217b8e77f59"
		},
		"processData": false,
		"data":data,
		"dataType":"JSON",
		beforeSend:function(){
			$("#loginButton").prop('disabled', true).text('Please Wait...');
		},
		success:function(response){
			
			if(response.code == 200){
				$.removeCookie("token", { path: '/' });
				$.removeCookie("tokenId", { path: '/' });
				$.removeCookie("tokenEmail", { path: '/' });

				$.removeCookie("token");
				$.removeCookie("tokenId");
				$.removeCookie("tokenEmail");

				var date = new Date();
				var minutes = 60;
				date.setTime(date.getTime() + (minutes * 60 * 1000));

				$.cookie("token", response.data[0]['remember_token'],{
					expires : date
				});
				$.cookie("tokenId", response.data[0]['user_id'],{
					expires : date
				});
				$.cookie("tokenEmail", response.data[0]['email'],{
					expires : date
				});

				swal({
					title: "Welcome!",
					text: response.message,
					type: "success",
					confirmButtonText: "OK",
					width:'400px',
				}).then(function () {
					window.location.href = "/welcome";
					$('#loginForm')[0].reset();
				});
			}else{
				swal({
					title: "Failed!",
					text: response.message,
					type: "error",
					confirmButtonText: "Close",
				});
			}
		},
		complete:function(){
			$("#loginButton").prop('disabled', false).text('Login');
		}
	});
}



function forgotpassword(){

	var flag = true;
	flag = $("#forgotForm").valid();
	if(flag==false){
		return false;
	}

	var data = JSON.stringify($("#forgotForm").serializeFormJSON());

	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/forgotpassword",
		type:"POST",

		"headers": {
			"content-type": "application/json",
			"cache-control": "no-cache",
			"postman-token": "5d6d42d9-9cdb-e834-6366-d217b8e77f59"
		},
		"processData": false,
		"data":data,
		"dataType":"JSON",
		beforeSend:function(){
			$("#forgotButton").prop('disabled', true).text('Please Wait...');
		},
		success:function(response){
			if(response.code == 200){
				swal({
					text: response.message,
					type: "success",
					confirmButtonText: "OK",
					width:'400px',
				}).then(function () {
					window.location.href = "/login";
					$('#loginForm')[0].reset();
				});
			}else{
				swal({
					title: "Failed!",
					text: response.message,
					type: "error",
					confirmButtonText: "Close",
				});
			}
		},
		complete:function(){
			$("#forgotButton").prop('disabled', false).text('Submit');
		}
	});
}



function updatepassword(){

	var flag = true;
	flag = $("#resetForm").valid();
	if(flag==false){
		return false;
	}

	var password = $('#password').val();
	var confirm_password = $('#confirm_password').val();

	if(password != confirm_password){
		swal({
			text : 'Password and confirm password should be same.',
			type : 'warning'
		});
		return false;
	}

	var data = JSON.stringify($("#resetForm").serializeFormJSON());
	var user_id = $("#user_id").val();

	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/updatepassword/"+user_id,
		type:"POST",
		"headers": {
			"content-type": "application/json",
			"cache-control": "no-cache",
			"postman-token": "5d6d42d9-9cdb-e834-6366-d217b8e77f59"
		},
		"processData": false,
		"data":data,
		"dataType":"JSON",
		beforeSend:function(){
			$("#updateCustomer").prop('disabled', true).text('Updating, Please Wait...');
		},
		success:function(response){
			if(response.code == 200){
				swal({
					title: "Success !",
					text: response.message,
					type: "success",
					confirmButtonText: "OK",
					width:'400px',
				}).then(function () {
					window.location.href = SERVER_NAME+"/login";
				});
			}else{
				swal({
					title: "Failed!",
					text: response.message,
					type: "error",
					confirmButtonText: "Close",
				});
			}
		},
		complete:function(){
			$("#updateCustomer").prop('disabled', false).text('Update');
		}
	});
}