<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teachbox</title>
    <link rel="stylesheet" href="{{ URL::asset('css/styles.css') }}" >
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	@if(Route::current()->getName() == 'course-lesson')
	    <link href="http://vjs.zencdn.net/4.11/video-js.css" rel="stylesheet">
	@endif
   	
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
	      	<li class="icon-list"><a href="{{ URL::action('CourseController@create')}}"><i class="fa fa-2x fa-plus"></i><span> Create Course</span></a></li>
	      	<li class="icon-list"><a href=""><i class="fa fa-2x fa-tachometer"></i><span>Tutor dashboard</span></a></li>
	        <?php 
	        $courseListIdMenu = UserCourse::where('user_id', '=', Auth::user()->id)->take(5)->get();
	        $createdList= array();
	        $joinedListMenu= array();

	        foreach ($courseListIdMenu as $userCourse)
					{
						$joinedListMenu[] = Course::find($userCourse->course_id);
					}
				

				$firstFiveJoined = array_slice($joinedListMenu, 0, 5);
				?>	   
	        <li class="heading-courses"><a href="">Enrolled courses</a></li>

	        @foreach ($firstFiveJoined as $course)
	        	@if ($course->user_id != Auth::user()->id)
			        <li class="course-list"><a href="{{ URL::action('CourseController@course', [$course->id]) }}">
			        	<img class="small-profile" src="{{ URL::asset('courses/'. $course->id . '/' . $course->pic) }}">
			        	<span>{{$course->name}}</span>
			        </a></li>
	        	@endif
	        @endforeach
	 
	      	<li><a href="{{ URL::action('ProfileController@userCourses', [Auth::user()->id]) }}">All courses</a></li>
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
        <!--<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa  fa-bell"></i></a>
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
		</li>-->
        <li class="dropdown">
	        <a href="#" class="navbar-brand profile dropdown-toggle" data-toggle="dropdown">
	        	<img src="{{ URL::asset('img/'. Auth::user()->id . '/' . getThumbName(Auth::user()->pic)) }}" />
	        </a>
			<ul class="dropdown-menu pull-right" role="menu">
				<li><a href="{{ URL::action('ProfileController@user', [Auth::user()->id]) }}"><i class="fa fa-user"></i> My profile</a></li>
				<li><a href="{{ URL::action('ProfileController@userSettings', [Auth::user()->id]) }}"><i class="fa  fa-cog"></i> Settings</a></li>
				<li><a href="{{ URL::route('sign-out') }}"><i class="fa fa-sign-out"></i>Sign out</a> </li>
			</ul>
		</li>
      </ul>
      @endif
</div>
</header>
	<div class="main">
	    @yield('content')
    </div>
	<footer class="front-page-footer after-login-footer">
		<div class="container">
				<a href="">Privacy</a>
				<a href="">Terms</a>
				<a href="">Cookies</a>
				<a href="">Advertising</a>
				<ul>
				  <li>
					<a href="https://www.facebook.com/">
						<span class="fa-stack fa-lg">
						  <i class="fa fa-circle fa-stack-2x"></i>
						  <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
						</span>
					</a>
				  </li>
				  <li>
					<a href="https://twitter.com/">
						<span class="fa-stack fa-lg">
						  <i class="fa fa-circle fa-stack-2x"></i>
						  <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
						</span>
					</a>
				  </li>
				  <li>
					<a href="#">
						<span class="fa-stack fa-lg">
						  <i class="fa fa-circle fa-stack-2x"></i>
						  <i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
						</span>
					</a>
				  </li>				 
				  <li>
					<a href="#">
						<span class="fa-stack fa-lg">
						  <i class="fa fa-circle fa-stack-2x"></i>
						  <i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
						</span>
					</a>
				  </li>
				</ul>	
				<small>All rights reserved Teachbox 2014</small>
		</div>
	</footer>
    @if(Route::current()->getName() == 'course-lesson')
		<script src="http://vjs.zencdn.net/4.11/video.js"></script>
	@endif
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
        <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
	<script>
		// tooltips
	$('.shown').tooltip({'trigger':'focus','placement' : 'top'});
	$('.shown').tooltip('show');
		//active states for inputs
		$('.settings-panel .input-group').click(function(e) {
		    e.stopPropagation();
		$('.settings-panel .input-group').removeClass('current');
		$(this).addClass('current');
		});
		$('body').click(function(e) {
		$('.settings-panel .input-group').removeClass('current');
			});

		//sticky navigation
	    $(function() {
		 	var sticky_navigation_offset_top = $('.tabs-profile').offset().top;
		    var sticky_navigation = function(){
		    var scroll_top = $(window).scrollTop(); 
		        if (scroll_top > sticky_navigation_offset_top) { 
		            $('.tabs-profile').css({ 'position': 'fixed', 'top':53, 'left':0, 'z-index':9995 });
		        } else {
		            $('.tabs-profile').css({ 'position': 'relative', 'top':0 }); 
		        }   
		    };
		    sticky_navigation();
		    $(window).scroll(function() {
		         sticky_navigation();
		    });
		});
	    // thumbnail fix
		var $span = $(".course.two-in-line");
		for (var i = 0; i < $span.length; i += 2) {
		    var $div = $("<div/>", {
		        class: 'row'
		    });
		    $span.slice(i, i + 2).wrapAll($div);
		}
		var $span = $(".student");
		for (var i = 0; i < $span.length; i += 2) {
		    var $div = $("<div/>", {
		        class: 'row'
		    });
		    $span.slice(i, i + 2).wrapAll($div);
		}
		//bootstrap tooltip conflict
		$(document).ready(function () {
		var bootstrapButton = $.fn.button.noConflict() 
		$.fn.bootstrapBtn = bootstrapButton 
		$(function () {
		  $('[data-toggle="tooltip"]').tooltip()
		})
		});

		//search suggestion
		$('#keyword').autocomplete({
				source: '/getdata',
				minLength: 1,
				select:function(e, ui){
					window.location="{{URL::to('course/" + ui.item.course_id + "')}}";
				}

		});
	//scroll to lesson in playlist div
	$('.playlist-panel .list-group').animate({
    scrollTop: $(".playlist-panel .list-group .active").offset().top
	}, 0);
	//upload path
	document.getElementById("uploadBtn").onchange = function () {
    document.getElementById("uploadFile").value = this.value;
	}


	</script>
  </body>
</html>