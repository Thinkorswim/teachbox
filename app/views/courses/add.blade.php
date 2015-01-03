@extends('layouts.master-after')

@section('content')

   
	{{ Form::open(array('action' => array('CourseController@coursePostAdd', $course->id), 'enctype' => 'multipart/form-data', 'files' => true  )) }}                          
	    <br><br>
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
	    {{ Form::file('video',null) }}  
	    {{ Form::submit('Upload') }}
	{{ Form::close() }}

@endsection