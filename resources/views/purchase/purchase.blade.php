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
</style>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>

<div class="content">
	<div class="train w3-agile">
		<div class="container">
			<h2>Purchase Invoices</h2>
			<div class="row">
				<div class="col-md-4" style="padding: 20px 14px;">
					<a href="../selectPurchaseInvoice/{{$data['gstin_id']}}">
						<button class="btn btn-success" type="button" style="float: left;"> + New Purchase Invoice</button>
					</a>
				</div>
				<div class="col-md-4">
				</div>
				<div class="col-md-4" style="padding: 20px 14px;">
					<button class="btn btn-default" type="button" data-toggle="modal" data-target="#quick" style="float: right;"> Quick Action </button>
				</div>
			</div>

			<?php
			$first_date = date('Y-m-01');
			?>

			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<tr>
						<td rowspan="2">Summary</td>
						<td>Total Transactions</td>
						<td>Total SGST</td>
						<td>Total CGST</td>
						<td>Total IGST</td>
						<td>Total Cess</td>
						<td>Total Value</td>
					</tr>
					<tr>
						@if(!empty($data['data']['total']))
						<td> {{$data['data']['total']['totalTransactions']}}</td>
						<td> <i class="fa fa-inr" aria-hidden="true"></i> {{$data['data']['total']['totalSGST']}}</td>
						<td> <i class="fa fa-inr" aria-hidden="true"></i> {{$data['data']['total']['totalCGST']}}</td>
						<td> <i class="fa fa-inr" aria-hidden="true"></i> {{$data['data']['total']['totalIGST']}}</td>
						<td> <i class="fa fa-inr" aria-hidden="true"></i> {{$data['data']['total']['totalCESS']}}</td>
						<td> <i class="fa fa-inr" aria-hidden="true"></i> {{$data['data']['total']['totalValue']}}</td>
						@else
						<td> 0</td>
						<td> <i class="fa fa-inr" aria-hidden="true"></i> 0</td>
						<td> <i class="fa fa-inr" aria-hidden="true"></i> 0</td>
						<td> <i class="fa fa-inr" aria-hidden="true"></i> 0</td>
						<td> <i class="fa fa-inr" aria-hidden="true"></i> 0</td>
						<td> <i class="fa fa-inr" aria-hidden="true"></i> 0</td>
						@endif
					</tr>
				</table>
				<table class="table table-striped table-bordered" id="example">
					<thead>
						<tr>
							<th>Invoice ID</th>
							<th>Contact</th>
							<th>Created Date</th>
							<th>Due Date</th>
							<th>Total Amount</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if(!empty($data['data']['purchaseInvoiceData']))
						@foreach($data['data']['purchaseInvoiceData'] as $key => $value)
						<tr>
							<td>{{$value->invoice_no}}</td>
							<td>{{$value->contact_name}}</td>
							<td>{{$value->invoice_date}}</td>
							<td>{{$value->due_date}}</td>
							<td> <i class="fa fa-inr" aria-hidden="true"></i> {{$value->grand_total}}</td>
							<td>
								@if($value->invoice_type == 1)
								<a class='btn btn-sm btn-info' href="viewPurchaseInvoice/{{encrypt($value->invoice_no)}}/{{encrypt($value->gstin_id)}}">View</a>
								@if($value->invoice_date >= $first_date)
								<a class='btn btn-sm btn-warning' href="editPurchaseInvoice/{{encrypt($value->invoice_no)}}/{{encrypt($value->gstin_id)}}">Edit</a>
								@endif
								@else
								<a class='btn btn-sm btn-info' href="viewServicesPurchaseInvoice/{{encrypt($value->invoice_no)}}/{{encrypt($value->gstin_id)}}">View</a>
								@if($value->invoice_date >= $first_date)
								<a class='btn btn-sm btn-warning' href="editServicesPurchaseInvoice/{{encrypt($value->invoice_no)}}/{{encrypt($value->gstin_id)}}">Edit</a>
								@endif
								@endif
								<a class='btn btn-sm btn-danger' onclick=cancelPurchaseInvoice(this); data-id='{{$value->invoice_no}}' data-attr = '{{$value->gstin_id}}'>Delete</a>
							</td>
						</tr>
						@endforeach
						@else
						<tr>
							<td colspan="7">No Invoice found. Click on add purchase invoice button to add one.</td>
						</tr>
						@endif
					</tbody>
				</table>
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
						<a href="../sales/{{$data['gstin_id']}}">
							<button type="button" class="btn btn-block btn-toolbar" style="margin: 10px 0px;" >View Sales Invoice</button>
						</a>
						<a href="../cdnote/{{$data['gstin_id']}}">
							<button type="button" class="btn btn-block btn-toolbar" style="margin: 10px 0px;">View Credit/Debit Note</button>
						</a>
						<a href="../advanceReceipt/{{$data['gstin_id']}}">
							<button type="button" class="btn btn-block btn-toolbar" style="margin: 10px 0px;">View Advance Receipt</button>
						</a>
					</div>
					<div class="col-md-6">
						<center><h3>Purchase</h3></center>
						<a href="../purchase/{{$data['gstin_id']}}">
							<button type="button" class="btn btn-block btn-toolbar" style="margin: 10px 0px;">View Purchase Invoice</button>
						</a>
						<a href="../vcdnote/{{$data['gstin_id']}}">
							<button type="button" class="btn btn-block btn-toolbar" style="margin: 10px 0px;">View Vendor Credit/Debit Note</button>
						</a>
						<a href="../advancePayment/{{$data['gstin_id']}}">
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

<script type="text/javascript">
	$(document).ready(function() {
		$('#example').DataTable({
			bFilter: false,
			bLengthChange: false,
			bInfo: false,
			aaSorting: []
		});
	} );
</script>

<script src="{{URL::asset('app/js/purchase.js')}}"></script>

@endsection