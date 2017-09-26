$(function(){

	$('.rate').css('pointer-events','none');
	$('.cgst_amount').css('pointer-events','none');
	$('.sgst_amount').css('pointer-events','none');
	$('.igst_amount').css('pointer-events','none');
	$('.roundoff').css('pointer-events','none');

	var business_id = $("#business_id").val();

	getStates();
	getItemUnit();
	getContact(business_id);

	if (typeof $.cookie('token') === 'undefined' && typeof $.cookie('tokenId') === 'undefined'){
		window.location.href = SERVER_NAME;
	}

	$(".place_of_supply").change(function(event){
		var place_of_supply = $("#place_of_supply").val();
		var customer_state = $("#customer_state").val();

		if(place_of_supply == customer_state){
			$(".cgst_percentage").val('0');
			$(".cgst_percentage").prop('disabled', false);
			$(".cgst_amount").val('0');
			$(".cgst_amount").prop('disabled', false);
			$(".sgst_percentage").val('0');
			$(".sgst_percentage").prop('disabled', false);
			$(".sgst_amount").val('0');
			$(".sgst_amount").prop('disabled', false);
			$(".igst_percentage").val('0');
			$(".igst_percentage").prop('disabled', true);
			$(".igst_amount").val('0');
			$(".igst_amount").prop('disabled', true);
			$(".total_cgst_amount").val('0');
			$(".total_sgst_amount").val('0');
			$(".total_igst_amount").val('0');
			Recalculate();
		}else{
			$(".cgst_percentage").val('0');
			$(".cgst_percentage").prop('disabled', true);
			$(".cgst_amount").val('0');
			$(".cgst_amount").prop('disabled', true);
			$(".sgst_percentage").val('0');
			$(".sgst_percentage").prop('disabled', true);
			$(".sgst_amount").val('0');
			$(".sgst_amount").prop('disabled', true);
			$(".igst_percentage").val('0');
			$(".igst_percentage").prop('disabled', false);
			$(".igst_amount").val('0');
			$(".igst_amount").prop('disabled', false);
			$(".total_cgst_amount").val('0');
			$(".total_sgst_amount").val('0');
			$(".total_igst_amount").val('0');
			Recalculate();
		}
	});

	$("#same_address").change(function(event){
		if (this.checked){
			var sh_address = $("#bill_address").val();
			var sh_pincode = $("#bill_pincode").val();
			var sh_city = $("#bill_city").val();
			var sh_state = $("#bill_state").val();
			var sh_country = $("#bill_country").val();
			$("#sh_address").val(sh_address);
			$("#sh_pincode").val(sh_pincode);
			$("#sh_city").val(sh_city);
			$("#sh_state").val(sh_state);
			$("#sh_country").val(sh_country);
		} else {
			$("#sh_address").val("");
			$("#sh_pincode").val("");
			$("#sh_city").val("");
			$("#sh_state").val("");
			$("#sh_country").val("");
		}
	});


	$('#advance_setting').change(function() {
		var total_cgst_amount = $(".total_cgst_amount").val();
		var total_sgst_amount = $(".total_sgst_amount").val();
		var total_igst_amount = $(".total_igst_amount").val();
		var total_cess_amount = $(".total_cess_amount").val();

		var total_tax = ''; var grand_total = ''; var total_in_words = '';
		if ($(this).is(':checked')) {

			$("#tt_cgst_amount").val('0');
			$("#tt_cgst_amount").prop('disabled', false);
			$("#tt_sgst_amount").val('0');
			$("#tt_sgst_amount").prop('disabled', false);
			$("#tt_igst_amount").val('0');
			$("#tt_igst_amount").prop('disabled', false);
			$("#tt_cess_amount").val('0');
			$("#tt_cess_amount").prop('disabled', false);
			$("#tt_total").val('0');
			$("#tt_total").prop('disabled', false);
			
			$("#tt_cgst_amount").val(total_cgst_amount);
			$("#tt_sgst_amount").val(total_sgst_amount);
			$("#tt_igst_amount").val(total_igst_amount);
			$("#tt_cess_amount").val(total_cess_amount);
			var tt_total = parseFloat(total_cgst_amount) + parseFloat(total_sgst_amount) + parseFloat(total_igst_amount) + parseFloat(total_cess_amount);
			$("#tt_total").val(tt_total.toFixed(2));

			$("#total_tax").val('0');

			total_tax = parseFloat(total_cgst_amount) + parseFloat(total_sgst_amount) + parseFloat(total_igst_amount) + parseFloat(total_cess_amount);
			var total = $(".total_amount").val();

			$(".total_amount").val(parseFloat(total) - parseFloat(total_tax.toFixed(2)));
			var total_amount = $(".total_amount").val();
			$("#grand_total").val(total_amount);
			grand_total = $("#grand_total").val();
			total_in_words = number2text(grand_total);
			$("#total_in_words").val(total_in_words);
		}else{
			total_tax = $("#tt_total").val();
			grand_total = $("#grand_total").val();
			$(".total_amount").val(parseFloat(grand_total) + parseFloat(total_tax));
			$("#grand_total").val(parseFloat(grand_total) + parseFloat(total_tax));
			var new_grand_total = $("#grand_total").val();
			total_in_words = number2text(new_grand_total);
			$("#total_in_words").val(total_in_words);

			$("#tt_cgst_amount").val('0');
			$("#tt_cgst_amount").prop('disabled', true);
			$("#tt_sgst_amount").val('0');
			$("#tt_sgst_amount").prop('disabled', true);
			$("#tt_igst_amount").val('0');
			$("#tt_igst_amount").prop('disabled', true);
			$("#tt_cess_amount").val('0');
			$("#tt_cess_amount").prop('disabled', true);
			$("#tt_total").val('0');
			$("#tt_total").prop('disabled', true);

			$("#total_tax").val(parseFloat(total_cgst_amount) + parseFloat(total_sgst_amount) + parseFloat(total_igst_amount) + parseFloat(total_cess_amount));
		}
	});

	$('#save_invoice').click(function(){
		saveServicesSalesInvoice();
	});

	$('#cancelItemButton').click(function(){
		$('#itemForm').trigger("reset");
	});

	$('#update_invoice').click(function(){
		updateServicesSalesInvoice();
	});

});



function getContact(business_id){

	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/getContact/"+business_id,
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
			var contact_name_hidden = $('#contact_name_hidden').val();
			var data = response.data;
			var option = "";
			if(data.length > 0){
				$.each(data, function(i, item) {
					option += "<option value='"+data[i].contact_name+"' data-attr='"+data[i].contact_id+"'>"+data[i].contact_name+"</option>";
				});
			}
			$(".contact_name").append(option);
		},
		complete:function(){
		}
	}); 
}



function getStates(){

	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/getStates",
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
			var option = "<option value=''></option>";
			if(data.length > 0){
				$.each(data, function(i, item) {
					option += "<option value='"+data[i].state_name+"'>"+data[i].state_name+"</option>";
				});
			}
			$(".place_of_supply").append(option);
			$(".state").append(option);
		},
		complete:function(){
		}
	}); 
}



function getUnit(obj){

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
			var option = "";
			if(data.length > 0){
				$.each(data, function(i, item) {
					option += "<option value='"+data[i].unit_name+"'>"+data[i].unit_name+"</option>";
				});
			}
			$(obj).closest("tr").find(".unit").append(option);
		},
		complete:function(){
		}
	}); 
}



function getItemUnit(){

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
			var option = "<option value=''> Select Item Unit </option>";
			if(data.length > 0){
				$.each(data, function(i, item) {
					option += "<option value='"+data[i].unit_name+"'>"+data[i].unit_name+"</option>";
				});
			}
			$(".item_unit").append(option);
		},
		complete:function(){
		}
	}); 
}



function getContactInfo(obj){
	
	var contact_id = $(obj).find(':selected').attr('data-attr');
	
	$.ajax({
		"async": false,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/getContactInfo/"+contact_id,
		"method": "GET",
		"dataType":"JSON",
		beforeSend:function(){
			$("#subcity").html("");
		},
		success:function(response){
			if(response.code == 302){
				$("#bill_address").val(response.data[0].address);
				$("#bill_pincode").val(response.data[0].pincode);
				$("#bill_city").val(response.data[0].city);
				$("#bill_state").val(response.data[0].state);
				$("#bill_country").val(response.data[0].country);
				$("#contact_gstin").val(response.data[0].gstin_no);
				$("#place_of_supply").val(response.data[0].state);

				var place_of_supply = $("#place_of_supply").val();

				var customer_state = $("#customer_state").val();
				if(place_of_supply == customer_state){
					$(".cgst_percentage").val('0');
					$(".cgst_percentage").prop('disabled', false);
					$(".cgst_amount").val('0');
					$(".cgst_amount").prop('disabled', false);
					$(".sgst_percentage").val('0');
					$(".sgst_percentage").prop('disabled', false);
					$(".sgst_amount").val('0');
					$(".sgst_amount").prop('disabled', false);
					$(".igst_percentage").val('0');
					$(".igst_percentage").prop('disabled', true);
					$(".igst_amount").val('0');
					$(".igst_amount").prop('disabled', true);
					$(".total_cgst_amount").val('0');
					$(".total_sgst_amount").val('0');
					$(".total_igst_amount").val('0');
					Recalculate();
				}else{
					$(".cgst_percentage").val('0');
					$(".cgst_percentage").prop('disabled', true);
					$(".cgst_amount").val('0');
					$(".cgst_amount").prop('disabled', true);
					$(".sgst_percentage").val('0');
					$(".sgst_percentage").prop('disabled', true);
					$(".sgst_amount").val('0');
					$(".sgst_amount").prop('disabled', true);
					$(".igst_percentage").val('0');
					$(".igst_percentage").prop('disabled', false);
					$(".igst_amount").val('0');
					$(".igst_amount").prop('disabled', false);
					$(".total_cgst_amount").val('0');
					$(".total_sgst_amount").val('0');
					$(".total_igst_amount").val('0');
					Recalculate();
				}
			}
		},
		complete:function(){
		}
	});
}



function getItem(business_id){

	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/getItem/"+business_id,
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
			var option = "<option value=''></option>";
			if(data.length > 0){
				$.each(data, function(i, item) {
					option += "<option value='"+data[i].item_description+"' data-attr='"+data[i].item_id+"'>"+data[i].item_description+"</option>";
				});
			}
			$(".item_name").append(option);
		},
		complete:function(){
		}
	}); 
}



function getItemInfo(obj){
	
	var item_id = $(obj).find(':selected').attr('data-attr');
	
	$.ajax({
		"async": false,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/getItemInfo/"+item_id,
		"method": "GET",
		"dataType":"JSON",
		beforeSend:function(){
			$("#subcity").html("");
		},
		success:function(response){
			var unit = $(obj).closest("tr").find(".unit");
			var rate = $(obj).closest("tr").find("#rate");
			var item_value = $(obj).closest("tr").find("#item_value");
			var hsn_sac_no = $(obj).closest("tr").find("#hsn_sac_no");
			var total = $(obj).closest("tr").find("#total");
			if(response.code == 302){
				$(unit).val(response.data[0].item_unit);
				$(hsn_sac_no).val(response.data[0].item_hsn_sac);
				$(rate).val(response.data[0].item_sale_price);
				$(item_value).val(response.data[0].item_sale_price);
				$(total).val(response.data[0].item_sale_price);
			}
			calCgstAmount(obj);
			calculateTotal(obj);
		},
		complete:function(){
		}
	});
}



function removeDiscount(obj){
	$('.discount').val('0');
	calculateNew(obj);
	alert('msg');
	calculateTotal(obj);
	alert('msg1');
	$('.removeDiv').hide();
}



function calCgstAmount(obj){

	var rate_element = $(obj).closest("tr").find(".rate");
	var rate = rate_element.val();
	
	var cgst_percentage_element = $(obj).closest("tr").find(".cgst_percentage");
	var cgst_percentage = cgst_percentage_element.val();

	var cgst_amount_element = $(obj).closest("tr").find(".cgst_amount");
	var cgst_amount = (rate / 100) * cgst_percentage;
	cgst_amount_element.val(cgst_amount.toFixed(2));

	var sgst_percentage_element = $(obj).closest("tr").find(".sgst_percentage");
	var sgst_percentage = sgst_percentage_element.val();

	var sgst_amount_element = $(obj).closest("tr").find(".sgst_amount");
	var sgst_amount = (rate / 100) * sgst_percentage;
	sgst_amount_element.val(sgst_amount.toFixed(2));

	var igst_percentage_element = $(obj).closest("tr").find(".igst_percentage");
	var igst_percentage = igst_percentage_element.val();

	var igst_amount_element = $(obj).closest("tr").find(".igst_amount");
	var igst_amount = (rate / 100) * igst_percentage;
	igst_amount_element.val(igst_amount.toFixed(2));

	var cess_percentage_element = $(obj).closest("tr").find(".cess_percentage");
	var cess_percentage = cess_percentage_element.val();

	var cess_amount_element = $(obj).closest("tr").find(".cess_amount");
	var cess_amount = (rate / 100) * cess_percentage;
	cess_amount_element.val(cess_amount.toFixed(2));

	var total_element = $(obj).closest("tr").find(".total");
	var total = parseFloat(rate) + parseFloat(cgst_amount) + parseFloat(sgst_amount) + parseFloat(igst_amount) + parseFloat(cess_amount);
	total_element.val(total.toFixed(2));

	calculateTotal(obj);
}



function calculateCESS(obj){
	var rate_element = $(obj).closest("tr").find(".rate");
	var rate = rate_element.val();

	var cess_percentage = $(obj).closest("tr").find(".cess_percentage").val();
	if(cess_percentage != ''){

		var amount_element = $(obj).closest("tr").find(".cess_amount");
		var amount = (rate / 100) * cess_percentage;
		amount_element.val(amount);

		calCgstAmount(obj);
		calculateTotal(obj);
	}
}



function Recalculate(){
	$('#item_table tr').each(function() {
		var item_rate = $(this).find(".rate").val();
		var total_element = $(this).find('.total');
		total_element.val(item_rate);
	});
	calculateTotal(this);
}



function calculateNew(obj){
	var quantity = $(obj).closest("tr").find(".quantity").val();
	var item_value = $(obj).closest("tr").find(".item_value").val();
	var discount = $(obj).closest("tr").find(".discount").val();

	if(quantity == '' || quantity == '0'){
		quantity = 1;
	}

	if(item_value == ''){
		item_value = 0;
	}

	if(discount == ''){
		discount = 0;
	}

	var priceNquantity = parseFloat(quantity)*parseFloat(item_value);
	var rate_element = $(obj).closest("tr").find(".rate");
	rate_element.val(priceNquantity);

	/*var amount = (parseFloat(priceNquantity) / 100) * discount;
	var new_rate = parseFloat(priceNquantity) - parseFloat(amount);
	console.log(new_rate);
	rate_element.val(new_rate.toFixed(2));*/

	var amount = (parseFloat(priceNquantity)) - parseFloat(discount);
	rate_element.val(amount.toFixed(2));

	calCgstAmount(obj);

	var cgst_amount_element = $(obj).closest("tr").find(".cgst_amount");
	var cgst_amount = cgst_amount_element.val();
	var new_cgst_amount = cgst_amount_element.val(cgst_amount*discount);

	var sgst_amount_element = $(obj).closest("tr").find(".sgst_amount");
	var sgst_amount = sgst_amount_element.val();
	var new_sgst_amount = sgst_amount_element.val(sgst_amount*discount);

	var igst_amount_element = $(obj).closest("tr").find(".igst_amount");
	var igst_amount = igst_amount_element.val();
	var new_igst_amount = igst_amount_element.val(igst_amount*discount);

	var cess_amount_element = $(obj).closest("tr").find(".cess_amount");
	var cess_amount = cess_amount_element.val();
	var cess_igst_amount = cess_amount_element.val(cess_amount*discount);

	calCgstAmount(obj);
	calculateTotal(obj);
}



function calculateTotal(obj){
	
	var rate_sum = 0;
	$(".rate").each(function(){
		rate_sum = rate_sum + parseFloat($(this).val());
	});

	var cgst_amount_sum = 0;
	$(".cgst_amount").each(function(){
		cgst_amount_sum = cgst_amount_sum + parseFloat($(this).val());
	});

	var sgst_amount_sum = 0;
	$(".sgst_amount").each(function(){
		sgst_amount_sum = sgst_amount_sum + parseFloat($(this).val());
	});

	var igst_amount_sum = 0;
	$(".igst_amount").each(function(){
		igst_amount_sum = igst_amount_sum + parseFloat($(this).val());
	});

	var cess_amount_sum = 0;
	$(".cess_amount").each(function(){
		cess_amount_sum = cess_amount_sum + parseFloat($(this).val());
	});

	$(".total_cgst_amount").val(cgst_amount_sum.toFixed(2));
	$(".total_sgst_amount").val(sgst_amount_sum.toFixed(2));
	$(".total_igst_amount").val(igst_amount_sum.toFixed(2));
	$(".total_cess_amount").val(cess_amount_sum.toFixed(2));

	var total_tax = parseFloat(cgst_amount_sum) + parseFloat(sgst_amount_sum) + parseFloat(cess_amount_sum) + parseFloat(igst_amount_sum);
	$("#total_tax").val(parseFloat(total_tax.toFixed(2)));
	var total_amount = parseFloat(cgst_amount_sum) + parseFloat(sgst_amount_sum) + parseFloat(cess_amount_sum) + parseFloat(rate_sum) + parseFloat(igst_amount_sum);
	$("#total_amount").val(parseFloat(total_amount.toFixed(2)));
	
	var decimal = ''; var grand_total = ''; var tostring = ''; var new_grand_total = ''; var digit = '';

	grand_total = parseFloat(total_amount.toFixed(2));
	tostring = grand_total.toString();
	new_grand_total = '';
	if(tostring % 1 != 0){
		if($('#is_roundoff').is(":checked")){
			decimal = tostring.split('.')[1];
			digit = tostring.split('.')[0];
			if(decimal > 50){
				$("#roundoff").val("0.".concat(decimal));
				new_grand_total = parseFloat(digit) + 1;
				$("#grand_total").val(new_grand_total);
			}else{
				$("#roundoff").val("-0.".concat(decimal));
				$("#grand_total").val(digit);
			}
		}else{
			$("#roundoff").val('0');
			$("#grand_total").val(grand_total);
		}
	}else{
		$("#grand_total").val(grand_total);
	}

	var total_in_words = number2text($("#grand_total").val());
	$("#total_in_words").val(total_in_words);
	
	if($('#advance_setting').is(":checked")){
		$("#total_tax").val('0');
		$("#total_amount").val(parseFloat(rate_sum));
		
		console.log("total checked ",rate_sum);
		grand_total = parseFloat(rate_sum.toFixed(2));
		tostring = grand_total.toString();
		if(tostring % 1 != 0){
			if($('#is_roundoff').is(":checked")){
				decimal = tostring.split('.')[1];
				digit = tostring.split('.')[0];
				if(decimal > 50){
					$("#roundoff").val("0.".concat(decimal));
					new_grand_total = parseFloat(digit) + 1;
					$("#grand_total").val(new_grand_total);
				}else{
					$("#roundoff").val("-0.".concat(decimal));
					$("#grand_total").val(digit);
				}
			}else{
				$("#roundoff").val('0');
				$("#grand_total").val(grand_total);
			}
		}else{
			$("#grand_total").val(grand_total);
		}
		total_in_words = number2text($("#grand_total").val());
		$("#total_in_words").val(total_in_words);

		$("#tt_cgst_amount").val(cgst_amount_sum);
		$("#tt_sgst_amount").val(sgst_amount_sum);
		$("#tt_igst_amount").val(igst_amount_sum);
		$("#tt_cess_amount").val(cess_amount_sum);
		var tt_total = parseFloat(cgst_amount_sum) + parseFloat(sgst_amount_sum) + parseFloat(igst_amount_sum) + parseFloat(cess_amount_sum);
		$("#tt_total").val(tt_total.toFixed(2));
	}else{
		total_tax = parseFloat(cgst_amount_sum) + parseFloat(sgst_amount_sum) + parseFloat(cess_amount_sum) + parseFloat(igst_amount_sum);
		$("#total_tax").val(parseFloat(total_tax.toFixed(2)));
		total_amount = parseFloat(cgst_amount_sum) + parseFloat(sgst_amount_sum) + parseFloat(cess_amount_sum) + parseFloat(rate_sum) + parseFloat(igst_amount_sum);
		$("#total_amount").val(parseFloat(total_amount.toFixed(2)));
		
		grand_total = parseFloat(total_amount.toFixed(2));
		tostring = grand_total.toString();
		if(tostring % 1 != 0){
			if($('#is_roundoff').is(":checked")){
				decimal = tostring.split('.')[1];
				digit = tostring.split('.')[0];
				if(decimal > 50){
					$("#roundoff").val("0.".concat(decimal));
					new_grand_total = parseFloat(digit) + 1;
					$("#grand_total").val(new_grand_total);
				}else{
					$("#roundoff").val("-0.".concat(decimal));
					$("#grand_total").val(digit);
				}
			}else{
				$("#roundoff").val('0');
				$("#grand_total").val(grand_total);
			}
		}else{
			$("#grand_total").val(grand_total);
		}
		total_in_words = number2text($("#grand_total").val());
		$("#total_in_words").val(total_in_words);
	}
}



function saveSalesInvoice(){

	var data = JSON.stringify($("#invoiceForm").serializeFormJSON());
	
	if($("#contact_name").val() == ''){
		swal({
			title: "Failed!",
			text: "Please Select Contact",
			type: "error",
			confirmButtonText: "Close",
		});
		return false;
	}

	if($('.igst_percentage').prop('disabled')){
	}else{
		$(".igst_percentage").each(function() {
			if($(this).val() == 0){
				swal({
					title: "Failed!",
					text: "Please Select IGST",
					type: "error",
					confirmButtonText: "Close",
				});
				return false;
			}
		});
	}
	if($('.sgst_percentage').prop('disabled')){
	}else{
		$(".sgst_percentage").each(function() {
			if($(this).val() == 0){
				swal({
					title: "Failed!",
					text: "Please Select SGST",
					type: "error",
					confirmButtonText: "Close",
				});
				return false;
			}
		});
	}
	if($('.cgst_percentage').prop('disabled')){
	}else{
		$(".cgst_percentage").each(function() {
			if($(this).val() == 0){
				swal({
					title: "Failed!",
					text: "Please Select CGST",
					type: "error",
					confirmButtonText: "Close",
				});
				return false;
			}
		});
	}
	
	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/saveSalesInvoice",
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
			$("#save_invoice").prop('disabled', true).text('Please Wait...');
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
					window.location.reload();
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
			$("#save_invoice").prop('disabled', false).text('Save Invoice');
		}
	});
}



/*NUMBER TO WORDS*/

function number2text(value) {
	var fraction = Math.round(frac(value)*100);
	var f_text  = "";

	if(fraction > 0) {
		f_text = "AND "+convert_number(fraction)+" PAISE";
	}
	return convert_number(value)+" RUPEE "+f_text+" ONLY";
}

function frac(f) {
	return f % 1;
}

function convert_number(number){
	if ((number < 0) || (number > 999999999)) { 
		return "NUMBER OUT OF RANGE!";
	}
	var Gn = Math.floor(number / 10000000);
	number -= Gn * 10000000; 
	var kn = Math.floor(number / 100000);
	number -= kn * 100000; 
	var Hn = Math.floor(number / 1000);
	number -= Hn * 1000; 
	var Dn = Math.floor(number / 100);
	number = number % 100; 
	var tn= Math.floor(number / 10); 
	var one=Math.floor(number % 10); 
	var res = ""; 

	if (Gn>0) { 
		res += (convert_number(Gn) + " CRORE"); 
	} 
	if (kn>0) { 
		res += (((res=="") ? "" : " ") + 
			convert_number(kn) + " LAKH"); 
	} 
	if (Hn>0) { 
		res += (((res=="") ? "" : " ") +
			convert_number(Hn) + " THOUSAND"); 
	} 
	if (Dn){ 
		res += (((res=="") ? "" : " ") + 
			convert_number(Dn) + " HUNDRED"); 
	} 

	var ones = Array("", "ONE", "TWO", "THREE", "FOUR", "FIVE", "SIX","SEVEN", "EIGHT", "NINE", "TEN", "ELEVEN", "TWELVE", "THIRTEEN","FOURTEEN", "FIFTEEN", "SIXTEEN", "SEVENTEEN", "EIGHTEEN","NINETEEN"); 
	var tens = Array("", "", "TWENTY", "THIRTY", "FOURTY", "FIFTY", "SIXTY","SEVENTY", "EIGHTY", "NINETY");

	if (tn>0 || one>0) { 
		if ((res!="")){ 
			res += " AND "; 
		} 
		if (tn < 2) { 
			res += ones[tn * 10 + one]; 
		}else{ 
			res += tens[tn];
			if (one>0){ 
				res += ("-" + ones[one]); 
			} 
		} 
	}
	if (res==""){ 
		res = "zero"; 
	} 
	return res;
}

/*NUMBER TO WORDS*/



function deleteInvoiceDetail(id_no,obj){
	var id = id_no;

	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/deleteInvoiceDetail/"+id,
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
			console.log(response);
		},
		complete:function(){
			$(".bodyLoaderWithOverlay").hide();
		}
	});
}



function updateServicesSalesInvoice(){

	var data = JSON.stringify($("#invoiceForm").serializeFormJSON());
	var si_id = $("#si_id").val();

	var flag = 1;

	if($('.igst_percentage').prop('disabled')){
	}else if(flag == 1){
		$(".igst_percentage").each(function() {
			if($(this).val() == 0){
				swal({
					title: "Failed!",
					text: "Please Select Tax",
					type: "error",
					confirmButtonText: "Close",
				});
				flag = 0;
				return false;
			}
		});
	}

	if($('.sgst_percentage').prop('disabled')){
	}else if(flag == 1){
		$(".sgst_percentage").each(function() {
			if($(this).val() == 0){
				swal({
					title: "Failed!",
					text: "Please Select Tax",
					type: "error",
					confirmButtonText: "Close",
				});
				flag = 0;
				return false;
			}
		});
	}
	if($('.cgst_percentage').prop('disabled')){
	}else if(flag == 1){
		$(".cgst_percentage").each(function() {
			if($(this).val() == 0){
				swal({
					title: "Failed!",
					text: "Please Select Tax",
					type: "error",
					confirmButtonText: "Close",
				});
				flag = 0;
				return false;
			}
		});
	}

	if(flag == 0){
		return false;
	}
	
	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/updateServicesSalesInvoice/"+si_id,
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
			$("#update_invoice").prop('disabled', true).text('Please Wait...');
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
					window.location.reload();
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
			$("#update_invoice").prop('disabled', false).text('Update Invoice');
		}
	});
}