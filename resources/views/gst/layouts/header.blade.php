<script type="text/javascript">
	$(function(){
		$('#user_mail').text($.cookie('tokenEmail'));
	});
</script>

<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header wow fadeInLeft animated animated" data-wow-delay="0.4s">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/index"><img src="{{URL::asset('images/mobitaxlogo.png')}}"/></a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right wow fadeInRight animated animated" data-wow-delay="0.4s">
				<li><a class="nav-in" href="javascript:void();">Need Help ?</a></li>
				<li id="login_li" style="display: none;"><a href="login"><button type="button" class="btn btn-default">Login</button></a></li>
				<li id="signup_li" style="display: none;">
					<a href="signup"><button type="button" class="btn btn-warning"><span style="color: #fff;">Sign up</span></button></a>
				</li>
				<li id="welcome_user_li" style="display: none;">
					<button class="btn btn-danger btn-block dropdown-toggle" type="button" data-toggle="dropdown">
						<span id="user_mail"></span> <span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li><a href="javascript:void();" onclick="logout();"><span>Logout</span></a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>