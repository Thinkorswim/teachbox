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
	<meta name="google-site-verification" content="_npkPq6Oypg3K_Z-AUJkW_9pvxGtTAly8asiWtDMQNI" />

	<link rel="SHORTCUT ICON" href="{{ URL::asset('img/favicon.ico') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/stylesv2.1.css') }}">
    <!--[if lt IE 9]>
      <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
 	@if(Route::current()->getName() != 'home' && Route::current()->getName() != 'password-recovery')
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
				    <div role="tabpanel" class="tab-pane in fade active">
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
		<div class="col-xs-9">
			<ul class="nav nav-tabs navbar-before-registration pull-right">
		        <li id="login-link"><a href="#" data-toggle="modal" data-target="#newModal">Login</a></li>
		        <li><a href="{{ URL::route('home') }}" class="btn btn-default">Register</a></li>
			</ul>
		</div>

</header>@endif
	    @yield('content')
 @if(Route::current()->getName() == 'home')
	<footer class="front-page-footer footer-front" style="padding:10px">
@else
	<footer class="front-page-footer">
@endif
		<div style="padding-top: 11px;" class="container">
				<a href="{{ URL::action('ProfileController@privacy')}}">Privacy</a>
				<a href="{{ URL::action('ProfileController@contacts')}}">Contacts</a>
				<a href="{{ URL::action('ProfileController@advertising')}}">Advertising</a>
				<a href="{{ URL::action('ProfileController@feedback')}}"><strong>Give us feedback</strong></a>
				<ul class="social">
				  <li>
					<a href="https://www.facebook.com/teachbox1">
						<span class="fa-stack fa-lg">
						  <i class="fa fa-circle fa-stack-2x"></i>
						  <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
						</span>
					</a>
				  </li>
				  <li>
					<a href="https://twitter.com/teachbox_team">
						<span class="fa-stack fa-lg">
						  <i class="fa fa-circle fa-stack-2x"></i>
						  <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
						</span>
					</a>
				  </li>
				  <li>
					<a href="https://www.linkedin.com/company/9336733?trk=tyah&trkInfo=idx%3A1-1-1%2CtarId%3A1425842662670%2Ctas%3Ateachbox">
						<span class="fa-stack fa-lg">
						  <i class="fa fa-circle fa-stack-2x"></i>
						  <i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
						</span>
					</a>
				  </li>
				</ul>
				<small>All rights reserved Teachbox beta 2015</small>
		</div>
	</footer>
	<style>
	.ui-autocomplete.ui-front.ui-menu.ui-widget.ui-widget-content{
		position: absolute!important;
	}
	</style>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
     @if(Route::current()->getName() == 'home')
	<script type="text/javascript">
		$(".absolute-screen").delay(2500).fadeOut("slow");
	</script>
	@endif
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
					if(ui.item.isUser == false){
						window.location="{{URL::to('course/" + ui.item.course_id + "')}}";
					}else{
					window.location="{{URL::to('user/" + ui.item.user_id + "')}}";

					}
				},
				open: function() {
				$('.course-item').first().before( "<li class='pre-menu-item'><strong>Courses:</strong></li>" );
				$( ".user-item").first().before( "<li class='pre-menu-item'><strong>People:</strong></li>");
			}
		}).autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li class=" + item.classa +">" )
        .append( "<img src='" + item.icon + "'>" + item.label )
        .appendTo( ul );
    };

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
   		$(".input__field").bind(" change keyup",function(){
    //Do something, probably with $(this).val()
    if ($(this).val() != ''){
       		$(this).parent().addClass("input--filled");
}

});

var ua = navigator.userAgent.toLowerCase();
  if (ua.indexOf('safari') != -1) {
    if (ua.indexOf('chrome') > -1) {
      $(".input__field").removeAttr('placeholder');
    } else {
    	$(".input__field").addClass("form-control");
    	$(".input__field").css('border', '1px solid #333');
    }
  }else{

  	$(".input__field").removeAttr('placeholder');
  }
	</script>
	<script>
		$('#keyword-two').autocomplete({
				source: '/get-data',
				minLength: 1,
				select:function(e, ui){
					if(ui.item.isUser == false){
						window.location="{{URL::to('course/" + ui.item.course_id + "')}}";
					}
				},
				open: function() {
				$('.course-item').first().before( "<li class='pre-menu-item'><strong>Courses:</strong></li>" );
			}
		}).autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li class=" + item.classa +">" )
        .append( "<img src='" + item.icon + "'>" + item.label )
        .appendTo( ul );
    };
	</script>
<script src="{{ URL::asset('js/classie.js')}}"></script>
		<script>
		$(document).ready(function () {
			setTimeout(
			  function()
			  {
						  if($("#input-4").val().length > 0)
							{
								$("#hooshi-start").addClass("input--filled");
							}
			  }, 500);
		});
			(function() {
				// trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
				if (!String.prototype.trim) {
					(function() {
						// Make sure we trim BOM and NBSP
						var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
						String.prototype.trim = function() {
							return this.replace(rtrim, '');
						};
					})();
				}

				[].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
					// in case the input is already filled..
					if( inputEl.value.trim() !== '' ) {
						classie.add( inputEl.parentNode, 'input--filled' );
					}
					// events:
					inputEl.addEventListener( 'focus', onInputFocus );
					inputEl.addEventListener( 'blur', onInputBlur );
				} );

				function onInputFocus( ev ) {
					classie.add( ev.target.parentNode, 'input--filled' );
				}

				function onInputBlur( ev ) {
					if( ev.target.value.trim() === '' ) {
						classie.remove( ev.target.parentNode, 'input--filled' );
					}
				}
			})();
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