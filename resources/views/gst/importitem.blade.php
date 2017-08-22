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
		<h2>Import Items</h2>
		<a href="addservices">
			<button class="btn btn-info" type="button" style="float: left;"> + New Item</button>
		</a>
		<button class="btn btn-warning" type="button" data-toggle="modal" data-target="#viewItem" style="float: left;margin-left: 5px;">View Items</button>
		<div class="train-grids">
			<div class="latest-top" >
				<form enctype="multipart/form-data"  method="post" action="/importItemFile">
					<div class="train-grid wow fadeInLeft animated animated" data-wow-delay="0.4s" style="padding-bottom: 30px;">
						<div class="col-md-6 about-grid1 wow fadeInLeft animated animated" data-wow-delay="0.4s">
							<label for="custname">Select Business</label>
							<select class="selectpicker form-control dynamicBusiness" name="business_id" style="width: 60%" required>
							</select>
						</div>
						<div class="col-md-6 about-grid1 wow fadeInLeft animated animated" data-wow-delay="0.4s">
							<p>To know the structure of <strong>Item Master</strong></p>
							<a href="http://mobigst.mobisofttech.co.in:8989/files/item.csv" target="_BLANK">
								<button class="btn btn-success" type="button">Download Sample File</button>
							</a>
							<a href="addservices">
								<button class="btn btn-info" type="button"> + New Item</button>
							</a>
							<button class="btn btn-warning" type="button" data-toggle="modal" data-target="#viewItem"> View Items </button>
						</div>	
						<div class="image-upload">
							<label for="file-input">
								<img src="images/csv.png"/ draggable="true">
							</label>
							<input type="file" id="file-input" name="item_csv" required>
						</div>
					</div>
					<button type="submit" class="btn btn-info" id="import_file">Submit</button>
				</form>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>


<!-- Add Business Modal -->
<div class="modal fade" id="viewItem" role="dialog">
	<div class="modal-dialog">
		<form action="/items" role="form" id="gstinForm" method="post">
			<div class="modal-content">
				<div class="modal-header modal-header-success">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">View Items</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<label for="custname">Select Business</label>
							<select class="selectpicker form-control dynamicBusiness" name="business_id" required>
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-default btn-success">View Items</button>
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>


<script src="{{URL::asset('app/js/additem.js')}}"></script>

@endsection