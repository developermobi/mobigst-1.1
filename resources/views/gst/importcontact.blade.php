@extends('gst.layouts.main')

@section('title', 'MobiTAX GST')

@section('content')

<style type="text/css">
	a:hover, a:link{
		text-decoration: none;
		color: #fff;
	}
	.image-upload > input{
		display: none;
	}
	.image-upload img{
		width: 80px;
		cursor: pointer;
	}
</style>

<div class="train w3-agile">
	<div class="container">
		<h2>Import Contacts</h2>
		<a href="addCustomer">
			<button class="btn btn-primary" type="button" style="float: left;">+ New Contact</button>
		</a>
		<a href="http://mobigst.mobisofttech.co.in:8989/files/StateList.xlsx" target="_BLANK">
			<button class="btn btn-warning" type="button" style="float: left;margin-left: 5px;">States List</button>
		</a>
		<div class="train-grids">
			<div class="latest-top" >
				<form enctype="multipart/form-data"  method="post" action="/importContactFile">
					<div class="train-grid wow fadeInLeft animated animated" data-wow-delay="0.4s"  style="padding-bottom: 30px;">
						<div class="col-md-6 about-grid1 wow fadeInLeft animated animated" data-wow-delay="0.4s">
							<label for="custname">Select Business</label>
							<select class="selectpicker form-control dynamicBusiness" name="business_id" style="width: 60%;" required>
							</select>
						</div>
						<div class="col-md-6 about-grid1 wow fadeInLeft animated animated" data-wow-delay="0.4s">
							<p>To know the structure of <strong>Contact Master</strong> </p>
							<a href="http://mobigst.mobisofttech.co.in:8989/files/contact.csv" target="_BLANK">
								<button class="btn btn-success" type="button">Download Sample File</button>
							</a>
						</div>	
						<div class="image-upload">
							<label for="file-input">
								<img src="images/csv.png"/ draggable="true">
							</label>
							<input type="file" id="file-input" name="contact_csv">
						</div>
					</div>
					<button type="submit" class="btn btn-info" id="import_file">Submit</button>
				</form>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>

<script src="{{URL::asset('app/js/addcustomer.js')}}"></script>

@endsection