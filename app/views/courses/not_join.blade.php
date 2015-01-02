@extends('layouts.master-after')

@section('content')
	{{ Form::open(array('action' => array('CourseController@postJoin', $course->id))) }}
		{{ Form::token() }}
		{{ Form::submit('Join') }}
	{{ Form::close() }}	
@endsection