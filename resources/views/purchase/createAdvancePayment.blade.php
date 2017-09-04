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
		$(".contact_name").select2();
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
						<a href="../business" class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
						<a href="../advanceReceipt/{{encrypt($data['gstin_id'])}}" class="btn btn-default"> Advance Payment </a>
					</div>
				</div>
				<div class="col-md-2" style="padding-top: 45px;">
					<input type="button" class="btn btn-default" value="Quick Action" style="float: right;" data-toggle="modal" data-target="#quick">
				</div>
			</div>
			<h2 style="margin-top: 0px;">Create Advance Payment</h2>
			<div class="table-responsive" style="padding-top: 20px;">
				<form id="invoiceForm" role="form">
					<input type="hidden" name="gstin_id" id="gstin_id" value="{{$data['gstin_id']}}">
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
										<td><input type="text" class="form-control" name="receipt_no" value="{{$data['receipt_no']}}" style="text-align:center;" /></td>
										<td><input type="text" class="form-control datepicker" placeholder="Date" name="receipt_date"></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-md-6">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Customer Name 
											<span style="float: right;cursor: pointer;">
												<i class="fa fa-plus-circle fa-2x" title="Add New Contact" aria-hidden="true" data-toggle="modal" data-target="#addContactModal"></i>
											</span>
										</th>
									</tr> 
								</thead>
								<tbody>
									<tr>
										<td id="tddd">
											<select class="form-control contact_name" id="contact_name" name="contact_name" onchange="getContactInfo(this);">
												<option></option>
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
									<td><input type="text" class="form-control" id="contact_gstin" placeholder="15 digit No." name="contact_gstin" /></td>
									<td>
										<select class="form-control place_of_supply" name="place_of_supply" id="place_of_supply">
										</select>
									</td>
									<input type="hidden" id="customer_state" value="{{$data['state_name']}}">
								</tr>
							</table>
						</div>
					</div>
					<table class="table table-bordered order-list" style="margin-top: 10px;">
						<thead>
							<tr>
								<!-- <th rowspan="2">SR. NO.</th> -->
								<th rowspan="2" width="20%"> ITEM 
									<span style="float: right;cursor: pointer;">
										<i class="fa fa-plus-circle fa-2x" title="Add New Item" aria-hidden="true" data-toggle="modal" data-target="#addItemModal"></i>
									</span>
								</th>
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
							<tr id="t2">
								<td colspan="5">Total Inv. Val</td>
								<!-- <td><input type="text" class="form-control" name="total_discount" /></td> -->
								<td colspan="2"><input type="text" class="form-control total_cgst_amount" name="total_cgst_amount" value="0" /></td>
								<td colspan="2"><input type="text" class="form-control total_sgst_amount" name="total_sgst_amount" value="0" /></td>
								<td colspan="2"><input type="text" class="form-control total_igst_amount" name="total_igst_amount" value="0" /></td>
								<td colspan="2"><input type="text" class="form-control total_cess_amount" name="total_cess_amount" value="0" /></td>
								<td colspan="2"><input type="text" class="form-control" name="total_amount" id="total_amount" value="0" /></td>
							</tr>
							<tr>
								<td colspan="17">
									<input type="button" id="addrow" class="btn btn-primary" onclick="createView(this);" value="Add Row" style="float: left;">
								</td>
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
							<td><input type="text" class="form-control total_in_words" id="total_in_words" name="total_in_words" /></td>
							<td><input type="text" class="form-control taxable_amount" id="taxable_amount" /></td>
							<td><input type="text" class="form-control total_tax" id="total_tax" name="total_tax" /></td>
							<td><input type="text" class="form-control" name="grand_total" id="grand_total" /></td>
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
									<button class="btn btn-success" type="button" id="save_invoice">Save Receipt</button>
								</a>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Add Business Modal -->
<div class="modal fade" id="addContactModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header modal-header-success">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add Customer</h4>
			</div>
			<div class="modal-body">
				<form role="form" id="customerForm">
					<input type="hidden" class="form-control" name="business_id" value="{{$data['business_id']}}">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="custname">Customer Or Vendor Name:</label>
								<input type="text" class="form-control" placeholder="Customer Or Vendor Name" name="contact_name">
							</div>
							<div class="form-group">
								<label for="gstin">GSTIN NO:</label>
								<input type="text" class="form-control" placeholder="15 digit" name="gstin_no">
							</div>
							<div class="form-group">
								<label for="country">Country:</label>
								<input type="text" class="form-control" placeholder="Enter Country" name="country">
							</div>
							<div class="form-group">
								<label for="conper">Contact Person:</label>
								<input type="text" class="form-control" placeholder="Contact Person" name="contact_person">
							</div>
							<div class="form-group">
								<label for="pin">Pincode:</label>
								<input type="text" class="form-control" placeholder="Enter Pincode" name="pincode">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="email">Email Id:</label>
								<input type="email" class="form-control" placeholder="Email Id" name="email">
							</div>
							<div class="form-group">
								<label for="pan">PAN:</label>
								<input type="text" class="form-control" placeholder="Enter PAN" name="pan_no">
							</div>
							<div class="form-group">
								<label for="state">State:</label>
								<input type="text" class="form-control" placeholder="Enter State" name="state">
							</div>
							<div class="form-group">
								<label for="mob">Mobile No:</label>
								<input type="text" class="form-control" placeholder="Enter Mobile No" name="mobile_no">
							</div>
							<div class="form-group">
								<label for="city">City:</label>
								<input type="text" class="form-control" placeholder="Enter City" name="city">
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-success" id="addCustomer">Add</button>
				<button type="button" class="btn btn-default pull-left" id="cancelGstinButton">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header modal-header-success">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add Item</h4>
			</div>
			<div class="modal-body">
				<form role="form" id="itemForm">
					<input type="hidden" class="form-control" name="business_id" value="{{$data['business_id']}}">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="item_description">Item Description<span>*</span> :</label>
								<input type="text" class="form-control" placeholder="Item Description" name="item_description">
							</div>
							<div class="form-group">
								<label for="item_type">Item Type:</label>
								<input type="text" class="form-control" placeholder="Item Type" name="item_type">
							</div>
							<div class="form-group">
								<label for="code">Item/SKU Code:</label>
								<input type="text" class="form-control" placeholder="Item/SKU Code" name="item_sku">
							</div>
							<div class="form-group">
								<label for="purpr">Purchase Price:</label>
								<input type="text" class="form-control" placeholder="Purchase Price" name="item_purchase_price">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="hsn">HSN/SAC Code:</label>
								<input type="text" class="form-control" placeholder="HSN/SAC Code" name="item_hsn_sac">
							</div>
							<div class="form-group">
								<label for="unit">Unit:</label>
								<input type="text" class="form-control" placeholder="Enter Unit" name="item_unit">
							</div>
							<div class="form-group">
								<label for="selling">Selling Price:</label>
								<input type="text" class="form-control" placeholder="Enter Selling Price" name="item_sale_price">
							</div>
							
							<div class="form-group">
								<label for="dis">Discount(%):</label>
								<input type="text" class="form-control" placeholder="Discount" name="item_discount">
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-success" id="addItem">Add</button>
				<button type="button" class="btn btn-default pull-left" id="cancelGstinButton">Cancel</button>
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
						<a href="../sales/{{encrypt($data['gstin_id'])}}">
							<button type="button" class="btn btn-block btn-toolbar" style="margin: 10px 0px;" >View Sales Invoice</button>
						</a>
						<a href="../cdnote/{{encrypt($data['gstin_id'])}}">
							<button type="button" class="btn btn-block btn-toolbar" style="margin: 10px 0px;">View Credit/Debit Note</button>
						</a>
						<a href="../advanceReceipt/{{encrypt($data['gstin_id'])}}">
							<button type="button" class="btn btn-block btn-toolbar" style="margin: 10px 0px;">View Advance Receipt</button>
						</a>
					</div>
					<div class="col-md-6">
						<center><h3>Purchase</h3></center>
						<a href="../purchase/{{encrypt($data['gstin_id'])}}">
							<button type="button" class="btn btn-block btn-toolbar" style="margin: 10px 0px;">View Purchase Invoice</button>
						</a>
						<a href="../vcdnote/{{encrypt($data['gstin_id'])}}">
							<button type="button" class="btn btn-block btn-toolbar" style="margin: 10px 0px;">View Vendor Credit/Debit Note</button>
						</a>
						<a href="../advancePayment/{{encrypt($data['gstin_id'])}}">
							<button type="button" class="btn btn-block btn-toolbar" style="margin: 10px 0px;">Add an Advance Payment</button>
						</a>
					</div>
					<div class="col-md-12">
						<center><h3>Settings</h3></center>
						<a href="../contacts/{{encrypt($data['business_id'])}}">
							<button type="button" class="btn btn-block btn-toolbar" style="margin: 10px 0px;">View Contacts List</button>
						</a>
						<a href="../importitem">
							<button type="button" class="btn btn-block btn-toolbar" style="margin: 10px 0px;">View Items List</button>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		createView();	
	});

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
		$(this).closest("tr").remove();
		calCgstAmount(this);
		calculateTotal(this);
	});

	$(document).ready(function() {
		$(".item_name").select2();
	});
</script>

<script src="{{URL::asset('app/js/advancePayment.js')}}"></script>
<script src="{{URL::asset('app/js/createAll.js')}}"></script>

@endsection