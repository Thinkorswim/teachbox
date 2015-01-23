@extends('layouts.master-after')

@section('content')
<section class="video-section">
	<div class="container">
		<nav class="nav-reveal">
			@if ($currentLesson->order != 1)
			<a class="prev" href="{{ URL::action('CourseController@courseLesson', [$course->id,($currentLesson->order-1)]) }}">
				<span class="icon-wrap">
					<i class="fa fa-2x fa-chevron-left"></i>
				</span>
				<div>
					<h3>Moments of Freedom and Other Stories <span>by Marina Wasilovna</span></h3>
					<img src="http://startupcollective-com.s3.amazonaws.com/wp-content/uploads/programming.jpg" alt="Previous thumb"/>
				</div>
			</a>
			@endif
			@if ($currentLesson->order != $lessonList->count())
			<a class="next" href="/item3">
				<span class="icon-wrap">
					<i class="fa fa-2x fa-chevron-right"></i>
				</span>
				<div>
					<h3>Garage Rocket Ships for Sarah and Ben<span>by Aldous Morrison</span></h3>
					<img src="http://startupcollective-com.s3.amazonaws.com/wp-content/uploads/programming.jpg" alt="Next thumb"/>
				</div>
			</a>
			@endif
		</nav>
		<div class="col-xs-1"></div>
		<div class="col-xs-10">
			<video id="video_main" class="video-js vjs-default-skin vjs-big-play-centered" controls
			 preload="auto" width="100%" height="360" 
			 data-setup="{}">
				<source src="{{ URL::asset('courses/' . $course->id . '/' . $currentLesson->order . '/' . $currentLesson->filepath) }}" type="video/mp4" />  	
			    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
			</video>

		</div>
		<div class="col-xs-1"></div>
	</div>
</section>
<div class="container">
	<div class="col-xs-12 col-sm-8">
		<div class="panel panel-default">
		  <div class="panel-body">
			<h1>{{ $currentLesson->name }}</h1>
	        <p>{{ $currentLesson->description }}</p>
		 </div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-4">
		<div class="panel panel-default actions">
		  <div class="panel-heading">
		  	<h3 class="panel-title">
		  		<a href="{{ URL::action('CourseController@course', [$course->id]) }}"> {{ $course->name; }} </a>
		  	</h3>
		  	<small> by <strong><a href="{{ URL::action('ProfileController@user', $creator->id) }}"> {{ $creator->name; }} </a></strong></small>
		  </div>
		  <div class="panel-body"> 
			  <div class="list-group">
				@foreach ($lessonList as $lesson)
					@if ($lesson->order == $currentLesson->order)
			 		 	<a class="list-group-item active" href="{{ URL::action('CourseController@courseLesson', [$course->id,$lesson->order]) }}"> {{ $lesson->name; }} </a>
			 		@else
			 			<a class="list-group-item" href="{{ URL::action('CourseController@courseLesson', [$course->id,$lesson->order]) }}"> {{ $lesson->name; }} </a> 
			 		@endif
			    @endforeach
			   </div>
		  </div>
		</div>
	</div>
</div>


@endsection