@extends('gst.layouts.main')

@section('title', 'MobiTAX GST')

@section('content')

<div class="train w3-agile">
	<div class="container">
		<h2>Easiest way of e-filling Income Tax Returns in India</h2>
		<div class="train-grids">
			<div class="col-md-3 train-grid wow fadeInLeft animated animated" data-wow-delay="0.4s">
				<div class="train-top hvr-bounce-to-right">
					<div class="train-img">
						<img src="{{URL::asset('images/gst1.png')}}"/>
					</div>
					<h4>GST <br> Software</h4>
					<a href="login">
						<button type="button" class="btn-block btn-info">start free trial</button>
					</a>
					<p>
						file all GST returns for your clients with automated data reconciliation No download
						requird
					</p>
				</div>
			</div>
			<div class="col-md-3 train-grid wow fadeInDownBig animated animated" data-wow-delay="0.4s">
				<div class="train-top hvr-bounce-to-right">
					<div class="train-img">
						<img src="{{URL::asset('images/gst2.png')}}"/>
					</div>
					<h4>Free GST <br>Bill book</h4>
					<a href="bill_book">
						<button type="button" class="btn-block btn-info" disabled>prepare free bills</button>
					</a>
					<p>
						prepare GST compliant invoics using GST Billbook for FREE for you and your 
						clients
					</p>
				</div>
			</div>
			<div class="col-md-3 train-grid wow fadeInUpBig animated animated" data-wow-delay="0.4s">
				<div class="train-top hvr-bounce-to-right">
					<div class="train-img">
						<img src="{{URL::asset('images/gst3.png')}}"/>
					</div>
					<h4>GST Enterprise software</h4>
					<a href="quotation">
						<button type="button" class="btn-block btn-info" disabled>get quotation</button>
					</a>
					<p>
						Cloud based GST Software for Enerprises. Simply GST Returns, generate GST compliant
						invoices & much more
					</p>
				</div>
			</div>
			<div class="col-md-3 train-grid wow fadeInRight animated animated" data-wow-delay="0.4s">
				<div class="train-top hvr-bounce-to-right">
					<div class="train-img">
						<img src="{{URL::asset('images/gst4.png')}}"/>
					</div>
					<h4>Free <br> E-filling</h4>
					<button disabled type="button" class="btn-block btn-info">start filing</button>
					<p>
						e-file your income tax return online for Free - All ITRs supported. Get done 
						in 7 min
					</p>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="train-grids">
			<div class="col-md-3 train-grid wow fadeInLeft animated animated" data-wow-delay="0.4s">
				<div class="train-top hvr-bounce-to-right">
					<div class="train-img">
						<img src="{{URL::asset('images/gst5.png')}}"/>
					</div>
					<h4>CA – Assisted<br> filling</h4>
					<button disabled type="button" class="btn-block btn-info">see plans</button>
					<p>
						get an expert CA to File Your IT Return. Phone & email Support. Plans start 
						from Rs.499
					</p>
				</div>
			</div>
			<div class="col-md-3 train-grid wow fadeInDownBig animated animated" data-wow-delay="0.4s">
				<div class="train-top hvr-bounce-to-right">
					<div class="train-img">
						<img src="{{URL::asset('images/gst6.png')}}"/>
					</div>
					<h4>File business Tax Returns</h4>
					<button disabled type="button" class="btn-block btn-info">get CA</button>
					<p>get a CA to file your business tax returns</p>
				</div>
			</div>
			<div class="col-md-3 train-grid wow fadeInUpBig animated animated" data-wow-delay="0.4s">
				<div class="train-top hvr-bounce-to-right">
					<div class="train-img">
						<img src="{{URL::asset('images/gst7.png')}}"/>
					</div>
					<h4>Save Taxes & Grow Wealth</h4>
					<button disabled type="button" class="btn-block btn-info">Invest now</button>
					<p>
						save Taxes or Grow your money by investing in our hand-picked mutual funds & ELSS
					</p>
				</div>
			</div>
			<div class="col-md-3 train-grid wow fadeInRight animated animated" data-wow-delay="0.4s">
				<div class="train-top hvr-bounce-to-right">
					<div class="train-img">
						<img src="images/gst8.png"/>
					</div>
					<h4>Startup <br> Program</h4>
					<button disabled type="button" class="btn-block btn-info">Know More</button>
					<p>A proven step-by-step framework to help you launch the next big thing</p>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>

@endsection