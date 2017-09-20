$(function(){

	getBusiness();
	getUnit();

	if (typeof $.cookie('token') === 'undefined' && typeof $.cookie('tokenId') === 'undefined'){
		window.location.href = SERVER_NAME;
	}

	$('#addItem').click(function(){
		addItem();
	});

	$('#updateItem').click(function(){
		updateItem();
	});

	$('#business_items').click(function(){
		items();
	});

	$("#itemForm").validate({
		rules: {    
			business_id:{
				required: true,
			},
			item_description:{
				required: true,
			},
			item_type:{
				required: true,
			},
			item_hsn_sac:{
				required: true,
			},
			item_unit:{
				required: true,
			},
		},
		messages: {    
			business_id:"Please select business.",
			item_description:"Please enter item description.",
			item_type:"Please select item type.",
			item_hsn_sac:"Please enter item hsn/sac number.",
			item_unit:"Please select item unit.",
		}
	});

	$("#updateItemForm").validate({
		rules: {    
			item_description:{
				required: true,
			},
			item_type:{
				required: true,
			},
			item_hsn_sac:{
				required: true,
			},
			item_unit:{
				required: true,
			},
		},
		messages: {    
			item_description:"Please enter item description.",
			item_type:"Please select item type.",
			item_hsn_sac:"Please enter item hsn/sac number.",
			item_unit:"Please select item unit.",
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
			var data = response.data;
			var option = "<option value='' disabled selected>Select Business</option>";
			if(data.length > 0){
				$.each(data, function(i, item) {
					option += "<option value='"+data[i].business_id+"'>"+data[i].name+"</option>";
				});
			}
			$(".dynamicBusiness").html('');
			$(".dynamicBusiness").append(option);
		},
		complete:function(){
		}
	}); 
}



function getUnit(){

	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/getUnit",
		"method": "GET",
		"headers": {
			"cache-control": "no-cache",
			"postman-token": "5d6d42d9-9cdb-e834-6366-d217b8e77f59"
		},
		"processData": false,
		"dataType":"JSON",                
		beforeSend:function(){
		},
		success:function(response){
			var data = response.data;
			var option = "<option value=''> Select Unit </option>";
			if(data.length > 0){
				$.each(data, function(i, item) {
					option += "<option value='"+data[i].unit_name+"'>"+data[i].unit_name+"</option>";
				});
			}
			$(".unit").append(option);
		},
		complete:function(){
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
					window.location.href = SERVER_NAME+"/importitem";
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



function updateItem(){

	var flag = true;
	flag = $("#updateItemForm").valid();
	if(flag==false){
		return false;
	}

	var data = JSON.stringify($("#updateItemForm").serializeFormJSON());
	var item_id = $("#item_id").val();

	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/updateItem/"+item_id,
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
			$("#updateItem").prop('disabled', true).text('Updating, Please Wait...');
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
					window.location.href = SERVER_NAME+"/importitem";
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
			$("#updateItem").prop('disabled', false).text('Update');
		}
	});
}



function deleteItem(obj) {
	var business_id = $("#business_id").val();
	var encode_id = window.btoa(business_id);
	//alert(encode_id);
	//return false;
	swal({
		text: "Do you want to delete this Item ?",
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
			"url": SERVER_NAME + "/api/deleteItem/" + id,
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
						window.location.href = SERVER_NAME+"/itemList/" + encode_id;
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



/*function items(){

	var business_id = $("#business_id").val();
	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/items/" + business_id,
		type:"GET",
		"headers": {
			"content-type": "application/json",
			"cache-control": "no-cache",
			"postman-token": "5d6d42d9-9cdb-e834-6366-d217b8e77f59"
		},
		"processData": false,
		"dataType":"JSON",
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
}*/