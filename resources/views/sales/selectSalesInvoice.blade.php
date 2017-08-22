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

<div class="train w3-agile">
	<div class="container">
		<center><h2>Select your Invoice Template</h2></center>
		<div class="about-grids" style="padding-top: 30px;">
			<div class="col-md-6 about-grid1 wow fadeInLeft animated animated" data-wow-delay="0.4s">
				<div class="latest-top">
					<div class="latest-class">
						<div class="latest-left grow">
							<img src="{{URL::asset('images/goods_invoice.png')}}" class="img-responsive" alt=""/>
						</div>
						<div class="latest-right">
							<h4>Goods invoice</h4>
						</div>
						<a href="../goodsSalesInvoice/{{encrypt($data)}}">
							<button type="button" class="btn btn-info btn-block" value="SEND">Create Invoice</button>
						</a>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<div class="col-md-6 about-grid wow fadeInRight animated animated" data-wow-delay="0.4s">
				<div class="latest-top">
					<div class="latest-class">
						<div class="latest-left grow">
							<img src="{{URL::asset('images/services_invoice.png')}}" class="img-responsive" alt=""/>
						</div>
						<div class="latest-right">
							<h4>Services invoice</h4>
						</div>
						<a href="../servicesSalesInvoice/{{encrypt($data)}}">
							<button type="button" class="btn btn-info btn-block" value="SEND">Create Invoice</button>
						</a>
						<div class="clearfix"></div>
					</div>
				</div>	
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>


@endsection