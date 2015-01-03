@extends('layouts.master-after')

@section('content')

{{ Form::open(array('action' => array('CourseController@postCourseEdit', $course->id))) }}
		<br><br>
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