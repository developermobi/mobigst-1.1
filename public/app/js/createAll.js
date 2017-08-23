$(function(){

	if (typeof $.cookie('token') === 'undefined' && typeof $.cookie('tokenId') === 'undefined'){
		window.location.href = SERVER_NAME;
	}

	$('#addCustomer').click(function(){
		addCustomer();
	});

	$('#addItem').click(function(){
		addItem();
	});

	jQuery.validator.addMethod("gstin", function(value, element) {
		return this.optional( element ) || /^([0][1-9]|[1-2][0-9]|[3][0-7])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/.test( value );
	}, 'Please enter a valid gstin number.');

	jQuery.validator.addMethod("pan", function(value, element) {
		return this.optional( element ) || /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/.test( value );
	}, 'Please enter a valid pan number.');

	$("#customerForm").validate({
		rules: {    
			pan_no:{
				required: true,
				pan:true,
			},
			gstin_no:{
				required: true,
				gstin:true,
			},
			email:{
				required: true,
			},
			mobile_no:{
				required: true,
			},
		},
		messages: {    
			pan_no:"Please enter pan no.",
			gstin_no:"Please enter valid gstin no.",
			email:"Please enter email.",
			mobile_no:"Please enter phone no.",
		}
	});

	$("#itemForm").validate({
		rules: {    
			business_id:{
				required: true,
			},
			item_description:{
				required: true,
			},
			item_sale_price:{
				required: true,
			},
		},
		messages: {    
			business_id:"Please select business.",
			item_description:"Please enter item description.",
			item_sale_price:"Please enter item sale price.",
		}
	});

});



function addCustomer(){

	var flag = true;
	flag = $("#customerForm").valid();
	if(flag==false){
		return false;
	}

	var data = JSON.stringify($("#customerForm").serializeFormJSON());

	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/addCustomer",
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
			$("#addCustomer").prop('disabled', true).text('Adding, Please Wait...');
		},
		success:function(response){
			if(response.code == 201){
				swal({
					title: "Success !",
					text: response.message,
					type: "success",
					confirmButtonText: "OK",
					width:'400px',
				}).then(function () {
					window.location.href = window.location.href;
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
			$("#addCustomer").prop('disabled', false).text('Save');
		}
	});
}



function addItem(){

	var flag = true;
	flag = $("#itemForm").valid();
	if(flag==false){
		return false;
	}

	var data = JSON.stringify($("#itemForm").serializeFormJSON());

	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/addItem",
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
			$("#addItem").prop('disabled', true).text('Adding, Please Wait...');
		},
		success:function(response){
			if(response.code == 201){
				swal({
					title: "Success !",
					text: response.message,
					type: "success",
					confirmButtonText: "OK",
					width:'400px',
				}).then(function () {
					window.location.href = window.location.href;
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
			$("#addItem").prop('disabled', false).text('Save');
		}
	});
}