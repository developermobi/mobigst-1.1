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
							{{$data['numbers']}} items added successfully. Wait while we redirect you to another page...
						</span>
						@else
						<span style="font-size: 30px; color: #f12626;">
							Something went wrong while adding items. Please try again.
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
	var delay = 2000; 
	setTimeout(function(){ window.location = SERVER_NAME+"/importitem"; }, delay);
</script>

@endsection