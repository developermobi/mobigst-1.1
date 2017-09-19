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

<link href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>

<div class="train w3-agile">
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
		<h2 style="margin-top: 0px;">List Of Items</h2>
		<div class="row" style="padding: 15px 0px;">
			<div class="col-md-12">
				<a href="addservices"><button class="btn btn-success" style="float: left;"> Add Item </button></a>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-striped table-bordered item_table">
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
					@if(!empty($data))
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
	</div>
</div>

<script src="{{URL::asset('app/js/additem.js')}}"></script>
<script type="text/javascript">
	$(document).ready( function () {
		$('.item_table').DataTable();
	} );
</script>


@endsection