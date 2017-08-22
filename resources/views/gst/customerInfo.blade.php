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
		<div class="about-grids form_des">
			<div class="about-grid1 wow fadeInLeft animated animated" data-wow-delay="0.4s">
				<h2>GSTIN Details</h2>
				<form id="updateCustomerForm" role="form">

					<input type="hidden" class="form-control" id="contact_id"  value="{{$data['data'][0]->contact_id}}">
					<input type="hidden" class="form-control" name="gstin_request_status"  value="2">
					<div class="form-group">
						<label for="name">Your Name (will be associated with the business)<span>*</span> :</label>

						<input type="text" class="form-control" placeholder="Customer Or Vendor Name" name="contact_name" value="{{$data['data'][0]->contact_name}}">
					</div>
					<div class="form-group">
						<label for="email">Email ID<span>*</span> :</label>
						<input type="email" class="form-control" placeholder="Email Id" name="email" value="{{$data['data'][0]->email}}">
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="pan">PAN:</label>
								<input type="text" class="form-control" placeholder="Enter PAN" name="pan_no" value="{{$data['data'][0]->pan_no}}">
							</div>
							<div class="form-group">
								<label for="city">City:</label>
								<input type="text" class="form-control" placeholder="Enter City" name="city" value="{{$data['data'][0]->city}}">
							</div>
							<div class="form-group">
								<label for="country">Country:</label>
								<input type="text" class="form-control" placeholder="Enter Country" name="country" value="{{$data['data'][0]->country}}">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="gstin">GSTIN:</label>
								<input type="text" class="form-control" placeholder="15 digit" name="gstin_no" value="{{$data['data'][0]->gstin_no}}">
							</div>
							<div class="form-group">
								<label for="state">State:</label>
								<input type="text" class="form-control" placeholder="Enter State" name="state" value="{{$data['data'][0]->state}}">
							</div>
							<div class="form-group">
								<label for="pin">Pin Code:</label>
								<input type="text" class="form-control" placeholder="Enter Pincode" name="pincode" value="{{$data['data'][0]->pincode}}">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="add">Address:</label>
						<textarea class="form-control" rows="5"  placeholder="Enter Address" name="address">{{$data['data'][0]->address}}</textarea>
					</div>
					<button type="submit" class="btn btn-danger">Back</button>
					<button type="submit" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-success" id="updateCustomerInfo">Update</button>
				</form>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>


<script src="{{URL::asset('app/js/customerinfo.js')}}"></script>

@endsection