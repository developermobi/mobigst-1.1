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
	@if(!empty($data))
	<div class="container">
		<div class="row">
			<div class="col-md-10">
				<div class="breadcrumb btn-group btn-breadcrumb" style="float: left;">
					<a href="/index" class="btn btn-default"><i class="glyphicon glyphicon-home"></i> </a>
					<a href="../business" class="btn btn-default"> Business </a>
					<a href="../importitem" class="btn btn-default"> Import Item </a>
					<a href="../importitem" class="btn btn-default" onclick="window.history.go(-1); return false;"> Back to List </a>
				</div>
			</div>
		</div>
		<div class="about-grids">
			<div class="about-grid1 wow fadeInLeft animated animated" data-wow-delay="0.4s">
				<h2 style="margin-top: 0px;">Edit Item</h2>
				<form id="updateItemForm" role="form">
					<input type="hidden" class="form-control" placeholder="Item Type" name="item_id" id="item_id" value="{{$data['data']['item_info'][0]->item_id}}">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="item_description">Item Description</label>
								<input type="text" class="form-control" placeholder="Item Description" name="item_description" value="{{$data['data']['item_info'][0]->item_description}}">
							</div>
							<div class="form-group">
								<label for="item_type">Item Type</label>
								<select class="form-control" name="item_type">
									<option value=" "> Select Item Type</option>
									<option value="Goods" <?php if($data['data']['item_info'][0]->item_type == 'Goods'){ echo "selected"; } ?> >Goods</option>
									<option value="Services" <?php if($data['data']['item_info'][0]->item_type == 'Services'){ echo "selected"; } ?> >Services</option>
								</select>
							</div>
							<div class="form-group">
								<label for="code">Item/SKU Code</label>
								<input type="text" class="form-control" placeholder="Item/SKU Code" name="item_sku" value="{{$data['data']['item_info'][0]->item_sku}}">
							</div>
							<div class="form-group">
								<label for="purpr">Purchase Price</label>
								<input type="text" class="form-control" placeholder="Purchase Price" name="item_purchase_price" value="{{$data['data']['item_info'][0]->item_purchase_price}}">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="hsn">HSN/SAC Code</label>
								<input type="text" class="form-control" placeholder="HSN/SAC Code" name="item_hsn_sac" value="{{$data['data']['item_info'][0]->item_hsn_sac}}">
							</div>
							<div class="form-group">
								<label for="unit">Unit:</label>
								<select class="form-control unit" name="item_unit" id="unit">
									<?php
									foreach ($data['data']['units'] as $key => $value) {
										?>
										<option value="<?php echo $value->unit_name;?>" <?php if($data['data']['item_info'][0]->item_unit == $value->unit_name){ echo "selected";} ?> ><?php echo $value->unit_name;?></option>
										<?php
									}
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="selling">Selling Price</label>
								<input type="text" class="form-control" placeholder="Enter Selling Price" name="item_sale_price" value="{{$data['data']['item_info'][0]->item_sale_price}}">
							</div>
							<div class="form-group">
								<label for="note">Item Notes</label>
								<textarea class="form-control" rows="5" placeholder="Enter Item Notes" name="item_notes">{{$data['data']['item_info'][0]->item_notes}}</textarea>
							</div>
							<!-- <div class="form-group">
								<label for="dis">Discount(%)</label>
								<input type="text" class="form-control" placeholder="Discount" name="item_discount" value="{{$data['data']['item_info'][0]->item_discount}}">
							</div> -->
						</div>
					</div>
					<button type="submit" class="btn btn-success" id="updateItem">Update</button>
				</form>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	@else
	<div class="container">
		<div class="about-grids">
			<div class="about-grid1 wow fadeInLeft animated animated" data-wow-delay="0.4s">
				<center><h3>Something went wrong. Please Contact Support.</h3></center>
			</div>
		</div>
	</div>
	@endif
</div>

<script src="{{URL::asset('app/js/additem.js')}}"></script>

@endsection
