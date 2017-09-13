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
		<div class="about-grids" style="padding-top: 60px;">
			<div class="col-md-6 about-grid1 wow fadeInLeft animated animated" data-wow-delay="0.4s">
				<div class="latest-top">
					<div class="latest-class">
						<div class="latest-left grow">
							<img src="{{URL::asset('images/goods_invoice.png')}}" class="img-responsive" alt=""/>
						</div>
						<div class="latest-right">
							<h4>Goods Invoice</h4>
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
							<h4>Services Invoice</h4>
						</div>
						<a href="../goodsSalesInvoice/{{encrypt($data)}}">
							<button type="button" class="btn btn-info btn-block" value="SEND">Create Invoice</button>
						</a>
						<div class="clearfix"></div>
					</div>
				</div>	
			</div>
			<!-- <div class="col-md-4 about-grid wow fadeInRight animated animated" data-wow-delay="0.4s">
				<div class="latest-top">
					<div class="latest-class">
						<div class="latest-left grow">
							<img src="{{URL::asset('images/services_invoice.png')}}" class="img-responsive" alt=""/>
						</div>
						<div class="latest-right">
							<h4>Upload Invoice</h4>
						</div>
						<a href="../uploadSalesInvoice/{{encrypt($data)}}">
							<button type="button" class="btn btn-info btn-block" value="SEND">Upload Invoice</button>
						</a>
						<div class="clearfix"></div>
					</div>
				</div>	
			</div> -->
			<div class="clearfix"></div>
		</div>
	</div>
</div>


@endsection