@extends('gst.layouts.main')

@section('title', 'MobiTAX GST')

@section('content')

<style type="text/css">
	.error{
		display: inline-block;
		max-width: 100%;
		margin-bottom: 5px;
		font-weight: 400;
		color: #d24c2d !important;
	}
</style>

<div class="benefits w3l">
	<div class="container">
		<div class="benefits-grids">
			<div class="col-md-6 about-grid1 wow fadeInLeft animated animated" data-wow-delay="0.4s">
				<div class="latest-top">
					<h4>easiest way of efiling Income Tax Returns in India</h4>
					<div class="latest-class">
						<div class="latest-left">
							<img src="{{URL::asset('images/business_type_red.png')}}" class="img-responsive" alt=""/>
						</div>
						<div class="latest-right">
							<h5>Your data is safe</h5>
							<p>
								Data security is our top priority as a tax company. 128 Bit Bank grade SSL. ISO 
								27001 data centres.
							</p>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="latest-class">
						<div class="latest-left">
							<img src="{{URL::asset('images/business_type_red.png')}}" class="img-responsive" alt=""/>
						</div>
						<div class="latest-right">
							<h5>7 minutes and done</h5>
							<p>
								Upload your Form-16. Cleartax reads it automatically. Just review and e-file in 
								7 minutes or less.
							</p>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="latest-class">
						<div class="latest-left">
							<img src="{{URL::asset('images/business_type_red.png')}}" class="img-responsive" alt=""/>
						</div>
						<div class="latest-right">
							<h5>Excellent support and expert help anytime.</h5>
							<p>Over 1000 CAs to help you. 24/7 support for resolution of your questions.</p>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<div class="col-md-6 benefits-grid1 wow fadeInRight animated animated" data-wow-delay="0.4s">
				<h4>Welcome to MobiTax GST</h4>
				<br>
				<a href="javascript:void();">
					<button class="btn btn-danger btn-block" type="button">LOGIN VIA GOOGLE</button>
				</a>
				<center><p>OR</p></center>
				<h4>Sign up with your email address</h4>
				<form id="signupForm" role="form">
					<input type="text" name="email" placeholder="Email" required>
					<input type="password" name="password" id="password" placeholder="Password" required>
					<input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
					<p style="margin-bottom: 10px;">
						By creating an account, you hereby agree to follow these <a href="javascript:void();"> terms and conditions.</a>
					</p>
					<button type="button" id="register" class="btn btn-block btn-info">Join Now</button>
				</form>
				<h4>Already have an account ? <a href="login">Login</a></h4>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>


<script src="{{URL::asset('app/js/account.js')}}"></script>

@endsection