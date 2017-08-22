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
						<span style="font-size: 30px; color: #f12626;">
							There is something wrong with your imported file. Plaese check sample file.
						</span>
						<br>
						<span style="font-size: 25px; color: grey;margin-top: 25px;">
							<a href="importcontact">
								<button class="btn btn-primary" type="button" onclick="history.back();">Click Here</button>
							</a> to go back to import page.
						</span>
					</center>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>

@endsection