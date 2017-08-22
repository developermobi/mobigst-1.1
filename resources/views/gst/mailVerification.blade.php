@extends('gst.layouts.main')

@section('title', 'MobiTAX GST')

@section('content')

<style type="text/css">
	a:hover, a:link{
		text-decoration: none;
		color: #fff;
	}
	.image-upload > input{
		display: none;
	}
	.image-upload img{
		width: 80px;
		cursor: pointer;
	}
</style>

<div class="train w3-agile">
	<div class="container">
		<div class="train-grids">
			<div class="latest-top" >
				<div class="row"  style="padding: 160px 0px;">
					<center>
						@if($data['code'] == '200')
						<span style="font-size: 30px; color: #05b902;">
							Account verification successfull.  
							<a href="../login" target="_blank">
								<button class="btn btn-success">Click here</button>
							</a>
							 to go to login page.
						</span>
						@else
						<span style="font-size: 30px; color: #f12626;">
							You have alredy verified your account. 
							<a href="../login" target="_blank">
								<button class="btn btn-success">Click here</button>
							</a>
							 to go to login page.
						</span>
						@endif
					</center>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>


@endsection