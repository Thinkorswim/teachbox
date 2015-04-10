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
		<div class="panel panel-default actions place">
		  <div class="panel-heading">
		    <h3 class="panel-title">Settings</h3>
		  </div>
		<div class="panel-body">
			<div class="list-group">
				<a class="list-group-item" href="{{ URL::action('LessonController@lessonEdit', [$course->id, $lesson->order]) }}">Lesson information</a>
				<a class="list-group-item active" href="{{ URL::action('LessonController@deleteLesson', [$course->id, $lesson->order]) }}"> Delete the lesson </a>
			</div>
		 </div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-8">
		<div class="panel panel-default settings-panel actions place">
			<div class="panel-heading">
				<h3 class="panel-title">Delete the lesson</h3>
			</div>
		  	<div class="panel-body padding-panel">
				{{ Form::open(array('action' => array('LessonController@postDeleteLesson', $course->id, $lesson->order))) }}

				<div class="row">
					{{ Form::submit('DELETE', array('class'=>'form-control register-button')) }}
				</div>
				{{ Form::token() }}
				{{ Form::close() }}
				</div>
			</div>
	</div>
</div>
@endsection