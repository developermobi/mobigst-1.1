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
		<div class="about-grids">
			<div class="about-grid1 wow fadeInLeft animated animated" data-wow-delay="0.4s">
				<h2 style="margin-top:1em;">Add New Customer Or Vendor</h2>
				<form id="customerForm" role="form">
					<div class="row" style="padding-top: 20px;">
						<div class="col-md-6">
							<div class="form-group">
								<label for="custname">Select Business</label>
								<select class="selectpicker form-control dynamicBusiness" name="business_id">
									
								</select>
							</div>
						</div>
					</div>
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
					<div class="form-group">
						<label for="add">Address:</label>
						<textarea class="form-control" rows="5"  placeholder="Enter Address" name="address"></textarea>
					</div>
					<button type="button" onclick="history.back();" class="btn btn-danger">Back</button>
					<!-- <button type="button" class="btn btn-default">Cancel</button> -->
					<button type="button" class="btn btn-success" id="addCustomer">Save</button>
				</form>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>

<script src="{{URL::asset('app/js/addcustomer.js')}}"></script>

@endsection