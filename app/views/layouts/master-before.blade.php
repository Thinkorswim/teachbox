<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teachbox</title>
    <link rel="stylesheet" href="{{ URL::asset('css/styles.css') }}" >
	<link href="{{ URL::asset('css/pe-icon-7-stroke.css" rel="stylesheet') }}" />
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  	<header>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		  <div class="container">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		        <span class="sr-only">Toggle navigation</span>
		        <span><i class="fa fa-2x fa-bars"></i></span>
		      </button>
			  <a class="navbar-brand" href="{{ URL::route('home') }}">
			    <img alt="Brand" src="{{ URL::asset('img/logo.png') }}"/>
			    teachbox
			  </a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav navbar-right navbar-before-registration">
		        <li><a href="#">Vision</a></li>
		        <li><a href="#">Testimonials</a></li>
		        <li><a href="#">Explore</a></li>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>	
	</header>
	    @yield('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
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
		$('.input-group').click(function(e) {
		    e.stopPropagation();
		$('.input-group').removeClass('current');
		$(this).addClass('current');
		});
	$('body').click(function(e) {
	$('.input-group').removeClass('current');
		});
	$(".more").click(function() {
		event.preventDefault();
    $('html,body').animate({
        scrollTop: $(".learn-screen").offset().top},
        'slow');
	});

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
   </body>
</html>