<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') Teachbox</title>
    <meta name="description" content="@yield('description')">
	<meta name="twitter:card" value="@yield('description')">
	<meta name="twitter:image" content="@yield('fb-image')">

	<meta property="og:image" content="@yield('fb-image')"/>
	<meta property="og:title" content="@yield('title')  Teachbox"/>
	<meta property="og:description" content="@yield('description')" />
	<meta property="og:site_name" content="Teachbox - online education"/>
	<meta property="og:type"   content="website" />

	<link href="{{ URL::asset('css/pe-icon-7-stroke.css" rel="stylesheet') }}" />
	<link rel="SHORTCUT ICON" href="{{ URL::asset('img/favicon.ico') }}"/>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('css/jquery-ui.min.css') }}" />
    <!--[if lt IE 9]>
      <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
 	@if(Route::current()->getName() != 'home')
		<div class="modal fade settings-panel actions" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModal" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
	        <h4 class="modal-title" id="exampleModalLabel"> Login</h4>
	      </div>
	      <div class="modal-body">
				<div class="tab-content">	
				<!-- Login -->
				    <div role="tabpanel" class="tab-pane in active">	
						<a class="btn btn-lg btn-fb" href="{{ URL::route('fb-login') }}">
						<i class="fa fa-facebook"></i> Login with Facebook
						</a>
						<h6><span  class="line-center">or</span></h6>
						@if(Session::has('global-positive'))
						<div class="alert alert-success" role="alert">
						{{Session::get('global-positive')}}
						</div>
						@endif
						@if(Session::has('global-negative'))
						<div class="alert alert-danger" role="alert">
						{{Session::get('global-negative')}}
						</div>
						@endif
						@if($errors->has('email_s'))					
						<div id="mistake-mail" class="input-group" data-toggle="tooltip" title="{{$errors->first('email_s')}}">
						 @else
						<div class="input-group">
						 @endif	
						 <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
						{{ Form::open(['route' => 'sign-in']) }}
							 {{ Form::text('email_s', null , array('placeholder'=>'E-mail','class'=>'form-control')) }}
						</div>
						@if($errors->has('password_s'))
						<div id="mistake-pass" class="input-group" data-toggle="tooltip" title="{{$errors->first('password_s')}}">
						  @else
						<div class="input-group">
						 @endif	
						  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
						 	{{ Form::password('password_s', array('placeholder'=>'Password','class'=>'form-control')) }}
						</div>
						<div class="row">
							<div class="col-xs-6">
								<div class="checkbox">
									<label>
										 {{ Form::checkbox('remember') }} Remember me
									 </label>
								</div>
							</div>
							<div class="col-xs-6">
								<a href="{{ URL::route('password-recovery') }}">Forgot Password</a>
							</div>
						</div>
						<div class="input-group submit">
							 {{ Form::submit('Login', array('class'=>'form-control')) }}
						</div>
						{{ Form::token() }}
						{{ Form::close() }}
			</div>
	      </div>
	    </div>
	  </div>
	</div>
	</div>
@endif
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
		        <li><button type="button" data-toggle="modal" data-target="#newModal">Login</button></li>
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
					<a href="https://www.linkedin.com/company/9336733?trk=tyah&trkInfo=idx%3A1-1-1%2CtarId%3A1425842662670%2Ctas%3Ateachbox" target="_blank">
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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

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
	<script>
	$(document).ready(function () {
		$('#keyword').autocomplete({
				source: '/getdata',
				minLength: 1,
				select:function(e, ui){
					window.location="{{URL::to('course/" + ui.item.course_id + "')}}";
				}

		});

		$('#user-error').tooltip({'trigger':'focus','placement' : 'top'});
		$('#pass-error').tooltip({'trigger':'focus','placement' : 'top'});
		$('#repeat-error').tooltip({'trigger':'focus', 'placement' : 'top'});
		$('#mail-error').tooltip({'trigger':'focus', 'placement' : 'top'});
		$('#user-error').tooltip('show');
		$('#pass-error').tooltip('show');
		$('#repeat-error').tooltip('show');
		$('#mail-error').tooltip('show');
		$('#mistake-mail').tooltip({'trigger':'focus','placement' : 'top'});
		$('#mistake-pass').tooltip({'trigger':'focus','placement' : 'top'});
		$('#mistake-mail').tooltip('show');
		$('#mistake-pass').tooltip('show');
		$('.tab-register .input-group').click(function(e) {
		    e.stopPropagation();
		$('.tab-register .input-group').removeClass('current');
		$(this).addClass('current');
		});
	$('body').click(function(e) {
	$('.tab-register .input-group').removeClass('current');
		});
	$(".more").click(function() {
		event.preventDefault();
    $('html,body').animate({
        scrollTop: $(".learn-screen").offset().top},
        'slow');
	});

	// Navigation scroll to
	$(".navbar-before-registration li:first-child").click(function() {
		event.preventDefault();
    $('html,body').animate({
        scrollTop: $(".learn-screen").offset().top},
        'slow');
	});
	$(".navbar-before-registration li:nth-child(2)").click(function() {
		event.preventDefault();
    $('html,body').animate({
        scrollTop: $(".testimonials").offset().top},
        'slow');
	});

	$(".navbar-before-registration li:nth-child(3)").click(function() {
		event.preventDefault();
    $('html,body').animate({
        scrollTop: $(".explore").offset().top},
        'slow');
	});

	$(function(){
    $('.carousel').carousel({
      interval: 4000
    });
	});
	});

	</script>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-60502699-1', 'auto');
	  ga('send', 'pageview');

	</script>
   </body>
</html>