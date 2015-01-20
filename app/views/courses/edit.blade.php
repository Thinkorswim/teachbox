@extends('layouts.master-after')

@section('content')

{{ Form::open(array('action' => array('CourseController@postCourseEdit', $course->id), 'files' => true )) }}
		<br><br>
		Description: 
		 {{ Form::text('description', $course->description) }}
		 @if($errors->has('description'))
			{{ $errors->first('description') }}
		@endif
		<br>
			<div>Upload image</div>
			<input id="uploadFile" placeholder="Choose File" disabled="disabled" />
			<div class="fileUpload btn btn-primary">
			    <span>Choose a picture</span>
				{{ Form::file('image', array('id'=>'uploadBtn','class'=>'upload'))}}
			</div>	
		{{ Form::token() }}
		<br />
		{{ Form::submit('Save settings') }}
	{{ Form::close() }}	
@endsection