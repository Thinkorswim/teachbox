<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teachbox</title>
    <link rel="stylesheet" href="{{ URL::asset('css/styles.css') }}" >
	<link href="{{ URL::asset('css/pe-icon-7-stroke.css" rel="stylesheet') }}" />
	 <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	<header>
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
		<div class="col-xs-9">
			<ul class="nav nav-tabs navbar-before-registration pull-right">
		        <li><a href="#">Vision</a></li>
		        <li><a href="#">Testimonials</a></li>
		        <li><a href="#">Explore</a></li>
			</ul>
		</div>
</header>
	    @yield('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

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
   </body>
</html>