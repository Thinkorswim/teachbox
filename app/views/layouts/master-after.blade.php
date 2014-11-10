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
		    <div class="navbar-header">
			  <a class="navbar-brand" href="#">
			    <img alt="Brand" src="public/img/logo.png"/>
				<small>teachbox</small>
			  </a>
		    </div>
			<form class="navbar-form" role="search" method="get" id="search-form" name="search-form">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Search courses and people..." id="query" name="query" value="">
					<div class="input-group-btn">
						<button type="submit" class="btn btn-default"><i class="fa-2x pe-7s-search"></i></button>
					</div>
				</div>
			</form>
		      <ul class="nav navbar-nav navbar-right sign-up">
		        <li class="search2"><a href="#"><i class="fa-2x pe-7s-search"></i></a></li>
		        <li><a href="#"><i class="fa-2x pe-7s-chat"></i></a></li>
		        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa-2x pe-7s-bell"></i><sup>1</sup></a>
					<ul class="dropdown-menu notification" role="menu">
						<li class="navbar-brand profile">
							    <div class="col-xs-3">
									<img alt="Brand" src="public/img/ivan.jpeg"/>
								</div>
								<div class="col-xs-9">
								Ivan likes your actievment from today.
								</div>
						</li>
						<li class="navbar-brand profile">
							    <div class="col-xs-3">
									<img alt="Brand" src="public/img/ivan.jpeg"/>
								</div>
								<div class="col-xs-9">
								Ivan likes your actievment from today.
								</div>
						</li>
					</ul>
				</li>
		        <li class="dropdown">
			        <a href="#" class="navbar-brand profile dropdown-toggle" data-toggle="dropdown">
			        	<img src="{{ URL::asset('img/'. Auth::user()->id . '/' . Auth::user()->pic) }}" >
			        	<span>{{ getFirstName(Auth::user()->name) }}</span> 
			        </a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="{{ URL::action('ProfileController@user', [Auth::user()->id]) }}"><i class="pe-7s-user"></i> My profile</a></li>
						<li><a href="#"><i class="pe-7s-tools"></i> Settings</a></li>
						<li><a href="{{ URL::route('sign-out') }}">Sign out</a> </li>
					</ul>
				</li>
		      </ul>
		  </div><!-- /.container-fluid -->
		</nav>	
	</header>
	<div class="main">

				<form class="navbar-form mobile-form" role="search" method="get" id="search-form" name="search-form">	
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Search courses and people..." id="query" name="query" value="">
					<div class="input-group-btn">
						<button type="submit" class="btn btn-default"><i class="fa-2x pe-7s-search"></i></button>
					</div>
				</div>
			</form>
	
	</div>

		<li><a href="{{ URL::action('ProfileController@user', [Auth::user()->id]) }}"> Profile </a></li>
		
	    @yield('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
		<script>
	$(document).ready(function () {
$('.search2').click(function(e) {
$('.mobile-form').toggleClass('visible');
	});
	});
	</script>
  </body>
</html>