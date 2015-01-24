@extends('layouts.master-after')

@section('content')
<div class="container"> 
	<div class="col-xs-12 col-sm-8">
		<div class="panel panel-default settings-panel actions">
		  	<div class="panel-body padding-panel">
				{{ Form::open(array('action' => array('CourseController@postCourseEdit', $course->id), 'files' => true )) }}
					Description: 
					{{ Form::textarea('description', $course->description, array('class'=>'form-control')) }}
					 @if($errors->has('description'))
						{{ $errors->first('description') }}
					@endif
						<div>Upload image</div>
						<input id="uploadFile" placeholder="Choose File" disabled="disabled" />
						<div class="fileUpload btn btn-primary">
						    <span>Choose a picture</span>
							{{ Form::file('image', array('id'=>'uploadBtn','class'=>'upload'))}}
						</div>	
					{{ Form::token() }}
					{{ Form::submit('Save settings', array('class'=>'form-control')) }}
				{{ Form::close() }}	
			</div>
		</div>
	</div>
</div>
@endsection