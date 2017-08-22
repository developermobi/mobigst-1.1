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
</style>

<div class="class">
	<div class="container">
		<h2>Select an action</h2>
		<div class="class-grids w3l">
			<div class="class-grid wow fadeInLeft animated animated" data-wow-delay="0.4s">
				<div class="class-top">
					<div class="col-md-4 class-left">
						<img src="{{URL::asset('images/select1.png')}}" class="img-responsive" alt=""/>
						<div class="class-text  hvr-bounce-to-bottom">
							<h4>Sales Invoices</h4>
							<p>(Outward billing)</p>
							<a href="../sales/{{$data}}">
								<button class="btn btn-danger btn-block" type="button">Work on Sales Invoices</button>
							</a>
						</div>
					</div>
					<div class="col-md-4 class-left">
						<img src="{{URL::asset('images/select2.png')}}" class="img-responsive" alt=""/>
						<div class="class-text  hvr-bounce-to-bottom">
							<h4>Purchase Invoices</h4>
							<p>(Inward supply)</p>
							<a href="../purchase/{{$data}}">
								<button class="btn btn-warning btn-block" type="button">Work on Purchase Invoices</button>
							</a>
						</div>
					</div>
					<div class="col-md-4 class-left">
						<img src="{{URL::asset('images/select3.png')}}" class="img-responsive" alt=""/>
						<div class="class-text  hvr-bounce-to-bottom">
							<h4>GST Returns</h4>
							<p>&nbsp;</p>
							<a href="javascript:void();">
								<button class="btn btn-success btn-block" type="button">Work on GST Returns</button>
							</a>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>

<script src="{{URL::asset('app/js/addbusiness.js')}}"></script>

@endsection