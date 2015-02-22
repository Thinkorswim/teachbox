<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') Teachbox</title>
	<meta name="description" content="@yield('description')">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('css/jquery-ui.min.css') }}" />
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	@if(Route::current()->getName() == 'course-lesson')
	    <link href="http://vjs.zencdn.net/4.11/video-js.css" rel="stylesheet">
	@endif
	<script>
        var base_url = '{{ URL::to('/') }}';
    </script>
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
	      	<li class="icon-list"><a href="{{ URL::action('ProfileController@feedback')}}"><i class="fa fa-2x fa-exchange"></i><span> Help us improve!</span></a></li>
	      	@if(Auth::check())
	      	<li class="icon-list"><a href="{{ URL::action('CourseController@create')}}"><i class="fa fa-2x fa-plus"></i><span> Create Course</span></a></li>
	      	<!-- <li class="icon-list"><a href=""><i class="fa fa-2x fa-tachometer"></i><span> Tutor dashboard</span></a></li> -->
	        <?php
	        $courseListIdMenu = UserCourse::where('user_id', '=', Auth::user()->id)->take(5)->get();
	        $createdList = Course::where('user_id', '=', Auth::user()->id)->get();
	        $joinedListMenu= array();

	        foreach ($courseListIdMenu as $userCourse)
					{
						$joinedListMenu[] = Course::find($userCourse->course_id);
					}
			?>

			@if(count($joinedListMenu) - count($createdList) > 0)
	        <li class="heading-courses"><a href="">Enrolled courses</a></li>

	        @foreach ($joinedListMenu as $course)
	        	@if ($course->user_id != Auth::user()->id)
			        <li class="course-list"><a href="{{ URL::action('CourseController@course', [$course->id]) }}">
			        	<img class="small-profile" src="{{ URL::asset('courses/'. $course->id . '/img/' . $course->pic) }}">
			        	<span>{{$course->name}}</span>
			        </a></li>
	        	@endif
	        @endforeach
	        @endif
	      	<li><a href="{{ URL::action('ProfileController@userCourses', [Auth::user()->id]) }}">All courses</a></li>
	      	@endif
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
        <li><a href="{{ URL::action('MessagesController@index') }}"><i class="fa fa-comments"></i><span class="badge"></span></a></li>
        <li class="dropdown">
	        <a href="#" class="navbar-brand profile dropdown-toggle" data-toggle="dropdown">
	        	<img id="user-pic" src="{{ URL::asset('img/'. Auth::user()->id . '/' . getThumbName(Auth::user()->pic)) }}" />
	        </a>
			<ul class="dropdown-menu pull-right" role="menu">
				<li><a href="{{ URL::action('ProfileController@user', [Auth::user()->id]) }}"><i class="fa fa-user"></i> My profile</a></li>
				<li><a href="{{ URL::action('ProfileController@userSettings', [Auth::user()->id]) }}"><i class="fa  fa-cog"></i> Settings</a></li>
				<li><a href="{{ URL::route('sign-out') }}"><i class="fa fa-sign-out"></i>Sign out</a> </li>
			</ul>
		</li>
      </ul>
		@else
			<ul class="nav nav-tabs navbar-before-registration pull-right">
		        <li><a href="{{ URL::route('home') }}">Login</a></li>
		        <li><a href="{{ URL::route('home') }}" class="btn btn-default">Register</a></li>
			</ul>
		@endif
</div>
</header>
	<div class="main">
	    @yield('content')
    </div>
	<footer class="front-page-footer after-login-footer">
		<div class="container">
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
					<a href="https://www.linkedin.com/profile/view?id=404189736">
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
    @if(Route::current()->getName() == 'course-lesson')
		<script src="http://vjs.zencdn.net/4.11/video.js"></script>
	@endif
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    @if(Route::current()->getName() == 'search' || Route::current()->getName() == 'search-front' || Route::current()->getName() == 'user-profile' || Route::current()->getName() == 'home')
    	@if((Route::current()->getName() == 'user-profile' || Route::current()->getName() == 'home') && count($timeline) >= 5)
		    <script src="{{ URL::asset('js/jquery.jscroll.min.js') }}"></script>
			    <script type="text/javascript">
					$(function() {
						$('.pagination').hide();

					    $('.scroll').jscroll({
					    	 loadingHtml: '<p class="centered"><a class="btn btn-success"href="#"><i class="fa fa-2x fa-spinner fa-pulse"></i> Loading...</a>',
					        autoTrigger: true,
					        nextSelector: '.pagination li.active + li a',
					        contentSelector: 'div.scroll',
					        callback: function() {
					            $('ul.pagination:visible:first').hide();
					        }
					    });
					});
				</script>
		@elseif(Route::current()->getName() == 'search' || Route::current()->getName() == 'search-front' && count($courses) > 5)
		    <script src="{{ URL::asset('js/jquery.jscroll.min.js') }}"></script>
			    <script type="text/javascript">
					$(function() {
						$('.pagination').hide();

					    $('.scroll').jscroll({
					    	 loadingHtml: '<p class="centered"><a class="btn btn-success"href="#"><i class="fa fa-2x fa-spinner fa-pulse"></i> Loading...</a>',
					        autoTrigger: true,
					        nextSelector: '.pagination li.active + li a',
					        contentSelector: 'div.scroll',
					        callback: function() {
					            $('ul.pagination:visible:first').hide();
					        }
					    });
					});
				</script>		
		@elseif(Route::current()->getName() == 'home'  && count($timeline) >= 5)
		    <script src="{{ URL::asset('js/jquery.jscroll.min.js') }}"></script>
			    <script type="text/javascript">
					$(function() {
						$('.pagination').hide();

					    $('.scroll').jscroll({
					    	 loadingHtml: '<p class="centered"><a class="btn btn-success"href="#"><i class="fa fa-2x fa-spinner fa-pulse"></i> Loading...</a>',
					        autoTrigger: true,
					        nextSelector: '.pagination li.active + li a',
					        contentSelector: 'div.scroll',
					        callback: function() {
					            $('ul.pagination:visible:first').hide();
					        }
					    });
					});
				</script>		
		@endif
	@endif
  <script>
	document.getElementById('uploadBtn').onchange = function (evt) {
	    var tgt = evt.target || window.event.srcElement,
	        files = tgt.files;
	    // FileReader support
	    if (FileReader && files && files.length) {
	        var fr = new FileReader();
	        fr.onload = function () {
	            document.getElementById('profile').src = fr.result;
	        };
	        fr.readAsDataURL(files[0]);
	    }
	    // Not supported
	    else {
	        // fallback -- perhaps submit the input to an iframe and temporarily store
	        // them on the server until the user's session ends.
	    }
	};
	

   </script>

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

    @if(Route::current()->getName() != 'messages')
  		<script src="{{ URL::asset('js/message-notification.min.js') }}"></script>
  	@endif

	@if(Route::current()->getName() == 'messages')
		<script src="{{ URL::asset('js/messages.min.js') }}"></script>
	@endif

	@if (Request::is('user/*'))
		<script type="text/javascript">
		$( "#send-message" ).click(function() {
		  var text = $('#text').val();

		    if (text.length > 0)
		    {
		        $.post( '{{ URL::to('/'); }}/messages/send', {message: text, userId: {{ $user->id }}}, function()
		        {
		            window.location = "{{ URL::to('/'); }}/messages";
		        });
		    }
		});
		</script>
	@endif

	@if (Route::current()->getName() == 'course-lesson')
		<script>
			//scroll to lesson in playlist div
			$('.playlist-panel .list-group').animate({
		    scrollTop: $(".playlist-panel .list-group .active").offset().top
			}, 0);
		</script>
	@endif
   <script>
$(".fixed li").click(function(i){i.stopPropagation(),$(".fixed li").removeClass("active"),$(this).addClass("active")}),$(".choose-user").on("click",function(){$("#list-modal").modal("hide"),$("#chat-with").modal("show")}),$(".shown").tooltip({trigger:"focus",placement:"top"}),$(".shown").tooltip("show"),$(".settings-panel .input-group").click(function(i){i.stopPropagation(),$(".settings-panel .input-group").removeClass("current"),$(this).addClass("current")}),$("body").click(function(){$(".settings-panel .input-group").removeClass("current")}),$(".message-list .list-group-item").click(function(i){i.stopPropagation(),$(".message-list .list-group-item").removeClass("active"),$(this).addClass("active")}),$(".clock").tooltip(),$(function(){var i=$(".tabs-profile").offset().top,o=function(){var o=$(window).scrollTop();$(".tabs-profile").css(o>i?{position:"fixed",top:53,left:0,"z-index":9995}:{position:"relative",top:0})};o(),$(window).scroll(function(){o()})});for(var $span=$(".course.created"),i=0;i<$span.length;i+=2){var $div=$("<div/>",{"class":"row"});$span.slice(i,i+2).wrapAll($div)}for(var $span=$(".course.joined"),i=0;i<$span.length;i+=2){var $div=$("<div/>",{"class":"row"});$span.slice(i,i+2).wrapAll($div)}for(var $span=$(".student"),i=0;i<$span.length;i+=2){var $div=$("<div/>",{"class":"row"});$span.slice(i,i+2).wrapAll($div)}$(document).ready(function(){$(".join").click(function(){$("#ask").show(),$(".join").hide()});var i=$.fn.button.noConflict();$.fn.bootstrapBtn=i,$(function(){$('[data-toggle="tooltip"]').tooltip()})}),$("#keyword").autocomplete({source:"/getdata",minLength:1,select:function(i,o){window.location="{{URL::to('course/"+o.item.course_id+"')}}"}});
   </script>
  </body>
</html>