<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teachbox</title>
	<link href="{{ URL::asset('css/pe-icon-7-stroke.css" rel="stylesheet') }}" />
	 <link rel="SHORTCUT ICON" href="{{ URL::asset('img/favicon.ico') }}"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet/less" type="text/css" href="{{ URL::asset('less/styles.less') }}" />
	<script>
	  less = {
	    env: "development",
	    async: false,
	    fileAsync: false,
	    poll: 1000,
	    functions: {},
	    dumpLineNumbers: "comments",
	    relativeUrls: false,
	  };
	</script>
	<link rel="stylesheet" href="{{ URL::asset('css/jquery-ui.min.css') }}" />
	<script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.3.1/less.min.js"></script>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	<header class="header-not-reg">
		<div class="col-xs-3">
			<nav class="navbar navbar-fixed-top categories">
			   <div class="navbar-header"> 
			    <a class="navbar-brand before-brand" href="{{ URL::route('home') }}" >
				    <img alt="Brand" src="{{ URL::asset('img/logo.png') }}"/>
					<small>teachbox</small>
				</a>
			    </div>
			</nav>
		</div>
		@if(Request::path() == '/')
		<div class="col-xs-9">
			<ul class="nav nav-tabs navbar-before-registration pull-right">
		        <li><a href="#">Vision</a></li>
		       <!-- <li><a href="#">Testimonials</a></li> -->
		        <li><a href="#">Explore</a></li>
			</ul>
		</div>
		@else
		<div class="col-xs-9">
			<ul class="nav nav-tabs navbar-before-registration pull-right">
		        <li><a href="{{ URL::route('home') }}">Login</a></li>
		        <li><a href="{{ URL::route('home') }}" class="btn btn-default">Register</a></li>
			</ul>
		</div>
		@endif
</header>
	    @yield('content')
	<footer class="front-page-footer">
		<div style="padding-top: 11px;" class="container">
				<a href="{{ URL::action('ProfileController@privacy')}}">Privacy</a>
				<a href="{{ URL::action('ProfileController@contacts')}}">Contacts</a>
				<a href="{{ URL::action('ProfileController@advertising')}}">Advertising</a>
				<a href="{{ URL::action('ProfileController@feedback')}}"><strong>Give us feedback</strong></a>
				<ul class="social">
				  <li>
					<a href="https://www.facebook.com/teachbox1" target="_blank">
						<span class="fa-stack fa-lg">
						  <i class="fa fa-circle fa-stack-2x"></i>
						  <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
						</span>
					</a>
				  </li>
				  <li>
					<a href="https://twitter.com/teachbox_team" target="_blank">
						<span class="fa-stack fa-lg">
						  <i class="fa fa-circle fa-stack-2x"></i>
						  <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
						</span>
					</a>
				  </li>
				  <li>
					<a href="https://www.linkedin.com/profile/view?id=404189736" target="_blank">
						<span class="fa-stack fa-lg">
						  <i class="fa fa-circle fa-stack-2x"></i>
						  <i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
						</span>
					</a>
				  </li>
				</ul>
				<small>All rights reserved Teachbox beta 2014</small>
		</div>
	</footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    	@if(($errors->has('email')) || $errors->has('name') || $errors->has('password') || $errors->has('password_again'))
	<script>
	$(document).ready(function () {
		$('.nav.nav-tabs li').removeClass('active');
		$('.tab-pane:first-child').removeClass('in active');
		$('.nav.nav-tabs .register').addClass('in active');
		$('.tab-pane.register').addClass('in active');
		$('#mistake-pass').tooltip('show');
		});
	</script>
	@endif
	<script src="{{ URL::asset('js/master-before-js.js') }}"></script>
   </body>
</html>