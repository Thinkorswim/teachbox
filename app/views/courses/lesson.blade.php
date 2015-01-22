@extends('layouts.master-after')

@section('content')

<div class="container">
	<div class="col-xs-3">

	</div>
	<div class="col-xs-6">
		@if ($currentLesson->order != 1)
			<a href="{{ URL::action('CourseController@courseLesson', [$course->id,($currentLesson->order-1)]) }}"> Previous </a> </p>
		@endif
		<video id="video_main" class="video-js vjs-default-skin vjs-big-play-centered" controls
		 preload="auto" width="100%" height="360" 
		 data-setup="{}">
			<source src="{{ URL::asset('courses/' . $course->id . '/' . $currentLesson->order . '/' . $currentLesson->filepath) }}" type="video/mp4" />  	
		    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
		</video>
		@if ($currentLesson->order != $lessonList->count())
			<a href="{{ URL::action('CourseController@courseLesson', [$course->id,($currentLesson->order+1)]) }}"> Next </a> </p>
		@endif

	</div>

	<br><br>
		{{ $currentLesson->name }}
		<br>
        {{ $currentLesson->description }}
		<br>
		 <h5> by <a href="{{ URL::action('ProfileController@user', $creator->id) }}"> {{ $creator->name; }} </a></h5>
		<br>
		<p> <a href="{{ URL::action('CourseController@course', [$course->id]) }}"> {{ $course->name; }} </a> </p>
	<br><br>
	<div class="col-xs-3">
	@foreach ($lessonList as $lesson)
		@if ($lesson->order == $currentLesson->order)
 			<p> <a class="current" href="{{ URL::action('CourseController@courseLesson', [$course->id,$lesson->order]) }}"> {{ $lesson->name; }} </a> </p>
 		@else
 			<p> <a href="{{ URL::action('CourseController@courseLesson', [$course->id,$lesson->order]) }}"> {{ $lesson->name; }} </a> </p>
 		@endif
    @endforeach
	</div>
</div>


@endsection