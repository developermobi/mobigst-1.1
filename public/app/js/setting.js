$(function(){

	if (typeof $.cookie('token') === 'undefined' && typeof $.cookie('tokenId') === 'undefined'){
		window.location.href = SERVER_NAME;
	}

	jQuery.validator.addMethod("pan", function(value, element) {
		return this.optional( element ) || /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/.test( value );
	}, 'Please enter a valid pan number.');

	$("#updateBusinessForm").validate({
		rules: {    
			name:{
				required: true,
			},
			pan:{
				required: true,
				pan:true,
			},
		},
		messages: {    
			name:"Please enter business name.",
			pan:"Please enter pan number.",
		}
	});

	$("#updateBusiness").click(function(){

		var flag = true;
		flag = $("#updateBusinessForm").valid();
		if(flag==false){
			alert("All field are mandatory");
			return false;
		}

		var data = JSON.stringify($("#updateBusinessForm").serializeFormJSON());
		var business_id = $("#business_id").val();

		$.ajax({
			"async": true,
			"crossDomain": true,
			"url": SERVER_NAME+"/api/updateBusiness/"+business_id,
			"method": "POST",
			"headers": {
				"content-type": "application/json",
				"cache-control": "no-cache",
				"postman-token": "5d6d42d9-9cdb-e834-6366-d217b8e77f59"
			},
			"processData": false,
			"data":data,
			"dataType":"JSON",
			beforeSend:function(){
				$(".bodyLoaderWithOverlay").show();
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
				$(".bodyLoaderWithOverlay").hide();
			}
		});
	});

	jQuery.validator.addMethod("gstin", function(value, element) {
		return this.optional( element ) || /^([0][1-9]|[1-2][0-9]|[3][0-7])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/.test( value );
	}, 'Please enter a valid gstin number.');

	$("#updateGstinForm").validate({
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
			gstin_no:"Please enter gstin.",
			display_name:"Please enter display name.",
		}
	});

	$("#updateGstin").click(function(){

		var flag = true;
		flag = $("#updateGstinForm").valid();
		if(flag==false){
			alert("All field are mandatory");
			return false;
		}

		var data = JSON.stringify($("#updateGstinForm").serializeFormJSON());
		var gstin_id = $("#gstin_id").val();

		$.ajax({
			"async": true,
			"crossDomain": true,
			"url": SERVER_NAME+"/api/updateGstin/"+gstin_id,
			"method": "POST",
			"headers": {
				"content-type": "application/json",
				"cache-control": "no-cache",
				"postman-token": "5d6d42d9-9cdb-e834-6366-d217b8e77f59"
			},
			"processData": false,
			"data":data,
			"dataType":"JSON",
			beforeSend:function(){
				$(".bodyLoaderWithOverlay").show();
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
				$(".bodyLoaderWithOverlay").hide();
			}
		});            
	});

});



function editBusiness(id,this_obj){

	$("#business_id").val(id);

	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/getBusinessData/"+id,
		"method": "GET",
		"headers": {
			"cache-control": "no-cache",
			"postman-token": "5d6d42d9-9cdb-e834-6366-d217b8e77f59"
		},
		"processData": false,
		"dataType":"JSON",
		beforeSend:function(){
			$(".bodyLoaderWithOverlay").show();
		},
		success:function(response){
			if(response.code == 200){
				$("#name").val(response.data[0]['name']);
				$("#pan").val(response.data[0]['pan']);
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
			$(".bodyLoaderWithOverlay").hide();
		}
	});
}



function deleteBusiness(obj){

	swal({
		text: "Do you want to delete this business?",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes'
	}).then(function () {
		var id = $(obj).attr('data-id');
		$.ajax({
			"async": true,
			"crossDomain": true,
			"url": SERVER_NAME+"/api/deleteBusiness/"+id,
			"method": "POST",
			"headers": {
				"cache-control": "no-cache",
				"postman-token": "5d6d42d9-9cdb-e834-6366-d217b8e77f59"
			},
			"processData": false,
			"dataType":"JSON",
			beforeSend:function(){
				$(".bodyLoaderWithOverlay").show();
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
				$(".bodyLoaderWithOverlay").hide();
			}
		});
	})
}



function editGstin(id,this_obj){

	$("#gstin_id").val(id);

	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/getGstinData/"+id,
		"method": "GET",
		"headers": {
			"cache-control": "no-cache",
			"postman-token": "5d6d42d9-9cdb-e834-6366-d217b8e77f59"
		},
		"processData": false,
		"dataType":"JSON",
		beforeSend:function(){
			$(".bodyLoaderWithOverlay").show();
		},
		success:function(response){
			if(response.code == 200){
				$("#gstin_no").val(response.data[0]['gstin_no']);
				$("#display_name").val(response.data[0]['display_name']);
			}else{
				alert(response.message);
			}
		},
		complete:function(){
			$(".bodyLoaderWithOverlay").hide();
		}
	});
}



function deleteGstin(obj){

	swal({
		text: "Do you want to delete this GSTIN ?",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes'
	}).then(function () {
		var id = $(obj).attr('data-id');
		$.ajax({
			"async": true,
			"crossDomain": true,
			"url": SERVER_NAME+"/api/deleteGstin/"+id,
			"method": "POST",
			"headers": {
				"cache-control": "no-cache",
				"postman-token": "5d6d42d9-9cdb-e834-6366-d217b8e77f59"
			},
			"processData": false,
			"dataType":"JSON",
			beforeSend:function(){
				$(".bodyLoaderWithOverlay").show();
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
				$(".bodyLoaderWithOverlay").hide();
			}
		});
	})
}