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

<div class="train w3-agile">
	<div class="container">
		<h2>List Of GSTIN's</h2>
		<div class="row" style="padding: 15px 0px;">
			<div class="col-md-12">
				<button class="btn btn-success business_id" style="float: left;"  data-toggle="modal" data-target="#addGstinModal" data-id="{{ decrypt(Request::segment(2)) }}"> Add New GSTIN </button>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>GSTIN</th>
						<th>DISPLAY NAME</th>
						<th>ACTION</th>
					</tr>
				</thead>
				<tbody>
					@if(!empty($data['data']))
					@foreach($data['data'] as $key => $value)
					<tr>
						<td>{{$value->gstin_no}}</td>
						<td>{{$value->display_name}}</td>
						<td>
							<a class='btn btn-sm btn-info' data-target='#editGstinModal' data-toggle='modal' onclick='editGstin({{$value->gstin_id}});'>Edit</a>
							<a class='btn btn-sm btn-danger' onclick=deleteGstin(this); data-id='{{ $value->gstin_id }}'>Delete</a>
						</td>
					</tr>
					@endforeach
					@else
					<tr>
						<td>No GSTIN found. Click on add gstin button to add one.</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>


<!-- Add GSTIN Modal -->
<div class="modal fade" id="addGstinModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header modal-header-success">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add GSTIN Number</h4>
			</div>
			<div class="modal-body">
				<form role="form" id="gstinForm">
					<input type="hidden" class="form-control" name="business_id" id="business_id" placeholder="GSTIN Number" value="">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="gstin_no">GSTIN Number</label>
								<input type="text" class="form-control" name="gstin_no" placeholder="GSTIN Number">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="display_name">Display Name</label>
								<input type="text" class="form-control" name="display_name" placeholder="Display Name">
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-success" id="addGstinButton">Add</button>
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>


<!-- edit Business -->
<div class="modal fade" id="editGstinModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header modal-header-info">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit GSTIN</h4>
			</div>
			<div class="modal-body">
				<form role="form" id="updateGstinForm">
					<input type="hidden" class="form-control" id="gstin_id" value="">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="gstin_no">GSTIN Number</label>
								<input type="text" class="form-control" name="gstin_no" id="gstin_no" placeholder="GSTIN Number">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="display_name">Display Name</label>
								<input type="text" class="form-control" name="display_name" id="display_name" placeholder="Display Name">
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-info" id="updateGstin" >Update GSTIN</button>
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<script src="{{URL::asset('app/js/setting.js')}}"></script>
<script src="{{URL::asset('app/js/addbusiness.js')}}"></script>

<script type="text/javascript">
	$(document).on("click", ".business_id", function () {
		var business_id = $(this).data('id');
		$(".modal-body #business_id").val( business_id );
	});
</script>

@endsection