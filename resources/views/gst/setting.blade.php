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
	table td{
		cursor: pointer;
	}
	table tr:hover{
		background-color: #ffec65 !important;
	}
</style>

<div class="train w3-agile">
	<div class="container">
		<h2>List Of Businesses</h2>
		<div class="row" style="padding: 15px 0px;">
			<div class="col-md-12">
				<button class="btn btn-success" style="float: left;"  data-toggle="modal" data-target="#addBusinessModal"> Add Business </button>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>BUSINESS NAME</th>
						<th>PAN NUMBER</th>
						<th>ACTION</th>
					</tr>
				</thead>
				<tbody>
					@if(!empty($data['data']))
					@foreach($data['data'] as $key => $value)
					<tr>
						<td data-href="gstn/{{encrypt($value->business_id)}}">{{$value->name}}</td>
						<td data-href="gstn/{{encrypt($value->business_id)}}">{{$value->pan}}</td>
						<td>
							<a class='btn btn-sm btn-info' data-target='#editBusinessModal' data-toggle='modal' onclick='editBusiness({{$value->business_id}});'>Edit</a>
							<a class='btn btn-sm btn-danger' onclick=deleteBusiness(this); data-id='{{ $value->business_id }}'>Delete</a>
						</td>
					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="3">No Business found. Click on add business button to add one.</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>


<!-- Add Business Modal -->
<div class="modal fade" id="addBusinessModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="businessForm" role="form">
				<div class="modal-header modal-header-success">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add your business</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="name">Business Name</label>
								<input type="text" class="form-control" name="name" placeholder="Business Name" required>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="pan_no">Pan Number</label>
								<input type="text" class="form-control" name="pan_no" placeholder="Pan Number" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="gstin_no">GSTIN Number</label>
								<input type="text" class="form-control" name="gstin_no" placeholder="GSTIN Number" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="display_name">Display Name</label>
								<input type="text" class="form-control" name="display_name" placeholder="Display Name" required>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-success" id="addBusinessButton">Add</button>
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>


<!-- edit Business -->
<div class="modal fade" id="editBusinessModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header modal-header-info">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit business</h4>
			</div>
			<div class="modal-body">
				<form role="form" id="updateBusinessForm">
					<input type="hidden" class="form-control" id="business_id" value="">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="bus_name">Business Name</label>
								<input type="text" class="form-control" name="name" id="name" placeholder="Business Name">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="pan_no">PAN Number</label>
								<input type="text" class="form-control" name="pan" id="pan" placeholder="PAN Number">
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-info" id="updateBusiness" >Update Business</button>
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<script src="{{URL::asset('app/js/setting.js')}}"></script>
<script src="{{URL::asset('app/js/addbusiness.js')}}"></script>

<script type="text/javascript">
	/*$(document).on("click", ".business_id", function () {
		var business_id = $(this).data('id');
		$(".modal-body #business_id").val( business_id );
	});*/
	$('td[data-href]').on("click", function() {
		document.location = $(this).data('href');
	});
</script>

@endsection