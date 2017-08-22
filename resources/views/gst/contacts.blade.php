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
	table td {
		cursor: pointer;
	}
</style>

<div class="train w3-agile">
	<div class="container">
		<h2>List Of Contacts</h2>
		<div class="table-responsive">
			<table class="table pull-right">
				<tr>
					<td>
						<a href="\importcontact"><button class="btn btn-warning" type="button">Import Customers Or Vendors</button></a>
					</td>
					<td>
						<a href="\addCustomer"><button class="btn btn-success" type="button"> + New Customer Or Vendor</button>
						</td>
					</tr>
				</table>
				<table class="table table-bordered">
					<tr>
						<td rowspan="2">GSTIN Collection Summary</td>
						<td>GSTIN requested And Received</td>
						<td>GSTIN requested Not Received </td>
						<td>GSTIN Unrequested</td>
						<!-- <td rowspan="2"><button class="btn btn-info" disabled type="button">Request Now</button></td> -->
					</tr>
					@if($data['code'] == '200')
					<tr>
						<td>{{$data['data']['received']}}</td>
						<td>{{$data['data']['requested']}}</td>
						<td>{{$data['data']['unrequested']}}</td>
					</tr>
					@else
					<tr>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					@endif
				</table>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Contact Name</th>
							<th>Pan</th>
							<th>Mobile No.</th>
							<th>State</th>
							<th>GSTIN</th>
							<th>ACTION</th>
						</tr>
					</thead>
					<tbody>
						@if($data['code'] == '200')
						@foreach($data['data']['contacts'] as $key => $value)
						<tr>
							<td>{{$value->contact_name}}</td>
							<td>{{$value->pan_no}}</td>
							<td>{{$value->mobile_no}}</td>
							<td>{{$value->state}}</td>
							<td>{{$value->gstin_no}}</td>
							<td>
								@if($value->gstin_request_status == '0')
								<a class='btn btn-sm btn-default' id="requestButton" onclick=requestInfo(this); data-id='{{ $value->contact_id }}'>Request</a>
								@elseif($value->gstin_request_status == '1')
								<a class='btn btn-sm btn-success' disabled> <i class="fa fa-check-circle" aria-hidden="true"></i> Requested</a>
								@else
								@endif
								<a class='btn btn-sm btn-info' href="/editCustomer/{{encrypt($value->contact_id)}}">Edit</a>
								<a class='btn btn-sm btn-danger' onclick=deleteContact(this); data-id='{{ $value->contact_id }}'>Delete</a>
							</td>
						</tr>
						@endforeach
						@else
						<tr>
							<td colspan="6">No contact found. Click on add customer or vendor button to add one.</td>
						</tr>
						@endif
					</tbody>
				</table>
			</div>
			<div class="row">
				<div class="col-md-12">
					@if($data['code'] == '200')
					<span style="float: right;"><?php echo $data['data']['contacts']->render(); ?></span>
					@endif
				</div>
			</div>
		</div>
	</div>

	<script src="{{URL::asset('app/js/addcustomer.js')}}"></script>


	@endsection