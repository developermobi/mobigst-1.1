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
		<div class="about-grids">
			<div class="about-grid1 wow fadeInLeft animated animated" data-wow-delay="0.4s">
				<h2 style="padding:1em 00px;">Edit Item</h2>
				<form id="updateItemForm" role="form">
				<input type="hidden" class="form-control" placeholder="Item Type" name="item_id" id="item_id" value="{{$data['data'][0]->item_id}}">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="item_description">Item Description<span>*</span> :</label>
								<input type="text" class="form-control" placeholder="Item Description" name="item_description" value="{{$data['data'][0]->item_description}}">
							</div>
							<div class="form-group">
								<label for="item_type">Item Type:</label>
								<input type="text" class="form-control" placeholder="Item Type" name="item_type" value="{{$data['data'][0]->item_type}}">
							</div>
							<div class="form-group">
								<label for="code">Item/SKU Code:</label>
								<input type="text" class="form-control" placeholder="Item/SKU Code" name="item_sku" value="{{$data['data'][0]->item_sku}}">
							</div>
							<div class="form-group">
								<label for="purpr">Purchase Price:</label>
								<input type="text" class="form-control" placeholder="Purchase Price" name="item_purchase_price" value="{{$data['data'][0]->item_purchase_price}}">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="hsn">HSN/SAC Code:</label>
								<input type="text" class="form-control" placeholder="HSN/SAC Code" name="item_hsn_sac" value="{{$data['data'][0]->item_hsn_sac}}">
							</div>
							<div class="form-group">
								<label for="unit">Unit:</label>
								<input type="text" class="form-control" placeholder="Enter Unit" name="item_unit" value="{{$data['data'][0]->item_unit}}">
							</div>
							<div class="form-group">
								<label for="selling">Selling Price:</label>
								<input type="text" class="form-control" placeholder="Enter Selling Price" name="item_sale_price" value="{{$data['data'][0]->item_sale_price}}">
							</div>
							<div class="form-group">
								<label for="dis">Discount(%):</label>
								<input type="text" class="form-control" placeholder="Discount" name="item_discount" value="{{$data['data'][0]->item_discount}}">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="note">Item Notes:</label>
						<textarea class="form-control" rows="5" placeholder="Enter Item Notes" name="item_notes">{{$data['data'][0]->item_notes}}</textarea>
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
