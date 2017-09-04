$(function(){

	/*$("#tt_taxable_value").val('0');
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
	$("#tt_total").prop('disabled', true);*/

	var gstin_id = $("#gstin_id").val();

	getInvoice(gstin_id);

	if (typeof $.cookie('token') === 'undefined' && typeof $.cookie('tokenId') === 'undefined'){
		window.location.href = SERVER_NAME;
	}

	$(".item_name").change(function(event){
		var invoice_no = $("#invoice_no").val();
		if(invoice_no == ''){
			alert('Please select invoice first');
			$(".item_name").val('');
		}else{
			$('#noedit').css('pointer-events','none');
		}
	});

	$('#advance_setting').change(function() {
		var total_cgst_amount = $(".total_cgst_amount").val();
		var total_sgst_amount = $(".total_sgst_amount").val();
		var total_igst_amount = $(".total_igst_amount").val();
		var total_cess_amount = $(".total_cess_amount").val();

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
			$("#tt_total").val(parseFloat(total_cgst_amount) + parseFloat(total_sgst_amount) + parseFloat(total_igst_amount) + parseFloat(total_cess_amount));

			$("#total_tax").val('0');

			var total_tax = parseFloat(total_cgst_amount) + parseFloat(total_sgst_amount) + parseFloat(total_igst_amount) + parseFloat(total_cess_amount);
			var total = $(".total_amount").val();

			$(".total_amount").val(parseFloat(total) - parseFloat(total_tax));
			var total_amount = $(".total_amount").val();
			$("#grand_total").val(total_amount);
			var grand_total = $("#grand_total").val();
			var total_in_words = number2text(grand_total);
			$("#total_in_words").val(total_in_words);
		}else{
			var total_tax = $("#tt_total").val();
			var grand_total = $("#grand_total").val();
			$(".total_amount").val(parseFloat(grand_total) + parseFloat(total_tax));
			$("#grand_total").val(parseFloat(grand_total) + parseFloat(total_tax));
			var new_grand_total = $("#grand_total").val();
			var total_in_words = number2text(new_grand_total);
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
		saveCdnote();
	});

	$('#update_invoice').click(function(){
		updateCdnote();
	});

});


function getInvoice(gstin){

	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/getSalesInvoice/"+gstin,
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
					option += "<option value='"+data[i].invoice_no+"' data-attr='"+data[i].si_id+"'>"+data[i].invoice_no+"</option>";
				});
			}
			$(".invoice_no").append(option);
		},
		complete:function(){
		}
	}); 
}



function getInvoiceInfo(obj){
	
	var si_id = $(obj).find(':selected').attr('data-attr');
	
	$.ajax({
		"async": false,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/getInvoiceInfo/"+si_id,
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
			var rate = $(obj).closest("tr").find("#rate");
			var item_value = $(obj).closest("tr").find("#item_value");
			var hsn_sac_no = $(obj).closest("tr").find("#hsn_sac_no");
			var total = $(obj).closest("tr").find("#total");
			if(response.code == 302){
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
	cgst_amount_element.val(cgst_amount);

	var sgst_percentage_element = $(obj).closest("tr").find(".sgst_percentage");
	var sgst_percentage = sgst_percentage_element.val();

	var sgst_amount_element = $(obj).closest("tr").find(".sgst_amount");
	var sgst_amount = (rate / 100) * sgst_percentage;
	sgst_amount_element.val(sgst_amount);

	var igst_percentage_element = $(obj).closest("tr").find(".igst_percentage");
	var igst_percentage = igst_percentage_element.val();

	var igst_amount_element = $(obj).closest("tr").find(".igst_amount");
	var igst_amount = (rate / 100) * igst_percentage;
	igst_amount_element.val(igst_amount);

	var cess_percentage_element = $(obj).closest("tr").find(".cess_percentage");
	var cess_percentage = cess_percentage_element.val();

	var cess_amount_element = $(obj).closest("tr").find(".cess_amount");
	var cess_amount = (rate / 100) * cess_percentage;
	cess_amount_element.val(cess_amount);

	var total_element = $(obj).closest("tr").find(".total");
	total_element.val(parseFloat(rate) + parseFloat(cgst_amount) + parseFloat(sgst_amount) + parseFloat(igst_amount) + parseFloat(cess_amount));

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



function calculateQuantity(obj){
	var quantity = $(obj).closest("tr").find(".quantity").val();

	if(quantity != ''){
		var item_value_element = $(obj).closest("tr").find(".item_value");
		var rate_element = $(obj).closest("tr").find(".rate");
		var rate = item_value_element.val();
		rate_element.val(rate*quantity);

		var cgst_amount_element = $(obj).closest("tr").find(".cgst_amount");
		var cgst_amount = cgst_amount_element.val();
		var new_cgst_amount = cgst_amount_element.val(cgst_amount*quantity);

		var sgst_amount_element = $(obj).closest("tr").find(".sgst_amount");
		var sgst_amount = sgst_amount_element.val();
		var new_sgst_amount = sgst_amount_element.val(sgst_amount*quantity);

		var igst_amount_element = $(obj).closest("tr").find(".igst_amount");
		var igst_amount = igst_amount_element.val();
		var new_igst_amount = igst_amount_element.val(igst_amount*quantity);

		var cess_amount_element = $(obj).closest("tr").find(".cess_amount");
		var cess_amount = cess_amount_element.val();
		var cess_igst_amount = cess_amount_element.val(cess_amount*quantity);

		calCgstAmount(obj);
		calculateTotal(obj);
	}
}



function calculateDiscount(obj){
	var discount = $(obj).closest("tr").find(".discount").val();

	if(discount != ''){
		var rate_element = $(obj).closest("tr").find(".rate");
		var rate = rate_element.val();
		var amount = (rate / 100) * discount;
		var new_rate = parseFloat(rate) - parseFloat(amount);
		rate_element.val(new_rate);

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
}



function calculateCost(obj){
	var rate = $(obj).closest("tr").find(".rate").val();

	if(rate != ''){

		var rate_element = $(obj).closest("tr").find(".rate");
		var item_value_element = $(obj).closest("tr").find(".item_value");
		rate_element.val(rate);
		item_value_element.val(rate);

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

	$(".total_cgst_amount").val(cgst_amount_sum);
	$(".total_sgst_amount").val(sgst_amount_sum);
	$(".total_igst_amount").val(igst_amount_sum);
	$(".total_cess_amount").val(cess_amount_sum);

	$("#total_tax").val(parseFloat(cgst_amount_sum) + parseFloat(sgst_amount_sum) + parseFloat(cess_amount_sum) + parseFloat(igst_amount_sum));
	$("#total_amount").val(parseFloat(cgst_amount_sum) + parseFloat(sgst_amount_sum) + parseFloat(cess_amount_sum) + parseFloat(rate_sum) + parseFloat(igst_amount_sum));
	var total_in_words = number2text($("#total_amount").val());
	$("#total_in_words").val(total_in_words);
	$("#grand_total").val(parseFloat(cgst_amount_sum) + parseFloat(sgst_amount_sum) + parseFloat(cess_amount_sum) + parseFloat(rate_sum) + parseFloat(igst_amount_sum));

	if($('#advance_setting').is(":checked")){
		$("#total_tax").val('0');
		$("#total_amount").val(parseFloat(rate_sum));
		$("#grand_total").val(parseFloat(rate_sum));
		total_in_words = number2text($("#grand_total").val());
		$("#total_in_words").val(total_in_words);

		$("#tt_cgst_amount").val(cgst_amount_sum);
		$("#tt_sgst_amount").val(sgst_amount_sum);
		$("#tt_igst_amount").val(igst_amount_sum);
		$("#tt_cess_amount").val(cess_amount_sum);
		$("#tt_total").val(parseFloat(cgst_amount_sum) + parseFloat(sgst_amount_sum) + parseFloat(igst_amount_sum) + parseFloat(cess_amount_sum));
	}else{
		$("#total_tax").val(parseFloat(cgst_amount_sum) + parseFloat(sgst_amount_sum) + parseFloat(cess_amount_sum) + parseFloat(igst_amount_sum));
		$("#total_amount").val(parseFloat(cgst_amount_sum) + parseFloat(sgst_amount_sum) + parseFloat(cess_amount_sum) + parseFloat(rate_sum) + parseFloat(igst_amount_sum));
		$("#grand_total").val(parseFloat(cgst_amount_sum) + parseFloat(sgst_amount_sum) + parseFloat(cess_amount_sum) + parseFloat(rate_sum) + parseFloat(igst_amount_sum));
		total_in_words = number2text($("#grand_total").val());
		$("#total_in_words").val(total_in_words);
	}
}



function saveCdnote(){

	var data = JSON.stringify($("#invoiceForm").serializeFormJSON());
	
	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/saveCdnote",
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



function updateCdnote(){

	var data = JSON.stringify($("#invoiceForm").serializeFormJSON());
	var cdn_id = $("#cdn_id").val();
	
	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/updateCdnote/"+cdn_id,
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
