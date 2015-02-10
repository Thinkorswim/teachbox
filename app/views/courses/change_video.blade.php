@extends('layouts.master-after')

@section('title')
  Change lesson video -
@stop

@section('description')
  	{{ excerpt($lesson->decription) }}
@stop

@section('content')
<div class="container">
	<div class="row">
		@if(Session::has('global-positive'))
			<div class="alert alert-success" role="alert">
			{{Session::get('global-positive')}}
			</div>
		@endif
		@if(Session::has('global-negative'))
			<div class="alert alert-danger" role="alert">
			{{Session::get('global-negative')}}
			</div>
		@endif
	</div>
	<div class="col-xs-12 col-sm-4">
		<div class="panel panel-default actions">
		  <div class="panel-heading">
		    <h3 class="panel-title">Settings</h3>
		  </div>
		<div class="panel-body">
			<div class="list-group">
				<a class="list-group-item" href="{{ URL::action('CourseController@lessonEdit', [$course->id, $lesson->order]) }}">Lesson information</a>
				<a class="list-group-item active" href="{{ URL::action('CourseController@changeVideo', [$course->id, $lesson->order]) }}"> Change the video </a>
			</div>
		 </div>
		</div> 
	</div>
	<div class="col-xs-12 col-sm-8">
		<div class="panel panel-default settings-panel actions">
			<div class="panel-heading">
				<h3 class="panel-title">Change the video</h3>
			</div>
		  	<div class="panel-body padding-panel">
				{{ Form::open(array('action' => array('CourseController@postChangeVideo', $course->id, $lesson->order), 'enctype' => 'multipart/form-data', 'files' => true  )) }}
				<div class="row">
					<div class="fileUpload btn btn-primary no-upload">
				    	<span>Change the video</span>
			    	{{ Form::file('video', array('id'=>'uploadBtn','class'=>'upload')) }} 
			    </div> 
				</div>
				<div class="row">
					{{ Form::submit('Save changes', array('class'=>'form-control register-button')) }}
				</div>
				{{ Form::token() }}
				{{ Form::close() }}
				</div>
			</div>
	</div>
</div>
@endsection