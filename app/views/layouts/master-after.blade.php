<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teachbox</title>
    <link rel="stylesheet" href="{{ URL::asset('css/styles.css') }}" >
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
    <link href="//vjs.zencdn.net/4.11/video-js.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
   	<script src="//vjs.zencdn.net/4.11/video.js"></script>


  </head>
  <body>
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
	        <li><a href="{{ URL::action('CourseController@create')}}"> Create Course </a></li>
	      </ul>

	    </div><!-- /.navbar-collapse -->
	</nav>
</div>
<div class="col-xs-6">
	{{ Form::open(array('url' => '/search')) }}
	    <div class="input-group">
	      {{ Form::text('keyword', null, array('class' => 'form-control', 'placeholder' => 'Search for...', 'id' => 'keyword' ))}}
	      <span class="input-group-btn">
	        <button class="btn" type="submit button"><i class="fa fa-search"></i></button>
	      </span>
	    </div>
    {{ Form::close() }}
</div>

<div class="col-xs-3">
	@if(Auth::check())
      <ul class="nav nav-tabs pull-right">
        <li><a href="#"><i class="fa fa-comments"></i></a></li>
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa  fa-bell"></i></a>
			<ul class="dropdown-menu notification pull-right" role="menu">
				<li>
					<a href="#">
						<img src="{{ URL::asset('img/ivan.jpeg') }}"/>
						<p>Ivan likes your actievment from today.</p>
					</a>
				</li>
				<li>
					<a href="#">
						<img src="{{ URL::asset('img/ivan.jpeg') }}"/>
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
			<ul class="dropdown-menu pull-right" role="menu">
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
	    @yield('content')
    </div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	<script>
		$(document).ready(function () {
		var bootstrapButton = $.fn.button.noConflict() // return $.fn.button to previously assigned value
		$.fn.bootstrapBtn = bootstrapButton 
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
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

$('#keyword').autocomplete({
		source: 'getdata',
		minLength: 1,
		select:function(e, ui){

		}

	});

	</script>
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
  </body>
</html>