$(function(){

	//getBusiness();

	$('#updateCustomerInfo').click(function(){
		updateCustomerInfo();
	});


	$("#updateCustomerForm").validate({
		rules: {    
			business_id:{
				required: true,
			},
			pan_no:{
				required: true,
			},
			gstin_no:{
				required: true,
			},
		},
		messages: {    
			business_id:"Please select business.",
			pan_no:"Please enter pan no.",
			gstin_no:"Please enter valid gstin no.",
		}
	});
});




function updateCustomerInfo(){

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
			$("#updateCustomer").prop('disabled', false).text('Update');
		}
	});
}