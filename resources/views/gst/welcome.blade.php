@extends('gst.layouts.main')

@section('title', 'MobiTAX GST')

@section('content')

<div class="banner wow fadeInDownBig animated animated" data-wow-delay="0.4s">
	<div class="container">
		<h2>You are now using MobiTax GST Software</h2>
	</div>
</div>

<div class="about-section w3-layouts">
	<div class="container">
		<div class="about-grids">
			<div class="about-grid1 wow fadeInLeft animated animated" data-wow-delay="0.4s">
				<div class="latest-top">
					<div class="latest-class">
						<h2>Welcome to the MobiTax GST Software</h2>
						<ul class="details">
							<li>Start by creating your own business and then create GST invoices</li>
							<li>This facility is available to you absolutely free of cost</li>
						</ul>
						<a href="business" >
							<button class="btn btn-info btn_lft" type="button">Start Now</button>
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