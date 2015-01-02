@extends('layouts.master-after')

@section('content')
{{ Form::open(array('action' => array('CourseController@postCreate'))) }}
		<br><br>
		Name: 
		 {{ Form::text('name', $user->name) }}
		 @if($errors->has('name'))
			{{ $errors->first('name') }}
		@endif
	{{ Form::close() }}	
@endsection