$(function(){

	if (typeof $.cookie('token') === 'undefined' && typeof $.cookie('tokenId') === 'undefined'){
		window.location.href = SERVER_NAME;
	}

});



function cancelPurchaseInvoice(obj){

	swal({
		text: "Do you want to cancel this invoice ?",
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
			"url": SERVER_NAME+"/api/cancelPurchaseInvoice/"+id,
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
	});
}



function cancelVcdnote(obj){

	swal({
		text: "Do you want to cancel this note ?",
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
			"url": SERVER_NAME+"/api/cancelVcdnote/"+id,
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
	});
}



function cancelAdvancePayment(obj){

	swal({
		text: "Do you want to cancel this payment ?",
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
			"url": SERVER_NAME+"/api/cancelAdvancePayment/"+id,
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
	});
}