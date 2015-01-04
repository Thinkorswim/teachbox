@extends('layouts.master-after')

@section('content')
	<div class="course-section">
		<div class="container">
			<div class="col-xs-12 col-md-3">
				<img src="{{ URL::asset('img/logo.png') }}"/>
			</div>
			<div class="col-xs-12 col-xs-9">
				<h1>{{ $course->name }}</h1>
				<h5> by <a href="{{ URL::action('ProfileController@user', $user->id) }}"> {{ $user->name; }} </a></h5>
			</div>
		</div>
	</div>
	<h1>{{ $course->description }}</h1>

	@foreach ($lessonList as $lesson)
 		<p> <a href="{{ URL::action('CourseController@courseLesson', [$course->id,$lesson->order]) }}"> {{ $lesson->name; }} </a> </p>
    @endforeach


<a href="{{ URL::action('CourseController@courseQuestion', [$course->id]) }}"> Discussion </a>


@if (Auth::user()->id == $course->user_id)
<br>
<a href="{{ URL::action('CourseController@courseAdd', [$course->id]) }}"> Add Lesson </a>
<br>
<a href="{{ URL::action('CourseController@courseEdit', [$course->id]) }}"> Edit Course </a>
@endif
@endsection