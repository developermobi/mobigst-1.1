<!DOCTYPE HTML>
<html>
<head>
	<title>MobiTax - GST Software</title>

	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
	<link href="{{URL::asset('css/caption-hover.css')}}" rel='stylesheet' type='text/css' />
	<link href="{{URL::asset('css/mystyle.css')}}" rel='stylesheet' type='text/css' />
	<link href="{{URL::asset('css/style.css')}}" rel='stylesheet' type='text/css' />

	<link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="MobiGST" />
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<script src="{{URL::asset('js/responsiveslides.min.js')}}"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/additional-methods.min.js"></script>

	<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css" rel="stylesheet" type="text/css" media="all">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>

	<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.min.css" rel='stylesheet' type='text/css'>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.min.js"></script>

	<script src="{{URL::asset('app/js/js.cookie.js')}}"></script>
	<script src="{{URL::asset('app/js/global.js')}}"></script>

</head>
<body>

	<!-- Header start -->
	@include('gst.layouts.header') 
	<!-- Header End -->

	<!---content-->
	<div class="content">

		<!-- Main Content Start -->
		@yield('content')  
		<!-- Main Content End -->

	</div>

	<!-- Footer Start -->
	@include('gst.layouts.footer')   
	<!-- Footer End -->

</body>
</html>