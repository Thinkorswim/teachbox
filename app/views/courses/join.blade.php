@extends('layouts.master-after')

@section('content')
	<div class="course-section">
		<div class="container">
			<div class="col-xs-12 col-md-3">
				<img src="{{ URL::asset('img/logo.png') }}"/>
			</div>
			<div class="col-xs-12 col-xs-9">
				<h1>Course name</h1>
				<h5> by Ivan Lebanov</h5>
			</div>
		</div>
	</div>

joined
<br>
<a href="{{ URL::action('CourseController@courseAdd', [$course->id]) }}"> Add Lesson </a>
<br>
<a href="{{ URL::action('CourseController@courseEdit', [$course->id]) }}"> Edit Course </a>
@endsection