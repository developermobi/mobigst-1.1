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

<div class="content">
	<div class="train w3-agile">
		<div class="container">
			<h2>Credit / Debit Notes</h2>
			<div class="row">
				<div class="col-md-4" style="padding: 20px 14px;">
					<a href="../createCdnote/{{$data['gstin_id']}}">
						<button class="btn btn-success" type="button" style="float: left;"> + New Credit / Debit Note</button>
					</a>
				</div>
				<div class="col-md-4">
				</div>
				<div class="col-md-4" style="padding: 20px 14px;">
					<button class="btn btn-default" type="button" data-toggle="modal" data-target="#quick" style="float: right;"> Quick Action </button>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<tr>
						<td rowspan="2">Summary</td>
						<td>Total Transactions</td>
						<td>Credit Note Transactions</td>
						<td>Credit Note Value</td>
						<td>Debit Note Transactions</td>
						<td>Debit Note Value</td>
					</tr>
					<tr>
						@if(!empty($data['data']['total']))
						<td> {{$data['data']['total']['totalTransactions']}}</td>
						<td>{{$data['data']['total']['creditTransaction']}}</td>
						<td> <i class="fa fa-inr" aria-hidden="true"></i> {{$data['data']['total']['creditValue']}}</td>
						<td>{{$data['data']['total']['debitTransaction']}}</td>
						<td> <i class="fa fa-inr" aria-hidden="true"></i> {{$data['data']['total']['debitValue']}}</td>
						@else
						<td> 0</td>
						<td>0</td>
						<td> <i class="fa fa-inr" aria-hidden="true"></i> 0</td>
						<td>0</td>
						<td> <i class="fa fa-inr" aria-hidden="true"></i> 0</td>
						@endif
					</tr>
				</table>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>CDN ID</th>
							<th>Contact</th>
							<th>Type</th>
							<th>Created Date</th>
							<th>Invoice No</th>
							<th>CDN Amount</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if(!empty($data['data']['creditDebitNoteData']))
						@foreach($data['data']['creditDebitNoteData'] as $key => $value)
						<tr>
							<td>{{$value->note_no}}</td>
							<td>{{$value->contact_name}}</td>
							<td>
								@if($value->note_type == 1)
								Credit
								@else
								Debit
								@endif
							</td>
							<td>{{$value->created_date}}</td>
							<td>{{$value->invoice_no}}</td>
							<td> <i class="fa fa-inr" aria-hidden="true"></i> {{$value->grand_total}}</td>
							<td>
								<a class='btn btn-sm btn-info' href="viewCdnote/{{encrypt($value->note_no)}}/{{encrypt($value->gstin_id)}}">View</a>
								<a class='btn btn-sm btn-warning' href="editCdnote/{{encrypt($value->note_no)}}/{{encrypt($value->gstin_id)}}">Edit</a>
								<a class='btn btn-sm btn-danger' onclick=cancelCdnote(this); data-id='{{$value->note_no}}' data-attr = '{{$value->gstin_id}}' >Delete</a>
							</td>
						</tr>
						@endforeach
						@else
						<tr>
							<td colspan="7">No Credit / Debit Note found. Click on add credit/debit note button to add one.</td>
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

<script src="{{URL::asset('app/js/sales.js')}}"></script>

@endsection