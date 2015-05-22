<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') Teachbox</title>
	<meta name="description" content="@yield('description')">
	<meta name="twitter:card" value="@yield('description')">
	<meta property="og:image" content="@yield('fb-image')"/>
	<meta property="og:title" content="@yield('title')  Teachbox"/>
	<meta property="og:description" content="@yield('description')" />
	<meta property="og:site_name" content="Teachbox - online education"/>
	<meta property="og:type"   content="website" />
	<meta name="google-site-verification" content="_npkPq6Oypg3K_Z-AUJkW_9pvxGtTAly8asiWtDMQNI" />

	<link rel="SHORTCUT ICON" href="{{ URL::asset('img/favicon.ico') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/stylesv2.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('css/jquery-ui.min.css') }}" />

    <!--[if lt IE 9]>
      <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	@if(Route::current()->getName() == 'course-lesson')
	    <link href="//vjs.zencdn.net/4.11/video-js.css" rel="stylesheet">
	    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/sweet-alert.css') }}">
	@endif

	<script>
        var base_url = '{{ URL::to('/') }}';
        var _token = '{{ csrf_token() }}';
    </script>
  </head>
  <body>
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
				    <div role="tabpanel" class="tab-pane in active" id="login">
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
	      	<li class="icon-list"><a href="{{ URL::action('CourseController@explore')}}"><i class="fa fa-2x fa-search fa-flip-horizontal"></i><span> Explore</span></a></li>
	      	<!-- <li class="icon-list"><a href=""><i class="fa fa-2x fa-tachometer"></i><span> Tutor dashboard</span></a></li> -->
	        <?php
$courseListIdMenu = UserCourse::where('user_id', '=', Auth::user()->id)->get();
$createdList = Course::where('user_id', '=', Auth::user()->id)->get();
$joinedListMenu = array();

foreach ($courseListIdMenu as $userCourse) {
	$joinedListMenu[] = Course::find($userCourse->course_id);
}
?>

			@if(count($joinedListMenu) - count($createdList) > 0)
	        <li class="heading-courses"> Enrolled courses </li>

	        @foreach ($joinedListMenu as $course)
	        	@if ($course->user_id != Auth::user()->id)
			        <li class="course-list"><a href="{{ URL::action('CourseController@course', [$course->id]) }}">
			        	<img class="small-profile" src="{{ URL::asset('courses/'. $course->id . '/img/' . $course->pic) }}">
			        	<span>{{$course->name}}</span>
			        </a></li>
	        	@endif
	        @endforeach
	        @endif

	        @if(count($createdList) > 0)
	        <li class="heading-courses"> Created courses</li>

	        @foreach ($joinedListMenu as $course)
	        	@if ($course->user_id == Auth::user()->id)
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
        <li class="dropdown" id="notification-click">
         <a href="#" class="dropdown-toggle" data-toggle="dropdown">
		   <i class="fa fa-globe"></i>
		   <span class="badge badge-notification">1</span>
		         </a>
		   <ul class="dropdown-menu pull-right notifaction-list" role="menu">
		    <li class="pre-menu-item" id="notifications"><strong>Notifications:</strong></li>
		    <li class="temp-notification">
		     <!--<a href="{{ URL::action('ProfileController@user', [Auth::user()->id]) }}">
		       <img class="pull-left" src="https://pbs.twimg.com/profile_images/558225939675762689/CAjYSQca.jpeg">
		       <span>New lesson in <strong> How to make a course on techbox How to make a course on techbox.</strong> </span>
		      </a>-->
		    </li>
		     <li>
			     <!-- <a href="#"> <small>more notifacations</small></a> -->
		     </li>
		   </ul>
		  </li>
        <li><a href="{{ URL::action('MessagesController@index') }}"><i class="fa fa-comments"></i><span class="badge badge-message">1</span></a></li>
        <li class="dropdown">
	        <a href="#" class="navbar-brand profile dropdown-toggle" data-toggle="dropdown">
	        	<img id="user-pic" src="{{ URL::asset('img/'. Auth::user()->id . '/' . getThumbName(Auth::user()->pic)) }}" /><span class="caret"></span>
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
		        <li id="login-link"><a href="#"  data-toggle="modal" data-target="#newModal">Login</a></li>
		        <li><a href="{{ URL::route('home') }}" class="btn btn-default">Register</a></li>
			</ul>
		@endif
</div>
</header>
<div class="page-wrap">
	<div class="main">
	    @yield('content')
    </div>
</div>
	<footer class="front-page-footer after-login-footer site-footer">
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
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-60502699-1', 'auto');
	  ga('send', 'pageview');

	</script>
    @if(Route::current()->getName() == 'course-lesson')
		<script src="//vjs.zencdn.net/4.11/video.js"></script>
	@endif
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	@if (Route::current()->getName() == 'course-lesson')
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/1.4.14/jquery.scrollTo.min.js"></script>

	<script>
	$('.list-group').scrollTo( $('.list-group .active') );

	var vid = document.getElementById("video_main");
	$( "#video_main" ).click(function() {
	  	$('#on-end').hide();
	    $('#video_main').css('opacity','1');
	});
		$( ".submit-test" ).click(function() {
	  	$('#testModal').modal('hide');
	});
	function playVid() {
	    vid.play();
	    $('#on-end').hide();
	    $('#video_main').css('opacity','1');
	}

	var video = videojs('#video_main').ready(function(){
 	var player = this;
	player.on('ended', function() {
	$('#on-end').show();
	$('#video_main').css('opacity','.4');
	});


	});

		 $('  .btnNext').click(function(){

		  $('.nav-tabs > .active').next('li').find('a').trigger('click');

		});

		  $('.btnPrevious').click(function(){
		  $('.nav-tabs > .active').prev('li').find('a').trigger('click');
		});
	</script>
	@endif

	@if(Route::current()->getName() == 'search-user' && $countUser > 10 )
   <script src="{{ URL::asset('js/jquery.jscroll.min.js') }}"></script>
	    <script type="text/javascript">
			$(function() {
				$('.pagination').hide();

			    $('.scroll').jscroll({
			    	 loadingHtml: '<p class="centered" id="loading"><a class="btn btn-success"href="#"><i class="fa fa-2x fa-spinner fa-pulse"></i> Loading...</a>',
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
	@if(Route::current()->getName() == 'search-lesson' && $countLesson > 10 )
   <script src="{{ URL::asset('js/jquery.jscroll.min.js') }}"></script>
	    <script type="text/javascript">
			$(function() {
				$('.pagination').hide();

			    $('.scroll').jscroll({
			    	 loadingHtml: '<p class="centered" id="loading"><a class="btn btn-success"href="#"><i class="fa fa-2x fa-spinner fa-pulse"></i> Loading...</a>',
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
	@if(Route::current()->getName() == 'course-lesson' && count($comments) > 15 )
    <script src="{{ URL::asset('js/jquery.jscroll.min.js') }}"></script>
	    <script type="text/javascript">
			$(function() {
				$('.pagination').hide();

			    $('.scroll').jscroll({
			    	 loadingHtml: '<p class="centered" id="loading"><a class="btn btn-success"href="#"><i class="fa fa-2x fa-spinner fa-pulse"></i> Loading...</a>',
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
    @if(Route::current()->getName() == 'search' || Route::current()->getName() == 'search-front' || Route::current()->getName() == 'user-profile' || Route::current()->getName() == 'home')
    	@if(Route::current()->getName() == 'user-profile' && $timelineCount > 5 )
		    <script src="{{ URL::asset('js/jquery.jscroll.min.js') }}"></script>
			    <script type="text/javascript">
					$(function() {
						$('.pagination').hide();

					    $('.scroll').jscroll({
					    	 loadingHtml: '<p class="centered" id="loading"><a class="btn btn-success"href="#"><i class="fa fa-2x fa-spinner fa-pulse"></i> Loading...</a>',
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
		@elseif(Route::current()->getName() == 'home'  &&  $timelineCount > 5)
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
   <script>

   	(function(e){var t,o={className:"autosizejs",append:"",callback:!1,resizeDelay:10},i='<textarea tabindex="-1" style="position:absolute; top:-999px; left:0; right:auto; bottom:auto; border:0; padding: 0; -moz-box-sizing:content-box; -webkit-box-sizing:content-box; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden; transition:none; -webkit-transition:none; -moz-transition:none;"/>',n=["fontFamily","fontSize","fontWeight","fontStyle","letterSpacing","textTransform","wordSpacing","textIndent"],s=e(i).data("autosize",!0)[0];s.style.lineHeight="99px","99px"===e(s).css("lineHeight")&&n.push("lineHeight"),s.style.lineHeight="",e.fn.autosize=function(i){return this.length?(i=e.extend({},o,i||{}),s.parentNode!==document.body&&e(document.body).append(s),this.each(function(){function o(){var t,o;"getComputedStyle"in window?(t=window.getComputedStyle(u,null),o=u.getBoundingClientRect().width,e.each(["paddingLeft","paddingRight","borderLeftWidth","borderRightWidth"],function(e,i){o-=parseInt(t[i],10)}),s.style.width=o+"px"):s.style.width=Math.max(p.width(),0)+"px"}function a(){var a={};if(t=u,s.className=i.className,d=parseInt(p.css("maxHeight"),10),e.each(n,function(e,t){a[t]=p.css(t)}),e(s).css(a),o(),window.chrome){var r=u.style.width;u.style.width="0px",u.offsetWidth,u.style.width=r}}function r(){var e,n;t!==u?a():o(),s.value=u.value+i.append,s.style.overflowY=u.style.overflowY,n=parseInt(u.style.height,10),s.scrollTop=0,s.scrollTop=9e4,e=s.scrollTop,d&&e>d?(u.style.overflowY="scroll",e=d):(u.style.overflowY="hidden",c>e&&(e=c)),e+=w,n!==e&&(u.style.height=e+"px",f&&i.callback.call(u,u))}function l(){clearTimeout(h),h=setTimeout(function(){var e=p.width();e!==g&&(g=e,r())},parseInt(i.resizeDelay,10))}var d,c,h,u=this,p=e(u),w=0,f=e.isFunction(i.callback),z={height:u.style.height,overflow:u.style.overflow,overflowY:u.style.overflowY,wordWrap:u.style.wordWrap,resize:u.style.resize},g=p.width();p.data("autosize")||(p.data("autosize",!0),("border-box"===p.css("box-sizing")||"border-box"===p.css("-moz-box-sizing")||"border-box"===p.css("-webkit-box-sizing"))&&(w=p.outerHeight()-p.height()),c=Math.max(parseInt(p.css("minHeight"),10)-w||0,p.height()),p.css({overflow:"hidden",overflowY:"hidden",wordWrap:"break-word",resize:"none"===p.css("resize")||"vertical"===p.css("resize")?"none":"horizontal"}),"onpropertychange"in u?"oninput"in u?p.on("input.autosize keyup.autosize",r):p.on("propertychange.autosize",function(){"value"===event.propertyName&&r()}):p.on("input.autosize",r),i.resizeDelay!==!1&&e(window).on("resize.autosize",l),p.on("autosize.resize",r),p.on("autosize.resizeIncludeStyle",function(){t=null,r()}),p.on("autosize.destroy",function(){t=null,clearTimeout(h),e(window).off("resize",l),p.off("autosize").off(".autosize").css(z).removeData("autosize")}),r())})):this}})(window.jQuery||window.$);

		var __slice=[].slice;(function(e,t){var n;n=function(){function t(t,n){var r,i,s,o=this;this.options=e.extend({},this.defaults,n);this.$el=t;s=this.defaults;for(r in s){i=s[r];if(this.$el.data(r)!=null){this.options[r]=this.$el.data(r)}}this.createStars();this.syncRating();this.$el.on("mouseover.starrr","i",function(e){return o.syncRating(o.$el.find("i").index(e.currentTarget)+1)});this.$el.on("mouseout.starrr",function(){return o.syncRating()});this.$el.on("click.starrr","i",function(e){return o.setRating(o.$el.find("i").index(e.currentTarget)+1)});this.$el.on("starrr:change",this.options.change)}t.prototype.defaults={rating:void 0,numStars:5,change:function(e,t){}};t.prototype.createStars=function(){var e,t,n;n=[];for(e=1,t=this.options.numStars;1<=t?e<=t:e>=t;1<=t?e++:e--){n.push(this.$el.append('<i class="fa .fa-star-o"></i>'))}return n};t.prototype.setRating=function(e){if(this.options.rating===e){e=void 0}this.options.rating=e;this.syncRating();return this.$el.trigger("starrr:change",e)};t.prototype.syncRating=function(e){var t,n,r,i;e||(e=this.options.rating);if(e){for(t=n=0,i=e-1;0<=i?n<=i:n>=i;t=0<=i?++n:--n){this.$el.find("i").eq(t).removeClass("fa-star-o").addClass("fa-star")}}if(e&&e<5){for(t=r=e;e<=4?r<=4:r>=4;t=e<=4?++r:--r){this.$el.find("i").eq(t).removeClass("fa-star").addClass("fa-star-o")}}if(!e){return this.$el.find("i").removeClass("fa-star").addClass("fa-star-o")}};return t}();return e.fn.extend({starrr:function(){var t,r;r=arguments[0],t=2<=arguments.length?__slice.call(arguments,1):[];return this.each(function(){var i;i=e(this).data("star-rating");if(!i){e(this).data("star-rating",i=new n(e(this),r))}if(typeof r==="string"){return i[r].apply(i,t)}})}})})(window.jQuery,window);$(function(){return $(".starrr").starrr()});

		$(function(){

		  $('#new-review').autosize({append: "\n"});

		  var reviewBox = $('#post-review-box');
		  var newReview = $('#new-review');
		  var openReviewBtn = $('#open-review-box');
		  var closeReviewBtn = $('#close-review-box');
		  var ratingsField = $('#ratings-hidden');

		  openReviewBtn.click(function(e)
		  {
		    reviewBox.slideDown(400, function()
		      {
		        $('#new-review').trigger('autosize.resize');
		        newReview.focus();
		      });
		    openReviewBtn.fadeOut(100);
		    closeReviewBtn.show();
		  });

		  closeReviewBtn.click(function(e)
		  {
		    e.preventDefault();
		    reviewBox.slideUp(300, function()
		      {
		        newReview.focus();
		        openReviewBtn.fadeIn(200);
		      });
		    closeReviewBtn.hide();

		  });

		  $('.starrr').on('starrr:change', function(e, value){
		    ratingsField.val(value);
		  });
		});

   </script>

   <script type="text/javascript">
   		$(document).ready(function()
		{
		    pullNotifications();
		});

		function pullNotifications()
		{
		    getNotifications();
		    setTimeout(pullNotifications,10000);
		}


		function getNotifications()
		{
		    $.post(base_url + '/notification-amount', {_token: _token}, function(data)
		    {
		        if(data != 0){
		            $(".badge-notification").text(data);
		        }else{
		 			$(".badge-notification").text("");
		        }

		    });
		}

		$( "#notification-click" ).click(function() {
			$('.notifaction-list').children('.temp-notification').remove();

			$.post(base_url + '/notification-clear', {_token: _token}, function(data)
		    {

		    });
			getNotifications();

            $.post(base_url + '/notification', {_token: _token}, function(data)
		    {
		    	var k=0;
		    	for (var i = 0; i<3; i++) {
		    		switch(data['order'][i]){
		    			case 0:
		    					if(data['follow']['amount'] > 1){
		    						$('#notifications').after(' <li class="temp-notification"><a href="'+  base_url + '/user/' +  data['follow']['last_id']  + '"><img class="pull-left" src="' + base_url + '/img/' + data['follow']['last_id'] + '/user-100x100.png"><span>'+ (data['follow']['amount']+1) +' New followers <strong>'+ data['follow']['last_name'] +' and ' + data['follow']['amount'] + ' others.</strong></span></a></li>');
		    					}else{
		    						$('#notifications').after(' <li class="temp-notification"><a href="'+  base_url + '/user/' +  data['follow']['last_id']  + '"><img class="pull-left" src="' + base_url + '/img/' + data['follow']['last_id'] + '/user-100x100.png"><span><strong>' + data['follow']['last_name'] + ' followed you.</strong></span></a></li>');
		    					}
		    					k++;
								break;
						case 1:
								if(data['join']['amount'] > 1){
									$('#notifications').after(' <li class="temp-notification"><a href="'+  base_url + '/user/' +  data['join']['last_id'] + '"><img class="pull-left" src="' + base_url + '/img/' + data['join']['last_id'] + '/user-100x100.png"><span>' + data['join']['last_name']+ ' and ' + data['join']['amount'] +' new students in your <strong>' + data['join']['course'] + '</strong> course. </span></a></li>');
								}else{
									$('#notifications').after(' <li class="temp-notification"><a href="'+  base_url + '/user/' +  data['join']['last_id'] + '"><img class="pull-left" src="' + base_url + '/img/' + data['join']['last_id'] + '/user-100x100.png"><span>'+ data['join']['last_name'] +' joined your <strong>' + data['join']['course'] + '</strong> course. </span></a></li>');
								}
								k++;
								break;
						case 2:
								break;
		    		}
		    	};

		    	if(k==0){
		    		$('#notifications').after('<a href="#"> <small>No notifications yet</small></a>');
		    	}

		    });
		});

   </script>

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

    @if(Route::current()->getName() != 'messages')
		<script>
		$(document).ready(function()
		{
		    pullNotification();
		});

		function pullNotification()
		{
		    getNotification();
		    setTimeout(pullNotification,10000);
		}


		function getNotification()
		{
		    $.post(base_url + '/messages/get-notification', {_token: _token}, function(data)
		    {
		        if(data != 0){
		            $(".badge-message").text(data);
		        }else{
		 			$(".badge-message").text("");
		        }

		    });
		}
		</script>
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
		        $.post( '{{ URL::to('/'); }}/messages/send', {message: text, userId: {{ $user->id }}, _token: _token}, function()
		        {
		            window.location = "{{ URL::to('/'); }}/messages";
		        });
		    }
		});
		</script>
	@endif

<script>

$(document).ready(function() {
var stickyNavTop = $('#visible').offset().top;
var stickyNav = function(){
var scrollTop = $(window).scrollTop();
if (scrollTop > stickyNavTop) {
     $('#hidden').removeClass('hidden');
     $('#hidden').css('display','block!important');
} else {
    $('#hidden').addClass('hidden');
}
};

stickyNav();

$(window).scroll(function() {
	stickyNav();
});
});
    $(".navbar-toggle").click(function(){
        $(".navbar-collapse").toggle();
        $(".navbar-collapse").addClass( "slideRight" );
    });
</script>

   <script>
$(".fixed li").click(function(i){i.stopPropagation(),$(".fixed li").removeClass("active"),$(this).addClass("active")}),$(".choose-user").on("click",function(){$("#list-modal").modal("hide"),$("#chat-with").modal("show")}),$(".shown").tooltip({trigger:"focus",placement:"top"}),$(".shown").tooltip("show"),$(".settings-panel .input-group").click(function(i){i.stopPropagation(),$(".settings-panel .input-group").removeClass("current"),$(this).addClass("current")}),$("body").click(function(){$(".settings-panel .input-group").removeClass("current")}),$(".message-list .list-group-item").click(function(i){i.stopPropagation(),$(".message-list .list-group-item").removeClass("active"),$(this).addClass("active")}),$(".clock").tooltip();for(var $span=$(".course.created"),i=0;i<$span.length;i+=2){var $div=$("<div/>",{"class":"row"});$span.slice(i,i+2).wrapAll($div)}for(var $span=$(".course.joined"),i=0;i<$span.length;i+=2){var $div=$("<div/>",{"class":"row"});$span.slice(i,i+2).wrapAll($div)}for(var $span=$(".student"),i=0;i<$span.length;i+=2){var $div=$("<div/>",{"class":"row"});$span.slice(i,i+2).wrapAll($div)}$(document).ready(function(){$(".join").click(function(){$("#ask").show(),$(".join").hide()});var i=$.fn.button.noConflict();$.fn.bootstrapBtn=i,$(function(){$('[data-toggle="tooltip"]').tooltip()})});
   </script>
   <script type="text/javascript">
var divs = $(".three-in-line");
for(var i = 0; i < divs.length; i+=3) {
  divs.slice(i, i+3).wrapAll("<div class='row'></div>");
}

   </script>


	<script>
	var less = '/lesson/';
		$('#keyword').autocomplete({
				source: '/getdata',
				minLength: 1,
				select:function(e, ui){
					if(ui.item.isUser == false && ui.item.isLesson == false){
						window.location="{{URL::to('course/" + ui.item.course_id + "')}}";
					}
					else if(ui.item.isUser == false && ui.item.isLesson == true){
						var lesson = ui.item.course_id + "/lesson/" +ui.item.lesson_order;
						window.location="{{URL::to('course/" + lesson + "')}}";
					}
					else if(ui.item.isUser == true){
					window.location="{{URL::to('user/" + ui.item.user_id + "')}}";

					}
				},
				open: function() {
				$('.lesson-item').first().before( "<li class='pre-menu-item'><strong>Lessons:</strong></li>" );
				$('.course-item').first().before( "<li class='pre-menu-item'><strong>Courses:</strong></li>" );
				$( ".user-item").first().before( "<li class='pre-menu-item'><strong>People:</strong></li>");
			}
		}).autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li class=" + item.classa +">" )
        .append( "<img src='" + item.icon + "'>" + item.label )
        .appendTo( ul );
    };
$("#upload-video").click(function(){
    $(".absolute-icon").show();
});
	$('.upload-video-input').on('change',function(){
	$('.info-heading').html('Video choosen.');
	$('.fileUpload').addClass("btn-success");
});
	</script>


	<script id="the_script" src="{{ URL::asset('js/svgcheckbx.js') }}"></script>
		@if(Route::current()->getName() == 'course-lesson')

	<script src="{{ URL::asset('js/sweet-alert.min.js') }}"></script>
		<script type="text/javascript">
				$(".vote").one("click",function() {
				var vote, isReply;
				var classNames = $("#" + event.target.id).attr("class").toString().split(' ');
		        $.each(classNames, function (i, className) {
		            if(String(className) == "upvote"){
		            	vote = 0;
		            }else if(String(className) == "downvote"){
		            	vote = 1;
		            }else if(String(className) == "yes"){
		            	isReply = 1;
		            }else if(String(className) == "no"){
		            	isReply = 0;
		            }
		        });


				$.post( base_url + '/comment/vote', {commentId: event.target.id.substring(2), isReply: isReply, vote: vote, userId: {{ Auth::id() }}, _token: _token}, function()
	            {});

	            if(isReply){
	            		var currentValue = parseInt($("#lr"  + event.target.id.substring(2)).text(),10);
	               		$("#thumbs-reply-" + event.target.id.substring(2)).remove();
	               		if(vote){
	               			currentValue -= 1;
	               		}else{
	               			currentValue += 1;
	               		}
	               		$("#lr" + event.target.id.substring(2)).text(currentValue);
                }else{
                		var currentValue = parseInt($("#lc"  + event.target.id.substring(2)).text(),10);
	               		$("#thumbs-comment-" + event.target.id.substring(2)).remove();
	               		if(vote){
	               			currentValue -= 1;
	               		}else{
	               			currentValue += 1;
	               		}
                		$("#lc" + event.target.id.substring(2)).text(currentValue);
                }



			});

		$( ".comment-post").click(function() {
			if($( ".comment-post").is(':focus')){
			$("#comment-post-button").removeClass("hidden");
			$("#comment-post-button").addClass("slideRight");
		}
		});

		$( "#r11" ).trigger( "click" );
		$( "#r21" ).trigger( "click" );
		$( "#r31" ).trigger( "click" );
		$( "#r41" ).trigger( "click" );
		$( "#r51" ).trigger( "click" );
			$( "#results" ).click(function() {

			        $.post( base_url + '/course/' + {{ $course->id }} + '/lesson/' + {{ $lesson->id }} + '/test' , $('#results-form').serialize(), function(data)
			        {
			        	if(data['percentage'] < 50){
			            swal({   title: "You scored " + data['percentage'] + "%!",   text: data['right'] + "/" + data['total'],   type: "error",   confirmButtonText: "Be better on the next lesson!" });
			        	}else{

			            swal({   title: "You scored " + data['percentage'] + "%!",   text: data['right'] + "/" + data['total'],   type: "success",   confirmButtonText: "Cool!" });
			        	}
			        });
			        $('#testModal').modal('hide');
			        $('#on-end p').hide();
			        $('#on-end button:last-child').hide();
			        $('#testBtn').remove();
			});
		</script>
	@endif
	@if(Auth::check() && Route::current()->getName() == 'course-lesson')
		<script type="text/javascript">
			$(".reply").one("click",function() {
				$("." + event.target.id).append('<form method="POST" action="' + base_url +'/course/' + {{ $lesson->id }} + '/lesson/'+ {{  Auth::user()->id }}+'/comment/' + event.target.id +'" accept-charset="UTF-8" id="results-form" class="ac-custom ac-radio reply-form"><input name="_token" type="hidden" value="' + _token + '"><textarea class="form-control comment-post" rows="3" placeholder="Add your comment" name="comment" cols="50"></textarea><div class="row"><button type="submit pull right" id="comment-post-button" class="btn btn-primary ">Submit</button></div></form>');
			});
		</script>
	@endif
@if(Route::current()->getName() == 'course-add')
	<script>
     $( "#question-1 li:first-child input" ).trigger( "click" );
	</script>
	<script id="test">
		 $('.btnNext').click(function(){
		  $('.nav-tabs > .active').next('li').find('a').trigger('click');
		});

		  $('.btnPrevious').click(function(){
		  $('.nav-tabs > .active').prev('li').find('a').trigger('click');
		});


(function () {
 	var clickCount = [0,0,0,0,0];
 	var choice = [3,3,3,3,3];
 	var question = 1;
 	var qCount = 0;

		 $('#qCollection').on('click','.btn-add-choice', function(){
  			$("#question-" + event.target.id).append('<li><input name="r'+ event.target.id +'" value="'+ event.target.id + (clickCount[event.target.id-1]+3) +'" type="radio"><label><input placeholder="' + 'Option ' +  choice[event.target.id-1]  + '  "' + 'class="form-control" name="'+ event.target.id +''+ (clickCount[event.target.id-1]+3) +'" type="text"></label></li>');

		  	$('#the_script').remove();

		    var script = document.createElement('script');
		    script.id = 'the_script';
		    //the script's source here
		    script.src = base_url + '/js/svgcheckbx.js';
		    script.type ='text/javascript';
		    document.getElementsByTagName('head')[0].appendChild(script);


		    clickCount[event.target.id-1] += 1;
		    choice[event.target.id-1] += 1;
			if (clickCount[event.target.id-1] == 2) {
		       $( "#"+event.target.id ).hide();
		  	}
 		});

		$(".btn-add-question").click(function() {
			question+=1;
			qCount+=1;
			$("#qCollection").append('<div class="row question-row"><div class="input-group"><span class="input-group-addon"><i class="fa fa-question"></i></span><input placeholder="Your question" class="form-control" name="q'+ question +'" type="text"></div></div><ul id="question-'+ question +'"><li><input name="r'+ question +'" value="'+ question +'1" type="radio" checked="checked"><label for="r'+ question +'"><input placeholder="Option 1" class="form-control" name="'+ question +'1" type="text"></label></li><li><input name="r'+ question +'" value="'+ question +'2" type="radio"><label for="r'+ question +'"><input placeholder="Option 2" class="form-control" name="'+ question +'2" type="text"></label></li></ul><button type="button" id="'+ question +'" class="btn btn-default btn-add-choice">Add choice</button></div>');

			$('#the_script').remove();
		    var script = document.createElement('script');
		    script.id = 'the_script';
		    //the script's source here
		    script.src = base_url + '/js/svgcheckbx.js';
		    script.type ='text/javascript';
		    document.getElementsByTagName('head')[0].appendChild(script);

			if(qCount == 4){
				 $( ".btn-add-question" ).hide();
			}
		});

})();
	</script>
@endif

@if(Route::current()->getName() == 'course-page')
<script type="text/javascript">
$('.read-more-content').addClass('hide')

// Set up a link to expand the hidden content:
.before('<a class="read-more-show" href="#">Read More</a>')

// Set up a link to hide the expanded content.
.append(' <a class="read-more-hide" href="#">Read Less</a>');

// Set up the toggle effect:
$('.read-more-show').on('click', function(e) {
  $(this).next('.read-more-content').removeClass('hide');
  $(this).addClass('hide');
  e.preventDefault();
});

$('.read-more-hide').on('click', function(e) {
  $(this).parent('.read-more-content').addClass('hide').parent().children('.read-more-show').removeClass('hide');
  e.preventDefault();
});
</script>
@endif
@if(Route::current()->getName() == 'course-page' && $rest == "")
<script type="text/javascript">
	$('.read-more-show').remove();
</script>
@endif
		<script>
			// For Demo purposes only (show hover effect on mobile devices)
			[].slice.call( document.querySelectorAll('a[href="#"') ).forEach( function(el) {
				el.addEventListener( 'click', function(ev) { ev.preventDefault(); } );
			} );
		</script>
  </body>
</html>