$(function(){

	getBusiness();

	if (typeof $.cookie('token') === 'undefined' && typeof $.cookie('tokenId') === 'undefined'){
		window.location.href = SERVER_NAME;
	}

	$('#addCustomer').click(function(){
		addCustomer();
	});

	$('#updateCustomer').click(function(){
		updateCustomer();
	});

	$('#updateCustomerInfo').click(function(){
		updateCustomerInfo();
	});

	jQuery.validator.addMethod("gstin", function(value, element) {
		return this.optional( element ) || /^([0][1-9]|[1-2][0-9]|[3][0-7])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/.test( value );
	}, 'Please enter a valid gstin number.');

	jQuery.validator.addMethod("pan", function(value, element) {
		return this.optional( element ) || /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/.test( value );
	}, 'Please enter a valid pan number.');

	$("#customerForm").validate({
		rules: {    
			business_id:{
				required: true,
			},
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
			business_id:"Please select business.",
			pan_no:"Please enter pan no.",
			gstin_no:"Please enter valid gstin no.",
			email:"Please enter email.",
			mobile_no:"Please enter phone no.",
		}
	});

	$('#import_file').click(function(){
		var import_file = $("#file-input").val();
		if(import_file == ''){
			swal({
				text: "Please select csv file to upload.",
				type: "error",
				confirmButtonText: "Close",
			});
			return false;
		}
	});

});



function getBusiness(){

	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/getBusiness",
		"method": "POST",
		"headers": {
			"cache-control": "no-cache",
			"postman-token": "5d6d42d9-9cdb-e834-6366-d217b8e77f59"
		},
		"processData": false,
		"dataType":"JSON",                
		beforeSend:function(){
		},
		success:function(response){
			var data = response['data'];
			var option = "<option value='' disabled selected>Select Business</option>";
			if(data.length > 0){
				$.each(data, function(i, item) {
					option += "<option value='"+data[i]['business_id']+"'>"+data[i]['name']+"</option>";
				});
			}
			$(".dynamicBusiness").html('');
			$(".dynamicBusiness").append(option);
		},
		complete:function(){
		}
	}); 
}



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



function updateCustomer(){

	var flag = true;
	flag = $("#updateCustomerForm").valid();
	if(flag==false){
		return false;
	}

	var data = JSON.stringify($("#updateCustomerForm").serializeFormJSON());
	var contact_id = $("#contact_id").val();

	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/updateContact/"+contact_id,
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
			if(response.code == 201){
				swal({
					title: "Success !",
					text: response.message,
					type: "success",
					confirmButtonText: "OK",
					width:'400px',
				}).then(function () {
					window.location.href = SERVER_NAME+"/business";
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



function deleteContact(obj) {

	swal({
		text: "Do you want to delete this contact ?",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes'
	}).then(function() {
		var id = $(obj).attr('data-id');
		$.ajax({
			"async": true,
			"crossDomain": true,
			"url": SERVER_NAME + "/api/deleteContact/" + id,
			"method": "POST",
			"headers": {
				"cache-control": "no-cache",
				"postman-token": "5d6d42d9-9cdb-e834-6366-d217b8e77f59"
			},
			"processData": false,
			"dataType": "JSON",
			beforeSend: function() {
				$(".bodyLoaderWithOverlay").show();
			},
			success: function(response) {
				if (response.code == 200) {
					swal({
						title: "Success !",
						text: response.message,
						type: "success",
						confirmButtonText: "OK",
						width: '400px',
					}).then(function() {
						window.location.href = window.location.href;
					});
				} else {
					swal({
						title: "Failed!",
						text: response.message,
						type: "error",
						confirmButtonText: "Close",
					});
				}
			},
			complete: function() {
				$(".bodyLoaderWithOverlay").hide();
			}
		});
	});
}

function requestInfo(obj) {

	swal({
		text: "Do you want to request for this contact ?",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes'
	}).then(function() {
		var id = $(obj).attr('data-id');
		$.ajax({
			"async": true,
			"crossDomain": true,
			"url": SERVER_NAME + "/api/requestInfo/" + id,
			"method": "POST",
			"headers": {
				"cache-control": "no-cache",
				"postman-token": "5d6d42d9-9cdb-e834-6366-d217b8e77f59"
			},
			"processData": false,
			"dataType": "JSON",
			beforeSend: function() {
				$("#requestButton").prop('disabled', true).text('Requesting, Please Wait...');
			},
			success: function(response) {
				if (response.code == 200) {
					swal({
						title: "Success !",
						text: response.message,
						type: "success",
						confirmButtonText: "OK",
						width: '400px',
					}).then(function() {
						window.location.href = window.location.href;
					});
				} else {
					swal({
						title: "Failed!",
						text: response.message,
						type: "error",
						confirmButtonText: "Close",
					});
				}
			},
			complete: function() {
               //$("#requestButton").prop('disabled', true).text('Requested.');
           }
       });
	});

}