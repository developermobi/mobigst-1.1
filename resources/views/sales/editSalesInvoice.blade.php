@extends('gst.layouts.main')

@section('title', 'MobiTAX GST')

@section('content')

<style type="text/css">
	a:hover, a:link{
		text-decoration: none;
	}
	.error{
		display: inline-block;
		max-width: 100%;
		margin-bottom: 5px;
		font-weight: 400;
		color: #d24c2d !important;
	}
	.table .form-control{
		padding: 0px;
	}
	@media (min-width: 1200px) {
		.container {
			width: 1300px;
		}
	}
</style>

<input type="hidden" id="business_id" value="{{$data['business_id']}}">

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$(".contact_name").select2();
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd',
		});
	});
</script>

<div class="content">
	<div class="train w3-agile">
		<div class="container">
			<h2>Edit Sales Invoice</h2>
			<div class="table-responsive" style="padding-top: 20px;">
				<form id="invoiceForm" role="form">
					<input type="hidden" name="gstin_id" id="gstin_id" value="{{$data['data']['invoice_data'][0]->gstin_id}}">
					<input type="hidden" name="si_id" id="si_id" value="{{$data['data']['invoice_data'][0]->si_id}}">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Invoice Number</th>
								<th>Invoice date</th>
								<th>REF. P.O</th>
								<th>Due date</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><input type="text" class="form-control" name="invoice_no" id="invoice_no" value="{{$data['data']['invoice_data'][0]->invoice_no}}" style="text-align:center;"readonly /></td>
								<td><input type="text" class="form-control datepicker" name="invoice_date" value="{{$data['data']['invoice_data'][0]->invoice_date}}" /></td>
								<td><input type="text" class="form-control" name="reference" value="{{$data['data']['invoice_data'][0]->reference}}" /></td>
								<td><input type="text" class="form-control datepicker" name="due_date" value="{{$data['data']['invoice_data'][0]->due_date}}" /></td>
							</tr>
						</tbody>
					</table>
					<div class="row">
						<div class="col-md-6">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Customer Name</th>
									</tr> 
								</thead>
								<tbody>
									<tr>
										<td id="tddd">
											<input type="hidden" name="" id="contact_name_hidden" value="{{$data['data']['invoice_data'][0]->contact_name}}">
											<select class="form-control contact_name" name="contact_name" onchange="getContactInfo(this);">
												<option value="{{$data['data']['invoice_data'][0]->contact_name}}">{{$data['data']['invoice_data'][0]->contact_name}}</option>
											</select>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table table-bordered">
								<tr>
									<td>GSTIN</td>
									<td>Place of Supply</td>
								</tr>
								<tr>
									<td><input type="text" class="form-control" id="contact_gstin" placeholder="15 digit No." name="contact_gstin" value="{{$data['data']['invoice_data'][0]->contact_gstin}}" /></td>
									<td>
										<select class="form-control place_of_supply" name="place_of_supply" id="place_of_supply">
											<option value="{{$data['data']['invoice_data'][0]->place_of_supply}}">{{$data['data']['invoice_data'][0]->place_of_supply}}</option>
										</select>
									</td>
									<input type="hidden" id="customer_state" value="{{$data['state_name']}}">
								</tr>
							</table>
							<p>
								@if($data['data']['invoice_data'][0]->place_of_supply == '1')
								<input type="checkbox" id="same_address" checked>
								@else
								<input type="checkbox" id="same_address">
								@endif
								Shipping Address is Same as billing address</p>
							</div>
							<div class="col-md-3">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Billing Address </th>
										</tr> 
									</thead>
									<tbody>
										<tr>
											<td><input type="text" class="form-control" id="bill_address" name="bill_address" placeholder="Address" value="{{$data['data']['invoice_data'][0]->bill_address}}"></td>
										</tr>
										<tr>
											<td><input type="text" class="form-control" id="bill_pincode" name="bill_pincode" placeholder="Pincode" value="{{$data['data']['invoice_data'][0]->bill_pincode}}"></td>
										</tr>
										<tr>
											<td><input type="text" class="form-control" id="bill_city" name="bill_city" placeholder="City" value="{{$data['data']['invoice_data'][0]->bill_city}}"></td>
										</tr>
										<tr>
											<td><input type="text" class="form-control" id="bill_state" name="bill_state" placeholder="State" value="{{$data['data']['invoice_data'][0]->bill_state}}"></td>
										</tr>
										<tr>
											<td><input type="text" class="form-control" id="bill_country" name="bill_country" placeholder="Country" value="{{$data['data']['invoice_data'][0]->bill_country}}"></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-md-3">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Shipping Address</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><input type="text" class="form-control" id="sh_address" name="sh_address" placeholder="Address" value="{{$data['data']['invoice_data'][0]->sh_address}}"></td>
										</tr>
										<tr>
											<td><input type="text" class="form-control" id="sh_pincode" name="sh_pincode" placeholder="Pincode" value="{{$data['data']['invoice_data'][0]->sh_pincode}}"></td>
										</tr>
										<tr>
											<td><input type="text" class="form-control" id="sh_city" name="sh_city" placeholder="City" value="{{$data['data']['invoice_data'][0]->sh_city}}"></td>
										</tr>
										<tr>
											<td><input type="text" class="form-control" id="sh_state" name="sh_state" placeholder="State" value="{{$data['data']['invoice_data'][0]->sh_state}}"></td>
										</tr>
										<tr>
											<td><input type="text" class="form-control" id="sh_country" name="sh_country" placeholder="Country" value="{{$data['data']['invoice_data'][0]->sh_country}}"></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<table class="table table-bordered order-list">
							<thead>
								<tr>
									<!-- <th rowspan="2">SR. NO.</th> -->
									<th rowspan="2" width="20%">ITEM</th>
									<th rowspan="2">HSN/SAC</th>
									<th rowspan="2">QTY</th>
									<th rowspan="2">Cost</th>
									<th rowspan="2">Discount</th>
									<th colspan="2">CGST</th>
									<th colspan="2">SGST</th>
									<th colspan="2">IGST</th>
									<th colspan="2">CESS</th>
									<th rowspan="2">Total</th>
									<th rowspan="2">#</th>
								</tr>
								<tr>
									<th width="7%">%</th>
									<th>Amt (Rs.)</th>
									<th width="7%">%</th>
									<th>Amt (Rs.)</th>
									<th width="7%">%</th>
									<th>Amt (Rs.)</th>
									<th>%</th>
									<th>Amt (Rs.)</th>
								</tr>
							</thead>
							<tbody>
								@if(!empty($data['data']['invoice_details']))
								@foreach($data['data']['invoice_details'] as $key => $value)
								<input type="hidden" class="form-control id_no" name="id_no" id="id_no" value="{{$value->id_no}}" />
								<tr>
									<td>
										<select class="form-control item_name" name="item_name" id="item_name"  onchange="getItemInfo(this);calculateTotal(this)">
											<option value="{{$value->item_name}}">{{$value->item_name}}</option>
										</select>
									</td>
									<td><input type="text" class="form-control" name="hsn_sac_no" id="hsn_sac_no" value="{{$value->hsn_sac_no}}" /></td>
									<td><input type="text" class="form-control quantity" name="quantity" id="quantity" value="{{$value->quantity}}" onkeyup="calculateQuantity(this)"/></td>
									<td><input type="text" class="form-control rate" name="rate" id="rate" value="{{$value->rate}}" onkeyup="calculateCost(this)"/><input type="hidden" class="form-control item_value" name="item_value" id="item_value" value="{{$value->item_value}}"/></td>
									<td><input type="text" class="form-control discount" name="discount" id="discount" value="{{$value->discount}}" onkeyup="calculateDiscount(this)"/></td>
									<td>
										<select class="form-control cgst_percentage" name="cgst_percentage" id="cgst_percentage" onchange="calCgstAmount(this);">
											<option value="0" <?php if($value->cgst_percentage == '0'){echo "selected";}?> >0</option>
											<option value="0.125" <?php if($value->cgst_percentage == '0.125'){echo "selected";}?> >0.125</option>
											<option value="1.5" <?php if($value->cgst_percentage == '1.5'){echo "selected";}?> >1.5</option>
											<option value="2.5" <?php if($value->cgst_percentage == '2.5'){echo "selected";}?> >2.5</option>
											<option value="6" <?php if($value->cgst_percentage == '6'){echo "selected";}?> >6</option>
											<option value="9" <?php if($value->cgst_percentage == '9'){echo "selected";}?> >9</option>
											<option value="14" <?php if($value->cgst_percentage == '14'){echo "selected";}?> >14</option>
										</select>
									</td>
									<td><input type="text" class="form-control cgst_amount" name="cgst_amount" id="cgst_amount" value="{{$value->cgst_amount}}"/></td>
									<td>
										<select class="form-control sgst_percentage" name="sgst_percentage" id="sgst_percentage" onchange="calCgstAmount(this);">
											<option value="0" <?php if($value->sgst_percentage == '0'){echo "selected";}?> >0</option>
											<option value="0.125" <?php if($value->sgst_percentage == '0.125'){echo "selected";}?> >0.125</option>
											<option value="1.5" <?php if($value->sgst_percentage == '1.5'){echo "selected";}?> >1.5</option>
											<option value="2.5" <?php if($value->sgst_percentage == '2.5'){echo "selected";}?> >2.5</option>
											<option value="6" <?php if($value->sgst_percentage == '6'){echo "selected";}?> >6</option>
											<option value="9" <?php if($value->sgst_percentage == '9'){echo "selected";}?> >9</option>
											<option value="14" <?php if($value->sgst_percentage == '14'){echo "selected";}?> >14</option>
										</select>
									</td>
									<td><input type="text" class="form-control sgst_amount" name="sgst_amount" id="sgst_amount" value="{{$value->sgst_amount}}"/></td>
									<td>
										<select class="form-control igst_percentage" name="igst_percentage" id="igst_percentage" onchange="calCgstAmount(this);" disabled>
											<option value="0" <?php if($value->igst_percentage == '0'){echo "selected";}?> >0</option>
											<option value="0.125" <?php if($value->igst_percentage == '0.125'){echo "selected";}?> >0.125</option>
											<option value="1.5" <?php if($value->igst_percentage == '1.5'){echo "selected";}?> >1.5</option>
											<option value="2.5" <?php if($value->igst_percentage == '2.5'){echo "selected";}?> >2.5</option>
											<option value="6" <?php if($value->igst_percentage == '6'){echo "selected";}?> >6</option>
											<option value="9" <?php if($value->igst_percentage == '9'){echo "selected";}?> >9</option>
											<option value="14" <?php if($value->igst_percentage == '14'){echo "selected";}?> >14</option>
										</select>
									</td>
									<td><input type="text" class="form-control igst_amount" name="igst_amount" id="igst_amount" value="{{$value->igst_amount}}"  disabled/></td>
									<td><input type="text" class="form-control cess_percentage" name="cess_percentage" onkeyup="calculateCESS(this)" value="{{$data['data']['invoice_details'][0]->cess_percentage}}"/></td>
									<td><input type="text" class="form-control cess_amount" name="cess_amount" value="{{$value->cess_amount}}"/></td>
									<td><input type="text" class="form-control total" name="total" id="total" value="{{$value->total}}" /></td>
									<td><i class="fa fa-trash-o ibtnDel"></i></td>
								</tr>
								@endforeach
								@endif
								<tr id="t2">
									<td colspan="5">Total Inv. Val</td>
									<!-- <td><input type="text" class="form-control" name="total_discount" /></td> -->
									<td colspan="2"><input type="text" class="form-control total_cgst_amount" name="total_cgst_amount" value="{{$data['data']['invoice_data'][0]->total_cgst_amount}}" /></td>
									<td colspan="2"><input type="text" class="form-control total_sgst_amount" name="total_sgst_amount" value="{{$data['data']['invoice_data'][0]->total_sgst_amount}}" /></td>
									<td colspan="2"><input type="text" class="form-control total_igst_amount" name="total_igst_amount" value="{{$data['data']['invoice_data'][0]->total_igst_amount}}" /></td>
									<td colspan="2"><input type="text" class="form-control total_cess_amount" name="total_cess_amount" value="{{$data['data']['invoice_data'][0]->total_cess_amount}}" /></td>
									<td colspan="2"><input type="text" class="form-control" name="total_amount" id="total_amount" value="{{$data['data']['invoice_data'][0]->total_amount}}" /></td>
								</tr>
								<tr>
									<td colspan="17">
										<input type="button" id="addrow" class="btn btn-primary" onclick="createView(this);" value="Add Row" style="float: left;">
									</td>
								</tr>
								<tr>
									<td colspan="16">
										<p style="float: left;"><input type="checkbox" id="advance_setting"> Advanced Settings Reverse Charge</p>
									</td>
								</tr>
								<tr>
									<td colspan="5">Tax under Reverse Charge</td>
									<td><input type="text" class="form-control" id="tt_taxable_value" name="tt_taxable_value" value="0" /></td>
									<td colspan="2"><input type="text" class="form-control" id="tt_cgst_amount" name="tt_cgst_amount" value="0" /></td>
									<td colspan="2"><input type="text" class="form-control" id="tt_sgst_amount" name="tt_sgst_amount" value="0" /></td>
									<td colspan="2"><input type="text" class="form-control" id="tt_igst_amount" name="tt_igst_amount" value="0" /></td>
									<td colspan="2"><input type="text" class="form-control" id="tt_cess_amount" name="tt_cess_amount" value="0" /></td>
									<td colspan="2"><input type="text" class="form-control" id="tt_total" name="tt_total" /></td>
								</tr>
							</tbody>
						</table>
						<table class="table table-bordered">
							<tr>
								<td width="40%">Total In Words</td>
								<td>Taxable Amount</td>
								<td>Total Tax</td>
								<td>GRAND TOTAL</td>
							</tr>
							<tr>
								<td><input type="text" class="form-control total_in_words" name="total_in_words" id="total_in_words" value="{{$data['data']['invoice_data'][0]->total_in_words}}"/></td>
								<td><input type="text" class="form-control taxable_amount" id="taxable_amount"/></td>
								<td><input type="text" class="form-control total_tax" name="total_tax" id="total_tax" value="{{$data['data']['invoice_data'][0]->total_tax}}" /></td>
								<td><input type="text" class="form-control" name="grand_total" id="grand_total" value="{{$data['data']['invoice_data'][0]->grand_total}}"/></td>
							</tr>
						</table>
						<table class="pull-right">
							<tr>
								<td>
									<a href="javascript:void();">
										<button class="btn btn-primary" type="button">Back</button>
									</a>
								</td>
								<td>
									<a href="#">
										<button class="btn btn-success" type="button" id="update_invoice">Update Invoice</button>
									</a>
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>


	<script>
	/*$(document).ready(function() {
		createView();
	});*/

	function createView(){

		var business_id = $("#business_id").val();
		getItem(business_id);

		var new_row= '<tr>'+
		'<td>'+
		'<select class="form-control item_name" name="item_name" id="item_name"  onchange="getItemInfo(this);calculateTotal(this)">'+
		'</select>'+
		'</td>'+
		'<td><input type="text" class="form-control" name="hsn_sac_no" id="hsn_sac_no"/></td>'+
		'<td><input type="text" class="form-control quantity" name="quantity" id="quantity" value="1" onkeyup="calculateQuantity(this)"/></td>'+
		'<td><input type="text" class="form-control rate" name="rate" id="rate" value="0" onkeyup="calculateCost(this)"/><input type="hidden" class="form-control item_value" name="item_value" id="item_value" value="0"/></td>'+
		'<td><input type="text" class="form-control discount" name="discount" id="discount" value="0" onkeyup="calculateDiscount(this)"/></td>'+
		'<td>'+
		'<select class="form-control cgst_percentage" name="cgst_percentage" id="cgst_percentage" onchange="calCgstAmount(this);">'+
		'<option value="0" selected>0</option>'+
		'<option value="0.125">0.125</option>'+
		'<option value="1.5">1.5</option>'+
		'<option value="2.5">2.5</option>'+
		'<option value="6">6</option>'+
		'<option value="9">9</option>'+
		'<option value="14">14</option>'+
		'</select>'+
		'</td>'+
		'<td><input type="text" class="form-control cgst_amount" name="cgst_amount" id="cgst_amount" value="0"/></td>'+
		'<td>'+
		'<select class="form-control sgst_percentage" name="sgst_percentage" id="sgst_percentage" onchange="calCgstAmount(this);">'+
		'<option value="0" selected>0</option>'+
		'<option value="0.125">0.125</option>'+
		'<option value="1.5">1.5</option>'+
		'<option value="2.5">2.5</option>'+
		'<option value="6">6</option>'+
		'<option value="9">9</option>'+
		'<option value="14">14</option>'+
		'</select>'+
		'</td>'+
		'<td><input type="text" class="form-control sgst_amount" name="sgst_amount" id="sgst_amount" value="0"/></td>'+
		'<td>'+
		'<select class="form-control igst_percentage" name="igst_percentage" id="igst_percentage" onchange="calCgstAmount(this);" disabled>'+
		'<option value="0" selected>0</option>'+
		'<option value="0.125">0.125</option>'+
		'<option value="1.5">1.5</option>'+
		'<option value="2.5">2.5</option>'+
		'<option value="6">6</option>'+
		'<option value="9">9</option>'+
		'<option value="14">14</option>'+
		'</select>'+
		'</td>'+
		'<td><input type="text" class="form-control igst_amount" name="igst_amount" id="igst_amount" value="0"  disabled/></td>'+
		'<td><input type="text" class="form-control cess_percentage" name="cess_percentage" onkeyup="calculateCESS(this)" value="0"/></td>'+
		'<td><input type="text" class="form-control cess_amount" name="cess_amount" value="0"/></td>'+
		'<td><input type="text" class="form-control total" name="total" id="total"/></td>'+
		'<td><i class="fa fa-trash-o ibtnDel"></i></td>'+
		'</tr>';

		$("#t2").before(new_row); 

		var place_of_supply = $("#place_of_supply").val();
		var customer_state = $("#customer_state").val();

		if(place_of_supply != customer_state){
			$(".cgst_percentage").prop('disabled', true);
			$(".cgst_amount").prop('disabled', true);
			$(".sgst_percentage").prop('disabled', true);
			$(".sgst_amount").prop('disabled', true);
			$(".igst_percentage").prop('disabled', false);
			$(".igst_amount").prop('disabled', false);
		}else{
			$(".cgst_percentage").prop('disabled', false);
			$(".cgst_amount").prop('disabled', false);
			$(".sgst_percentage").prop('disabled', false);
			$(".sgst_amount").prop('disabled', false);
			$(".igst_percentage").prop('disabled', true);
			$(".igst_amount").prop('disabled', true);
		}

		$(document).ready(function() {
			$(".item_name").select2();
		});
	}

	$("table.order-list").on("click", ".ibtnDel", function (event) {
		
		var count = 0;
		$('input[name=hsn_sac_no]').each(function(){
			count++;
		});
		if(count == 1 || count < 1){
			return false;
		}
		var result = confirm("Do you want to delete this item ?");
		if (result) {
			var id_no = $("#id_no").val();
			deleteInvoiceDetail(id_no,this);

			$(this).closest("tr").remove();
			calCgstAmount(this);
			calculateTotal(this);
		}
	});

	

	$(document).ready(function() {
		$(".item_name").select2();
	});

	var place_of_supply = $("#place_of_supply").val();
	var customer_state = $("#customer_state").val();

	if(place_of_supply != customer_state){
		$(".cgst_percentage").prop('disabled', true);
		$(".cgst_amount").prop('disabled', true);
		$(".sgst_percentage").prop('disabled', true);
		$(".sgst_amount").prop('disabled', true);
		$(".igst_percentage").prop('disabled', false);
		$(".igst_amount").prop('disabled', false);
	}else{
		$(".cgst_percentage").prop('disabled', false);
		$(".cgst_amount").prop('disabled', false);
		$(".sgst_percentage").prop('disabled', false);
		$(".sgst_amount").prop('disabled', false);
		$(".igst_percentage").prop('disabled', true);
		$(".igst_amount").prop('disabled', true);
	}

	$('#place_of_supply').css('pointer-events','none');
	$('#tddd').css('pointer-events','none');
	$('#contact_gstin').css('pointer-events','none');
</script>

<script src="{{URL::asset('app/js/salesinvoice.js')}}"></script>

@endsection