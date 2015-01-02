<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teachbox</title>
    <link rel="stylesheet" href="{{ URL::asset('css/styles.css') }}" >
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  	<!--
  	<header>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		  <div class="container">
		    <div class="navbar-header">
			  <a class="navbar-brand" href="{{ URL::route('home') }}" >
			    <img alt="Brand" src="{{ URL::asset('img/logo.png') }}"/>
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
			@if(Auth::check())
		      <ul class="nav navbar-nav navbar-right sign-up">
		        <li class="search2"><a href="#"><i class="fa-2x pe-7s-search"></i></a></li>
		        <li><a href="#"><i class="fa-2x pe-7s-chat"></i></a></li>
		        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa-2x pe-7s-bell"></i><sup>1</sup></a>
					<ul class="dropdown-menu notification" role="menu">
						<li class="navbar-brand profile">
							<a href="#">
								<img alt="Brand" src="{{ URL::asset('img/ivan.jpeg') }}"/>
								<p>Ivan likes your actievment from today.</p>
							</a>
						</li>
						<li class="navbar-brand profile">
							<a href="#">
								<img alt="Brand" src="{{ URL::asset('img/ivan.jpeg') }}"/>
								<p>Ivan likes your actievment from today.</p>
							</a>
						</li>
						<a href="">All notifications</a>
					</ul>
				</li>
		        <li class="dropdown">
			        <a href="#" class="navbar-brand profile dropdown-toggle" data-toggle="dropdown">
			        	<img src="{{ URL::asset('img/'. Auth::user()->id . '/' . getThumbName(Auth::user()->pic)) }}" >
			        	<span>{{ getFirstName(Auth::user()->name) }}</span> 
			        </a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="{{ URL::action('ProfileController@user', [Auth::user()->id]) }}"><i class="pe-7s-user"></i> My profile</a></li>
						<li><a href="{{ URL::action('ProfileController@userSettings', [Auth::user()->id]) }}"><i class="pe-7s-tools"></i> Settings</a></li>
						<li><a href="{{ URL::route('sign-out') }}">Sign out</a> </li>
					</ul>
				</li>
		      </ul>
		   @endif
		  </div> 
		</nav>	
	</header>-->
<header>
	<div class="col-xs-3">
		<nav class="navbar navbar-fixed-top categories">
		   <div class="navbar-header"> 
		    <a class="navbar-brand" href="{{ URL::route('home') }}" >
			    <img alt="Brand" src="{{ URL::asset('img/logo.png') }}"/>
				<small>teachbox</small>
			</a>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		        <span class="sr-only">Toggle navigation</span>
				<i class="fa fa-2x fa-bars"></i>
				<span class="caret"></span>
		      </button>
		    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
	        <li><a href="#">Link</a></li>
	      </ul>

	    </div><!-- /.navbar-collapse -->
	</nav>
</div>
<div class="col-xs-6">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Search for...">
      <span class="input-group-btn">
        <button class="btn" type="button"><i class="fa fa-search"></i></button>
      </span>
    </div><!-- /input-group -->
</div>
<div class="col-xs-3">
	@if(Auth::check())
      <ul class="nav nav-tabs pull-right">
        <li><a href="#"><i class="fa fa-comments"></i></a></li>
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa  fa-bell"></i></a>
			<ul class="dropdown-menu notification" role="menu">
				<li class="navbar-brand profile">
					<a href="#">
						<img alt="Brand" src="{{ URL::asset('img/ivan.jpeg') }}"/>
						<p>Ivan likes your actievment from today.</p>
					</a>
				</li>
				<li class="navbar-brand profile">
					<a href="#">
						<img alt="Brand" src="{{ URL::asset('img/ivan.jpeg') }}"/>
						<p>Ivan likes your actievment from today.</p>
					</a>
				</li>
				<a href="">All notifications</a>
			</ul>
		</li>
        <li class="dropdown">
	        <a href="#" class="navbar-brand profile dropdown-toggle" data-toggle="dropdown">
	        	<img src="{{ URL::asset('img/'. Auth::user()->id . '/' . getThumbName(Auth::user()->pic)) }}" />
	        </a>
			<ul class="dropdown-menu" role="menu">
				<li><a href="{{ URL::action('ProfileController@user', [Auth::user()->id]) }}"><i class="pe-7s-user"></i> My profile</a></li>
				<li><a href="{{ URL::action('ProfileController@userSettings', [Auth::user()->id]) }}"><i class="pe-7s-tools"></i> Settings</a></li>
				<li><a href="{{ URL::route('sign-out') }}">Sign out</a> </li>
			</ul>
		</li>
      </ul>
      @endif
</div>
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
		,
	    @yield('content')
    
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
	<script>
		$(document).ready(function () {

var removeClass = true;

// when clicking the button : toggle the class, tell the background to leave it as is
$(".search2").click(function () {
    $(".mobile-form").toggleClass('visible');
    removeClass = false;
});

// when clicking the div : never remove the class
$(".mobile-form").click(function() {
    removeClass = false;
});

// when click event reaches "html" : remove class if needed, and reset flag
$("html").click(function () {
    if (removeClass) {
        $(".mobile-form").removeClass('visible');
    }
    removeClass = true;
});
		});

	</script>
  </body>
</html>