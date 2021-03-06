$(function(){

	jQuery.extend(jQuery.expr[':'], {
		focusable: function (el, index, selector) {
			return $(el).is('a, button, :input, [tabindex]');
		}
	});

	$(document).on('keypress', 'input,select,checkbox', function (e) {
		if (e.which == 13) {
			e.preventDefault();
			var $canfocus = $(':focusable');
			var index = $canfocus.index(document.activeElement) + 1;
			if (index >= $canfocus.length) index = 0;
			$canfocus.eq(index).focus();
		}
	});

	$('.invoice_no').keypress(function(e) {
		if(e.keyCode == 13) {
			$('.item_name').focus();
		}
	});

	$('.discount').keypress(function(e) {
		if(e.keyCode == 13) {
			$('#advance_setting').focus();
		}
	});

	$('.rate').css('pointer-events','none');
	$('.cgst_amount').css('pointer-events','none');
	$('.sgst_amount').css('pointer-events','none');
	$('.igst_amount').css('pointer-events','none');
	$('.roundoff').css('pointer-events','none');

	$("#tt_taxable_value").val('0');
	$("#tt_taxable_value").prop('disabled', true);
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

	$("#freight_charge").prop('disabled', true);
	$("#lp_charge").prop('disabled', true);
	$("#insurance_charge").prop('disabled', true);
	$("#other_charge").prop('disabled', true);
	$('#other_charge_name').prop('disabled', true);

	var gstin_id = $("#gstin_id").val();

	getInvoice(gstin_id);

	if (typeof $.cookie('token') === 'undefined' && typeof $.cookie('tokenId') === 'undefined'){
		window.location.href = SERVER_NAME;
	}

	$('.note_type').change(function(){
		if ($('input[name=note_type]:checked').val() == 2){
			var note_no = $(".note_no").val().slice(3);
			var new_note_no = "VDN".concat(note_no);
			$(".note_no").val(new_note_no);
		}else{
			var note_no = $(".note_no").val().slice(3);
			var new_note_no = "VCN".concat(note_no);
			$(".note_no").val(new_note_no);
		}
	});

	$('#advance_setting').change(function() {
		var total_cgst_amount = $(".total_cgst_amount").val();
		var total_sgst_amount = $(".total_sgst_amount").val();
		var total_igst_amount = $(".total_igst_amount").val();
		var total_cess_amount = $(".total_cess_amount").val();

		var total_tax = '';var grand_total = '';var total_in_words = '';

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
			test_calculate_gt();
		}else{
			total_tax = $("#tt_total").val();

			var temp_total_amount = $("#total_amount").val();
			temp_total_amount = parseFloat(temp_total_amount) + parseFloat(total_tax);
			$(".total_amount").val(temp_total_amount);
			test_calculate_gt();
			
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

			total_tax = parseFloat(total_cgst_amount) + parseFloat(total_sgst_amount) + parseFloat(total_igst_amount) + parseFloat(total_cess_amount);
			$("#total_tax").val(total_tax.toFixed(2));
		}
	});

	$('#is_freight_charge').change(function(){
		if ($('#is_freight_charge').is(':checked') == true){
			$('#freight_charge').prop('disabled', false);
			$('#freight_charge').focus();
		} else {
			$('#freight_charge').val('');
			calculateTotal(this);
			$('#freight_charge').prop('disabled', true);
		}
	});

	$('#is_lp_charge').change(function(){
		if ($('#is_lp_charge').is(':checked') == true){
			$('#lp_charge').prop('disabled', false);
			$('#lp_charge').focus();
		} else {
			$('#lp_charge').val('');
			calculateTotal(this);
			$('#lp_charge').prop('disabled', true);
		}
	});

	$('#is_insurance_charge').change(function(){
		if ($('#is_insurance_charge').is(':checked') == true){
			$('#insurance_charge').prop('disabled', false);
			$('#insurance_charge').focus();
		} else {
			$('#insurance_charge').val('');
			calculateTotal(this);
			$('#insurance_charge').prop('disabled', true);
		}
	});

	$('#is_other_charge').change(function(){
		if ($('#is_other_charge').is(':checked') == true){
			$('#other_charge').prop('disabled', false);
			$('#other_charge_name').prop('disabled', false);
			$('#other_charge_name').focus();
		} else {
			$('#other_charge').val('');
			calculateTotal(this);
			$('#other_charge').prop('disabled', true);
			$('#other_charge_name').prop('disabled', true);
		}
	});

	$('#cancelItemButton').click(function(){
		$('#itemForm').trigger("reset");
	});

	$('#save_invoice').click(function(){
		saveVcdnote();
	});

	$('#update_invoice').click(function(){
		updateVcdnote();
	});

});




function onItemNameChange(obj,e){
	if(e.keyCode == 13) {		
		$(obj).closest('tr').find('.hsn_sac_no').focus();
	}
}


function getInvoice(gstin){

	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/getInvoice/"+gstin,
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
					option += "<option value='"+data[i].invoice_no+"' data-attr='"+data[i].pi_id+"'>"+data[i].invoice_no+"</option>";
				});
			}
			$(".invoice_no").append(option);
		},
		complete:function(){
		}
	}); 
}



function getPurchaseInvoiceInfo(obj){
	
	//var pi_id = $(obj).find(':selected').attr('data-attr');
	var pi_id = $('#pi_id').val();

	$.ajax({
		"async": false,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/getPurchaseInvoiceInfo/"+pi_id,
		"method": "GET",
		"dataType":"JSON",
		beforeSend:function(){
			$("#subcity").html("");
		},
		success:function(response){
			if(response.code == 302){
				$("#bill_address").val(response.data[0].bill_address);
				$("#bill_pincode").val(response.data[0].bill_pincode);
				$("#bill_city").val(response.data[0].bill_city);
				$("#bill_state").val(response.data[0].bill_state);
				$("#bill_country").val(response.data[0].bill_country);
				$("#contact_gstin").val(response.data[0].contact_gstin);
				$("#place_of_supply").val(response.data[0].place_of_supply);
				$("#sh_address").val(response.data[0].sh_address);
				$("#sh_pincode").val(response.data[0].sh_pincode);
				$("#sh_city").val(response.data[0].sh_city);
				$("#sh_state").val(response.data[0].sh_state);
				$("#sh_country").val(response.data[0].sh_country);
				$("#contact_name").val(response.data[0].contact_name);

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
				}
			}
		},
		complete:function(){
		}
	});
}



function test_calculate_gt(){
	var total_amount = $(".total_amount").val();
	var my_total_tax = $("#tt_total").val();
	var fc = 0;
	var lpc = 0;
	var ic = 0;
	var oc = 0;

	var my_total= parseFloat(total_amount);

	if($('#is_freight_charge').is(':checked')){
		fc = $("#freight_charge").val();
		if(fc == ''){
			fc = 0;
		}
		my_total = my_total + parseFloat(fc);
	}

	if($('#is_lp_charge').is(':checked')){
		lpc = $("#lp_charge").val();
		if(lpc == ''){
			lpc = 0;
		}
		my_total = my_total + parseFloat(lpc);
	}

	if($('#is_insurance_charge').is(':checked')){
		ic = $("#insurance_charge").val();
		if(ic == ''){
			ic = 0;
		}
		my_total = my_total + parseFloat(ic);
	}

	if($('#is_other_charge').is(':checked')){
		oc = $("#other_charge").val();
		if(oc == ''){
			oc = 0;
		}
		my_total = my_total + parseFloat(oc);
	}

	$("#grand_total").val(my_total);
	var my_grand_total = $("#grand_total").val();
	var my_total_in_words = number2text(my_grand_total);
	$("#total_in_words").val(my_total_in_words);
}



function getUnit(d_id,obj){

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
			$("#unit"+d_id).append(option);
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



function getItemInfo(d_id,obj){
	var item_id = $('#item_id'+d_id).val();
	
	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/getItemInfo/"+item_id,
		"method": "GET",
		"dataType":"JSON",
		beforeSend:function(){
			$("#subcity").html("");
		},
		success:function(response){
			var unit = $('#unit'+d_id);
			var rate = $('#rate'+d_id);
			var item_value = $('#item_value'+d_id);
			var hsn_sac_no = $('#hsn_sac_no'+d_id);
			var total = $('#total'+d_id);
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

	var freight_charge = $(".freight_charge").val();
	if(freight_charge == ''){
		freight_charge = 0;
	}

	var lp_charge = $(".lp_charge").val();
	if(lp_charge == ''){
		lp_charge = 0;
	}

	var insurance_charge = $(".insurance_charge").val();
	if(insurance_charge == ''){
		insurance_charge = 0;
	}

	var other_charge = $(".other_charge").val();
	if(other_charge == ''){
		other_charge = 0;
	}

	var total_charge = parseFloat(freight_charge) + parseFloat(lp_charge) + parseFloat(insurance_charge) + parseFloat(other_charge);

	var total_tax = parseFloat(cgst_amount_sum) + parseFloat(sgst_amount_sum) + parseFloat(cess_amount_sum) + parseFloat(igst_amount_sum);
	$("#total_tax").val(parseFloat(total_tax.toFixed(2)));
	var total_amount = parseFloat(cgst_amount_sum) + parseFloat(sgst_amount_sum) + parseFloat(cess_amount_sum) + parseFloat(rate_sum) + parseFloat(igst_amount_sum);
	$("#total_amount").val(parseFloat(total_amount.toFixed(2)));
	
	var decimal = ''; var grand_total = ''; var tostring = ''; var new_grand_total = ''; var digit = '';

	grand_total = parseFloat(total_amount.toFixed(2)) + parseFloat(total_charge.toFixed(2));
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
		grand_total = parseFloat(rate_sum.toFixed(2)) + parseFloat(total_charge.toFixed(2));
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
		
		grand_total = parseFloat(total_amount.toFixed(2)) + parseFloat(total_charge.toFixed(2));
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



function saveVcdnote(){

	var data = JSON.stringify($("#invoiceForm").serializeFormJSON());

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
		"url": SERVER_NAME+"/api/saveVcdnote",
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



function updateVcdnote(){

	var data = JSON.stringify($("#invoiceForm").serializeFormJSON());
	var vcdn_id = $("#vcdn_id").val();
	
	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/updateVcdnote/"+vcdn_id,
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
			$("#update_invoice").prop('disabled', false).text('Update Note');
		}
	});
}
