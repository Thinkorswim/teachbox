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
		<nav class="navbar navbar-default" role="navigation">
		  <div class="container">
			 <a class="centered-brand" href="#"><img src="{{ URL::asset('img/logo.png') }}"/>teachbox</a>
		  </div><!-- /.container-fluid -->
		</nav>		
	</header>
	    @yield('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
	<script>
	$(document).ready(function () {
		$('#register #password').tooltip({'trigger':'focus', 'title': 'Your password needs to be 6-20 characters','placement' : 'bottom'});
		$('#register #repeat').tooltip({'trigger':'focus', 'title': 'Repeat the password','placement' : 'bottom'});
		$('#register #mail').tooltip({'trigger':'focus', 'title': 'It will be used for your authenticaion','placement' : 'bottom'});
		$('.input-group').click(function(e) {
		    e.stopPropagation();
		$('.input-group').removeClass('current');
		$(this).addClass('current');
	});
	$('body').click(function(e) {
	$('.input-group').removeClass('current');
		});
	});
	</script>
   </body>
</html>