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
					<a href="../importitem" class="btn btn-default"> Import Item </a>
				</div>
			</div>
		</div>
		<div class="about-grids">
			<div class="about-grid1 wow fadeInLeft animated animated" data-wow-delay="0.4s">
				<h2 style="margin-top: 0px;">Add New Item</h2>
				<form id="itemForm" role="form">
					<div class="row" style="padding-top: 20px;">
						<div class="col-md-6">
							<div class="form-group">
								<label for="custname">Select Business</label>
								<select class="selectpicker form-control dynamicBusiness" name="business_id" required>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="item_description">Item Description<span>*</span> :</label>
								<input type="text" class="form-control" placeholder="Item Description" name="item_description" required>
							</div>
							<div class="form-group">
								<label for="item_type">Item Type</label>
								<select class="form-control" name="item_type">
									<option value=" "> Select Item Type</option>
									<option value="Goods">Goods</option>
									<option value="Services">Services</option>
								</select>
							</div>
							<div class="form-group">
								<label for="code">Item/SKU Code</label>
								<input type="text" class="form-control" placeholder="Item/SKU Code" name="item_sku">
							</div>
							<div class="form-group">
								<label for="purpr">Purchase Price</label>
								<input type="text" class="form-control" placeholder="Purchase Price" name="item_purchase_price">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="hsn">HSN/SAC Code</label>
								<input type="text" class="form-control" placeholder="HSN/SAC Code" name="item_hsn_sac">
							</div>
							<div class="form-group">
								<label for="unit">Unit of Measurement</label>
								<select class="form-control unit" name="item_unit">
								</select>
							</div>
							<div class="form-group">
								<label for="selling">Selling Price</label>
								<input type="text" class="form-control" placeholder="Enter Selling Price" name="item_sale_price">
							</div>
							
							<div class="form-group">
								<label for="dis">Discount in <i class="fa fa-inr" aria-hidden="true"></i></label>
								<input type="text" class="form-control" placeholder="Discount" name="item_discount">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="note">Item Notes</label>
						<textarea class="form-control" rows="5"  placeholder="Enter Item Notes" name="item_notes"></textarea>
					</div>
					<button type="button" onclick="history.back();" class="btn btn-danger">Back</button>
					<button type="submit" class="btn btn-success" id="addItem">Save</button>
				</form>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>

<script src="{{URL::asset('app/js/additem.js')}}"></script>

@endsection