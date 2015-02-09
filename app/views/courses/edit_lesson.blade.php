@extends('layouts.master-after')

@section('title')
	Edit lesson{{$course->name}} -
@stop

@section('description')
	{{ excerpt($lesson->description) }}
@stop

@section('content')
<div class="container">
	<div class="col-xs-12 col-sm-8">
		<div class="panel panel-default settings-panel actions">
		  <div class="panel-heading">
		    <h3 class="panel-title">Edit lesson</h3>
		  </div>
		  <div class="panel-body padding-panel">   
			{{ Form::open(array('action' => array('CourseController@postLessonEdit', $course->id), 'enctype' => 'multipart/form-data', 'files' => true  )) }} 
				 @if($errors->has('name'))
				<div class="input-group" data-toggle="tooltip" title="{{ $errors->first('name') }}">      
				@else             
				<div class="input-group">
				@endif  
					<span class="input-group-addon">
						<i class="fa fa-book"></i>
					</span> 
					 {{ Form::text('name', null, array('placeholder' => 'Lesson name', 'class'=>'form-control')) }}
				</div>
				@if($errors->has('description'))
				<div class="input-group" data-toggle="tooltip" title="{{ $errors->first('description') }}">
				@else             
				<div class="input-group">
				@endif  
					 {{ Form::textarea('description', null, array('placeholder' => 'Describe the lesson', 'class'=>'form-control')) }}
				</div>
				<div>Upload image</div>
				<input id="uploadFile" placeholder="Choose File" disabled="disabled" />
				<div class="fileUpload btn btn-primary">
				    <span>Choose a video</span>
			    	{{ Form::file('video', array('id'=>'uploadBtn','class'=>'upload')) }} 
			    </div> 
				{{ Form::submit('Upload', array('class'=>'form-control')) }}
			{{ Form::close() }}
		  </div>
		</div>
	</div>
</div>
@endsection