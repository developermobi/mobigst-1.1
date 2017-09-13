@extends('gst.layouts.main')

@section('title', 'MobiTAX GST')

@section('content')

<style type="text/css">
	a:hover, a:link{
		text-decoration: none;
		color: #fff;
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
	<div class="container">
		<div class="row">
			<div class="col-md-10">
				<div class="breadcrumb btn-group btn-breadcrumb" style="float: left;">
					<a href="/index" class="btn btn-default"><i class="glyphicon glyphicon-home"></i> </a>
					<a href="../business" class="btn btn-default"> Business </a>
					<a href="../importcontact" class="btn btn-default"> Import Contact </a>
					<a href="javascript:void();" class="btn btn-default" onclick="window.history.go(-1); return false;"> <span style="color: #000;">Back to List</span> </a>
				</div>
			</div>
		</div>
		<div class="about-grids">
			<div class="about-grid1 wow fadeInLeft animated animated" data-wow-delay="0.4s">
				<h2 style="margin-top:0px;">Edit Customer Or Vendor</h2>
				<form id="updateCustomerForm" role="form">
					<input type="hidden" class="form-control" id="contact_id"  value="{{$data['data']['contactData'][0]->contact_id}}">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="custname">Customer Or Vendor Name:</label>
								<input type="text" class="form-control" placeholder="Customer Or Vendor Name" name="contact_name" value="{{$data['data']['contactData'][0]->contact_name}}">
							</div>
							<div class="form-group">
								<label for="gstin">GSTIN NO:</label>
								<input type="text" class="form-control" placeholder="15 digit" name="gstin_no" value="{{$data['data']['contactData'][0]->gstin_no}}">
							</div>
							<div class="form-group">
								<label for="country">Country:</label>
								<input type="text" class="form-control" placeholder="Enter Country" name="country" value="{{$data['data']['contactData'][0]->country}}">
							</div>
							<div class="form-group">
								<label for="conper">Contact Person:</label>
								<input type="text" class="form-control" placeholder="Contact Person" name="contact_person" value="{{$data['data']['contactData'][0]->contact_person}}">
							</div>
							<div class="form-group">
								<label for="pin">Pincode:</label>
								<input type="text" class="form-control" placeholder="Enter Pincode" name="pincode" value="{{$data['data']['contactData'][0]->pincode}}">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="email">Email Id:</label>
								<input type="email" class="form-control" placeholder="Email Id" name="email" value="{{$data['data']['contactData'][0]->email}}">
							</div>
							<div class="form-group">
								<label for="pan">PAN:</label>
								<input type="text" class="form-control" placeholder="Enter PAN" name="pan_no" value="{{$data['data']['contactData'][0]->pan_no}}">
							</div>
							<div class="form-group">
								<label for="state">State:</label>
								<select class="form-control state" name="">
								</select>
							</div>
							<div class="form-group">
								<label for="mob">Mobile No:</label>
								<input type="text" class="form-control" placeholder="Enter Mobile No" name="mobile_no" value="{{$data['data']['contactData'][0]->mobile_no}}">
							</div>
							<div class="form-group">
								<label for="city">City:</label>
								<input type="text" class="form-control" placeholder="Enter City" name="city" value="{{$data['data']['contactData'][0]->city}}">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="add">Address:</label>
						<textarea class="form-control" rows="5"  placeholder="Enter Address" name="address">{{$data['data']['contactData'][0]->address}}</textarea>
					</div>
					<button type="button" class="btn btn-danger">Back</button>
					<button type="button" class="btn btn-default">Cancel</button>
					<button type="button" class="btn btn-success" id="updateCustomer">Update</button>
				</form>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>

<script src="{{URL::asset('app/js/addcustomer.js')}}"></script>

@endsection