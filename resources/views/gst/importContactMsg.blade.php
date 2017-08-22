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
							{{$data['numbers']}} contacts added successfully. 
							<a href="importcontact">
								<button class="btn btn-primary" type="button">Click Here</button>
							</a> to go back to import page.
						</span>
						@else
						<span style="font-size: 30px; color: #f12626;">
							{{$data['message']}}<br>
							<a href="importcontact">
								<button class="btn btn-primary" type="button">Click Here</button>
							</a> to go back to import page.
						</span>
						@endif
					</center>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	/*var delay = 2000; 
	setTimeout(function(){ window.location = SERVER_NAME+"/importcontact"; }, delay);*/
	function disableF5(e) { if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault(); }
	$(document).ready(function() {
		$("body").on("contextmenu",function(){
			return false;
		});
		$(document).on("keydown", disableF5);
	});
</script>

@endsection