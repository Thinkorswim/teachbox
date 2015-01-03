@extends('layouts.master-after')

@section('content')

{{ Form::open(array('action' => array('CourseController@postCourseEdit', $course->id))) }}
		<br><br>
		<a href="{{ URL::action('CourseController@courseAdd', [$course->id]) }}"> Add Lesson </a>
		<br>
		Name: 
		 {{ Form::text('name') }}
		 @if($errors->has('name'))
			{{ $errors->first('name') }}
		@endif
		<br>
		Description: 
		 {{ Form::text('description') }}
		 @if($errors->has('description'))
			{{ $errors->first('description') }}
		@endif
		<br>
		{{ Form::token() }}
		{{ Form::submit('Edit Course') }}
	{{ Form::close() }}	
@endsection