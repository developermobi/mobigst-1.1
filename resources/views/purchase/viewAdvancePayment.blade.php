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
	var date=new Date();
	var year=date.getFullYear();
	var month=date.getMonth();
	$(document).ready(function() {
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd',
			startDate: new Date(year, month, '01')
		});
	});
</script>

<div class="content">
	<div class="train w3-agile">
		<div class="container">
			<div class="row">
				<div class="col-md-10">
					<div class="breadcrumb btn-group btn-breadcrumb" style="float: left;">
						<a href="../../../business" class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
						<a href="../../../advancePayment/{{encrypt($data['data']['invoice_data'][0]->gstin_id)}}" class="btn btn-default"> Advance Payment </a>
					</div>
				</div>
				<div class="col-md-2" style="padding-top: 45px;">
					<a href="../../../printAdvancePayment/{{encrypt($data['data']['invoice_data'][0]->payment_no)}}" target="_BLANK">
						<input type="button" class="btn btn-default" value="Print" style="float: right;">
					</a>
					<input type="button" class="btn btn-default" value="Quick Action" style="float: right; margin-right: 10px;" data-toggle="modal" data-target="#quick">
				</div>
			</div>
			<h2 style="margin-top: 0px;"> View Advance Payment </h2>
			<div class="table-responsive" style="padding-top: 20px;">
				<input type="hidden" name="gstin_id" id="gstin_id" value="{{$data['data']['invoice_data'][0]->gstin_id}}">
				<input type="hidden" name="ap_id" id="ap_id" value="{{$data['data']['invoice_data'][0]->ap_id}}">
				<div class="row">
					<div class="col-md-6">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Advance Payment No:</th>
									<th>Advance Payment Date:</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><input type="text" class="form-control" name="payment_no" value="{{$data['data']['invoice_data'][0]->payment_no}}" style="text-align:center;" /></td>
									<td><input type="text" class="form-control datepicker" placeholder="Date" value="{{$data['data']['invoice_data'][0]->payment_date}}" name="payment_date"></td>
								</tr>
							</tbody>
						</table>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Customer Name</th>
								</tr> 
							</thead>
							<tbody>
								<tr>
									<td id="tddd">
										<input type="text" class="form-control" id="contact_name" name="contact_name" value="{{$data['data']['invoice_data'][0]->contact_name}}">
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
								<td>
									<input type="text" class="form-control" id="contact_gstin" placeholder="15 digit No." name="contact_gstin" value="{{$data['data']['invoice_data'][0]->contact_gstin}}" />
								</td>
								<td>
									<input type="text" class="form-control" id="place_of_supply" placeholder="15 digit No." name="place_of_supply" value="{{$data['data']['invoice_data'][0]->place_of_supply}}" />
								</td>
								<input type="hidden" id="customer_state" value="{{$data['state_name']}}">
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="table-responsive" style="padding-top: 20px;">
				<table class="table table-bordered order-list">
					<thead>
						<tr>
							<th rowspan="2" width="20%"> ITEM 
								<span style="float: right;cursor: pointer;">
									<i class="fa fa-plus-circle fa-2x" title="Add New Item" aria-hidden="true" data-toggle="modal" data-target="#addItemModal"></i>
								</span>
							</th>
							<th rowspan="2"><a href="javascript:void();"><i class="fa fa-question-circle-o" title="What is HSN/SAC code" aria-hidden="true"></i></a><br>HSN/SAC</th>
							<th rowspan="2">QTY</th>
							<th rowspan="2" width="5%">UOM</th>
							<th rowspan="2">Price</th>
							<th rowspan="2" class="removeDiv"> Discount in <i class="fa fa-inr" aria-hidden="true"></i></th>
							<th rowspan="2">Taxable Value</th>
							<th colspan="2">CGST </th>
							<th colspan="2">SGST </th>
							<th colspan="2">IGST </th>
							<th colspan="2">CESS</th>
							<th rowspan="2">Total</th>
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
						<tr>
							<td>
								<input type="text" class="form-control quantity" name="quantity" id="quantity" value="{{$value->item_name}}" onkeyup="calculateNew(this)"/>
							</td>
							<td><input type="text" class="form-control" name="hsn_sac_no" id="hsn_sac_no" value="{{$value->hsn_sac_no}}" /></td>
							<td><input type="text" class="form-control quantity" name="quantity" id="quantity" value="{{$value->quantity}}" onkeyup="calculateNew(this)"/></td>
							<td>
								<input type="text" class="form-control quantity" name="quantity" id="quantity" value="{{$value->unit}}" onkeyup="calculateNew(this)"/>
							</td>
							<td><input type="text" class="form-control item_value" name="item_value" id="item_value" value="{{$value->item_value}}" onkeyup="calculateNew(this)"/></td>
							<td><input type="text" class="form-control discount" name="discount" id="discount" value="{{$value->discount}}" onkeyup="calculateNew(this)"/></td>
							<td><input type="text" class="form-control rate" name="rate" id="rate" value="{{$value->rate}}"/></td>
							<td>
								<input type="text" class="form-control cgst_amount" name="cgst_amount" id="cgst_amount" value="{{$value->cgst_percentage}}"/>
							</td>
							<td><input type="text" class="form-control cgst_amount" name="cgst_amount" id="cgst_amount" value="{{$value->cgst_amount}}"/></td>
							<td>
								<input type="text" class="form-control cgst_amount" name="cgst_amount" id="cgst_amount" value="{{$value->sgst_percentage}}"/>
							</td>
							<td><input type="text" class="form-control sgst_amount" name="sgst_amount" id="sgst_amount" value="{{$value->sgst_amount}}"/></td>
							<td>
								<input type="text" class="form-control igst_amount" name="igst_amount" id="igst_amount" value="{{$value->igst_percentage}}"/>
							</td>
							<td><input type="text" class="form-control igst_amount" name="igst_amount" id="igst_amount" value="{{$value->igst_amount}}"/></td>
							<td><input type="text" class="form-control cess_percentage" name="cess_percentage" onkeyup="calculateCESS(this)" value="{{$data['data']['invoice_details'][0]->cess_percentage}}"/></td>
							<td><input type="text" class="form-control cess_amount" name="cess_amount" value="{{$value->cess_amount}}"/></td>
							<td><input type="text" class="form-control total" name="total" id="total" value="{{$value->total}}" /></td>
						</tr>
						@endforeach
						@endif
						<tr id="t2">
							<td colspan="7">Total Inv. Val</td>
							<td colspan="2"><input type="text" class="form-control total_cgst_amount" name="total_cgst_amount" value="{{$data['data']['invoice_data'][0]->total_cgst_amount}}" /></td>
							<td colspan="2"><input type="text" class="form-control total_sgst_amount" name="total_sgst_amount" value="{{$data['data']['invoice_data'][0]->total_sgst_amount}}" /></td>
							<td colspan="2"><input type="text" class="form-control total_igst_amount" name="total_igst_amount" value="{{$data['data']['invoice_data'][0]->total_igst_amount}}" /></td>
							<td colspan="2"><input type="text" class="form-control total_cess_amount" name="total_cess_amount" value="{{$data['data']['invoice_data'][0]->total_cess_amount}}" /></td>
							<td colspan="2"><input type="text" class="form-control total_amount" name="total_amount" id="total_amount" value="{{$data['data']['invoice_data'][0]->total_amount}}" /></td>
						</tr>
						@if($data['data']['invoice_data'][0]->tax_type_applied == '1')
						<tr>
							<td colspan="16">
								<p style="float: left;"><input type="checkbox" id="advance_setting" name="tax_type_applied" checked >Reverse Charge </p>
							</td>
						</tr>
						<tr>
							<td colspan="5">Tax under Reverse Charge</td>
							<td colspan="2"><input type="text" class="form-control" id="tt_cgst_amount" name="tt_cgst_amount" value="{{$data['data']['invoice_data'][0]->tt_cgst_amount}}" /></td>
							<td colspan="2"><input type="text" class="form-control" id="tt_sgst_amount" name="tt_sgst_amount" value="{{$data['data']['invoice_data'][0]->tt_sgst_amount}}" /></td>
							<td colspan="2"><input type="text" class="form-control" id="tt_igst_amount" name="tt_igst_amount" value="{{$data['data']['invoice_data'][0]->tt_igst_amount}}" /></td>
							<td colspan="2"><input type="text" class="form-control" id="tt_cess_amount" name="tt_cess_amount" value="{{$data['data']['invoice_data'][0]->tt_cess_amount}}" /></td>
							<td colspan="2"><input type="text" class="form-control" id="tt_total" name="tt_total" value="{{$data['data']['invoice_data'][0]->tt_total}}"/></td>
						</tr>
						@else
						<tr>
							<td colspan="16">
								<p style="float: left;"><input type="checkbox" id="advance_setting" name="tax_type_applied">  Reverse Charge </p>
							</td>
						</tr>
						<tr>
							<td colspan="6">Tax under Reverse Charge</td>
							<td colspan="2"><input type="text" class="form-control" id="tt_cgst_amount" name="tt_cgst_amount" value="0"/></td>
							<td colspan="2"><input type="text" class="form-control" id="tt_sgst_amount" name="tt_sgst_amount" value="0"/></td>
							<td colspan="2"><input type="text" class="form-control" id="tt_igst_amount" name="tt_igst_amount" value="0"/></td>
							<td colspan="2"><input type="text" class="form-control" id="tt_cess_amount" name="tt_cess_amount" value="0"/></td>
							<td colspan="2"><input type="text" class="form-control" id="tt_total" name="tt_total" /></td>
						</tr>
						@endif
					</tbody>
				</table>
			</div>
			<div class="table-responsive" style="padding-top: 20px;">
				<table class="table table-bordered" id="item_table2">
					<tr>
						<td>Freight Charges</td>
						<td>Loading and Packing Charges</td>
						<td>Insurance Charges</td>
						<td colspan="2">Other Charges</td>
					</tr>
					<tr>
						<td><input type="text" class="form-control freight_charge" id="freight_charge" name="freight_charge"  value="{{$data['data']['invoice_data'][0]->freight_charge}}" ></td>
						<td><input type="text" class="form-control lp_charge" id="lp_charge" name="lp_charge"  value="{{$data['data']['invoice_data'][0]->lp_charge}}" ></td>
						<td><input type="text" class="form-control insurance_charge" name="insurance_charge" id="insurance_charge"  value="{{$data['data']['invoice_data'][0]->insurance_charge}}"  ></td>
						<td><input type="text" class="form-control" id="other_charge_name" name="other_charge_name" value="{{$data['data']['invoice_data'][0]->other_charge_name}}"  placeholder="Enter Charge Name" /></td>
						<td><input type="text" class="form-control other_charge" id="other_charge" name="other_charge"  value="{{$data['data']['invoice_data'][0]->other_charge}}" ></td>
					</tr>
				</table>
				<table class="table table-bordered" id="item_table2" style="width: 25%;float: right;">
					<tr>
						<td colspan="4"><input type="checkbox" name="is_roundoff" id="is_roundoff" <?php if($data['data']['invoice_data'][0]->is_roundoff == '1'){echo "checked";}?>  > Roundoff Total</td>
					</tr>
					<tr>
						<td><input type="text" class="form-control roundoff" id="roundoff" name="roundoff" value="{{$data['data']['invoice_data'][0]->roundoff}}"/></td>
					</tr>
				</table>
				<table class="table table-bordered">
					<tr>
						<td width="40%">Total In Words</td>
						<td>Total Tax</td>
						<td>GRAND TOTAL</td>
					</tr>
					<tr>
						<td><input type="text" class="form-control total_in_words" name="total_in_words" id="total_in_words" value="{{$data['data']['invoice_data'][0]->total_in_words}}"/></td>
						<td><input type="text" class="form-control total_tax" name="total_tax" id="total_tax" value="{{$data['data']['invoice_data'][0]->total_tax}}" /></td>
						<td><input type="text" class="form-control grand_total" name="grand_total" id="grand_total" value="{{$data['data']['invoice_data'][0]->grand_total}}"/></td>
					</tr>
				</table>
				<table class="pull-right">
					<tr>
						<td>
							<a href="#">
								<button class="btn btn-success" type="button" id="update_invoice">Update Receipt</button>
							</a>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
</div>


<!-- Quick Action -->
<div class="modal fade" id="quick" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<center><h3>Sales</h3></center>
						<a href="../../../sales/{{encrypt($data['data']['invoice_data'][0]->gstin_id)}}">
							<button type="button" class="btn btn-block btn-toolbar" style="margin: 10px 0px;" >View Sales Invoice</button>
						</a>
						<a href="../../../cdnote/{{encrypt($data['data']['invoice_data'][0]->gstin_id)}}">
							<button type="button" class="btn btn-block btn-toolbar" style="margin: 10px 0px;">View Credit/Debit Note</button>
						</a>
						<a href="../../../advanceReceipt/{{encrypt($data['data']['invoice_data'][0]->gstin_id)}}">
							<button type="button" class="btn btn-block btn-toolbar" style="margin: 10px 0px;">View Advance Receipt</button>
						</a>
					</div>
					<div class="col-md-6">
						<center><h3>Purchase</h3></center>
						<a href="../../../purchase/{{encrypt($data['data']['invoice_data'][0]->gstin_id)}}">
							<button type="button" class="btn btn-block btn-toolbar" style="margin: 10px 0px;">View Purchase Invoice</button>
						</a>
						<a href="../../../vcdnote/{{encrypt($data['data']['invoice_data'][0]->gstin_id)}}">
							<button type="button" class="btn btn-block btn-toolbar" style="margin: 10px 0px;">View Vendor Credit/Debit Note</button>
						</a>
						<a href="../../../advancePayment/{{encrypt($data['data']['invoice_data'][0]->gstin_id)}}">
							<button type="button" class="btn btn-block btn-toolbar" style="margin: 10px 0px;">Add an Advance Payment</button>
						</a>
					</div>
					<div class="col-md-12">
						<center><h3>Settings</h3></center>
						<a href="../../contacts/{{encrypt($data['business_id'])}}">
							<button type="button" class="btn btn-block btn-toolbar" style="margin: 10px 0px;">View Contacts List</button>
						</a>
						<a href="../../importitem">
							<button type="button" class="btn btn-block btn-toolbar" style="margin: 10px 0px;">View Items List</button>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script>

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

	$('td').css('pointer-events','none');
</script>

<script src="{{URL::asset('app/js/editadvancePayment.js')}}"></script>
<script src="{{URL::asset('app/js/createAll.js')}}"></script>

@endsection