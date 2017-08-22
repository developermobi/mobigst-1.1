$(function(){

	if (typeof $.cookie('token') === 'undefined' && typeof $.cookie('tokenId') === 'undefined'){
		window.location.href = SERVER_NAME;
	}

	$('#addBusinessButton').click(function(){
		addBusiness();
	});

	$('#addGstinButton').click(function(){
		addGstin();
	});

	$('#cancelBusinessButton').click(function(){
		$('#businessForm').trigger("reset");
	});

	$('#cancelGstinButton').click(function(){
		$('#gstinForm').trigger("reset");
	});

	jQuery.validator.addMethod("gstin", function(value, element) {
		return this.optional( element ) || /^([0][1-9]|[1-2][0-9]|[3][0-7])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/.test( value );
	}, 'Please enter a valid gstin number.');

	jQuery.validator.addMethod("pan", function(value, element) {
		return this.optional( element ) || /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/.test( value );
	}, 'Please enter a valid pan number.');

	$("#businessForm").validate({
		rules: {    
			name:{
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
			display_name:{
				required: true,
			},
		},
		messages: {    
			name:"Please enter password.",
			pan_no:"Please enter pan no.",
			gstin_no:"Please enter valid gstin no.",
			display_name:"Please enter display name.",
		}
	});


	$("#gstinForm").validate({
		rules: {    
			gstin_no:{
				required: true,
				gstin:true,
			},
			display_name:{
				required: true,
			},
		},
		messages: {    
			gstin_no:"Please enter valid gstin no.",
			display_name:"Please enter display name.",
		}
	});

});


function addBusiness(){

	var flag = true;
	flag = $("#businessForm").valid();
	if(flag==false){
		return false;
	}

	var data = JSON.stringify($("#businessForm").serializeFormJSON());

	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/addBusiness",
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
			$("#addBusinessButton").prop('disabled', true).text('Adding. Please Wait...');
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
			$("#addBusinessButton").prop('disabled', false).text('Add');
		}
	});
}



function addGstin(){

	var flag = true;
	flag = $("#gstinForm").valid();
	if(flag==false){
		return false;
	}

	var data = JSON.stringify($("#gstinForm").serializeFormJSON());

	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/addGstin",
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
			$("#addBusinessButton").prop('disabled', true).text('Adding. Please Wait...');
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
			$("#addBusinessButton").prop('disabled', false).text('Add');
		}
	});
}