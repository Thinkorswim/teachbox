@extends('layouts.master-after')

@section('title')
	{{ $course->name }} -
@stop

@section('description')
	{{ excerpt($course->description) }}
@stop

@section('content')
{{ Form::open(array('action' => array('CourseController@postJoin', $course->id))) }}
	<div class="course-section">
		<div class="container">
			<div class="col-xs-3">
				<img src="{{ URL::asset('courses/'. $course->id . '/' . $course->pic) }}" alt="{{ $course->name }}"/>
				<span class="age" data-toggle="tooltip" data-placement="right" title="@if($studentCount == 1) {{ $studentCount ." student" }}@else{{ $studentCount ." students" }}@endif">
					{{ $studentCount }} 
				</span>
			</div>
			<div class="col-xs-9">
					<h1>{{ $course->name }}</h1>
				    <h5> by <strong><a href="{{ URL::action('ProfileController@user', $user->id) }}"> {{ $user->name; }} </a></strong></h5>
			@if(Auth::check())
				{{ Form::token() }}
				{{ Form::submit('Join', array('class'=>'btn btn-default')) }}
			@endif
			</div>
		</div>
	</div>
	{{ Form::close() }}	

	<div class="tabs-profile">
		<div class="container">
			<ul class="nav nav-pills">
			  <li role="presentation" class="active"><a href="{{ URL::action('CourseController@course', [$course->id]) }}">About the course</a></li>
			  <li role="presentation" class="disabled"><a href="{{ URL::action('CourseController@courseQuestion', [$course->id]) }}"> Discussion </a></li>
			  <li role="presentation"><a href="{{ URL::action('CourseController@courseStudents', [$course->id]) }}">Students</a></li>
			</ul>
		</div>
	</div>
	<div class="container">
		<div class="col-xs-12 col-sm-8">
			<div class="panel panel-default description">
			  <div class="panel-body">
				<p>{{ $course->description }}</p>
			  </div>
			</div>
		@if (count($lessonList) > 0)
			<?php $i = 1; ?>
		<div class="panel panel-default actions">
		  <div class="panel-heading">
		  	<h3 class="panel-title">Lessons</h3>
		  </div>
		  <div class="panel-body"> 
			  	<div class="list-group">
					@foreach ($lessonList as $lesson)
					 	<div class="list-group-item"><strong><?php echo $i; $i++; ?>.</strong> {{ $lesson->name; }} </div>
					@endforeach
	    		</div>
	       </div>
	    </div>
	    @endif
	    </div>
	    <div class="col-xs-12 col-sm-4">
	    </div>
    </div>

@endsection