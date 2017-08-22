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

<div class="about-section w3-layouts">
	<div class="container" style="padding-top: 80px;">
		<div class="about-grids">
			<div class="about-grid1 wow fadeInLeft animated animated" data-wow-delay="0.4s">
				<div class="latest-top">
					<div class="row" style="padding-bottom: 20px;">
						<div class="col-md-12">
							<a href="importcontact"><button class="btn btn-default">Import Contacts</button></a>
							<a href="importitem"><button class="btn btn-default" style="padding-left: 10px;">Import Items</button></a>
							<span style="float: right;">
								<a href="setting"><button class="btn btn-default"> <i class="fa fa-cog" aria-hidden="true"></i> Setting</button></a>
							</span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12" style="background-color: #1794b9;">
							<center>
								<h2 style="padding: 10px;">
									<a href="#" data-toggle="modal" data-target="#addBusinessModal">
										<span style="color: #fff;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add your Business</span>
									</a>
								</h2>
							</center>
						</div>
					</div>
					<div class="row">
						<div class="col-md-1">
							<b></b>
						</div>
						<div class="col-md-11">
							@if(!empty($data))
							@foreach($data as $key => $value)
							<div class="row">
								<div class="col-md-7" style="padding: 30px 10px;">
									<span style="font-size: 20px;">{{$value->name}}</span>
								</div>
								<div class="col-md-5" style="padding: 30px; float: right;">
									<button class="btn btn-success business_id"  data-toggle="modal" data-target="#addGstinModal" data-id='{{$value->business_id}}'>Add GSTIN No.</button>
									<a href="contacts/{{encrypt($value->business_id)}}">
										<button class="btn btn-warning" style="padding-left: 5px;">GSTIN Collection Summery</button>
									</a>
								</div>
								<div class="col-md-12">
									@foreach($data[$key]->details as $d_key => $d_value)
									<div id="gstn_div" style="padding: 20px 0px;">
										<div class="col-md-10" style="">
											<span style="font-size: 16px;"><b>{{$d_value->display_name}}</b> - GSTIN no. ( {{$d_value->gstin_no}} )</span>
										</div>
										<div class="col-md-2">
											<a href="select/{{encrypt($d_value->gstin_id)}}">
												<button class="btn btn-info">Work On This</button>
											</a>
										</div>
									</div>
									@endforeach
								</div>
							</div>
							@endforeach
							@else
							<div class="row"  style="padding: 30px 10px;">
								<center>
									<h3>No business added. Click on add business to add.</h3>
								</center>
							</div>
							@endif
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>


<!-- Add Business Modal -->
<div class="modal fade" id="addBusinessModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="businessForm" role="form">
				<div class="modal-header modal-header-info">
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
					<button type="button" class="btn btn-default btn-info" id="addBusinessButton">Add</button>
					<button type="button" class="btn btn-default pull-left" id="cancelBusinessButton">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>


<!-- Add Business Modal -->
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
				<button type="button" class="btn btn-default pull-left" id="cancelGstinButton">Cancel</button>
			</div>
		</div>
	</div>
</div>

<script src="{{URL::asset('app/js/addbusiness.js')}}"></script>

<script type="text/javascript">
	$(document).on("click", ".business_id", function () {
		var business_id = $(this).data('id');
		$(".modal-body #business_id").val( business_id );
	});
</script>

@endsection