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
	table td {
		cursor: pointer;
	}
</style>

<div class="train w3-agile">
	<div class="container">
		<h2>List Of Items</h2>
		<div class="row" style="padding: 15px 0px;">
			<div class="col-md-12">
				<a href="addservices"><button class="btn btn-success" style="float: left;"> Add Item </button></a>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Item Description</th>
						<th>SKU / Item Code</th>
						<th>HNS / SAC</th>
						<th>Selling Price</th>
						<th>Purchase Price</th>
						<th>Discount (%)</th>
						<th>ACTION</th>
					</tr>
				</thead>
				<tbody>
					@if(!empty($data) && $data->count())
					@foreach($data as $key => $value)
					<tr>
						<td>{{$value->item_description}}</td>
						<td>{{$value->item_sku}}</td>
						<td>{{$value->item_hsn_sac}}</td>
						<td>{{$value->item_sale_price}}</td>
						<td>{{$value->item_purchase_price}}</td>
						<td>{{$value->item_discount}}</td>
						<td>
							<a class='btn btn-sm btn-info' href="editItem/{{encrypt($value->item_id)}}">Edit</a>
							<a class='btn btn-sm btn-danger' onclick=deleteItem(this); data-id='{{ $value->item_id }}'>Delete</a>
						</td>
					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="7">No Item found. Click on add Item button to add one.</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
		<div class="row">
			<div class="col-md-12">
				<span style="float: right;"><?php echo $data->render(); ?></span>
			</div>
		</div>
	</div>
</div>

<script src="{{URL::asset('app/js/additem.js')}}"></script>


@endsection