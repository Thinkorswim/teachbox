@extends('layouts.master-after')

@section('content')
{{ Form::open(array('action' => array('CourseController@postJoin', $course->id))) }}
	<div class="course-section">
		<div class="container">
			<div class="col-xs-3">
				<img src="{{ URL::asset('courses/'. $course->id . '/' . $course->pic) }}" alt="{{ $course->name }}"/>
				<span class="age" data-toggle="tooltip" data-placement="right" title="{{ $studentCount }} student(s)">
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
			  <li role="presentation" class="active"><a href="">About the course</a></li>
			  <li role="presentation"><a href="{{ URL::action('CourseController@courseQuestion', [$course->id]) }}"> Discussion </a></li>
			  <li role="presentation"><a href="#">Students</a></li>
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
	    </div>
	    <div class="col-xs-12 col-sm-4">
			<h2>Related courses</h2>
			<div class="panel panel-default course-panel">
				<div class="panel-body">
					<img src="http://theglobalpanorama.com/wp-content/uploads/2014/04/rO5rw2B.jpeg">
					<h3><a href="#"> Heading</a></h3>
					<p> Some text. Get short description around 50 chars.</p>
				</div>
			</div>
			<div class="panel panel-default course-panel">
				<div class="panel-body">
					<img src="http://theglobalpanorama.com/wp-content/uploads/2014/04/rO5rw2B.jpeg">
					<h3><a href="#"> Heading</a></h3>
					<p> Some text. Get short description around 50 chars.</p>
				</div>
			</div>
	    </div>
    </div>

@endsection