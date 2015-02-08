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
	    <div class="col-xs-12 col-sm-4 student author-card">
	    		@if(Auth::check())
					{{ Form::token() }}
					{{ Form::submit('Take this course', array('class'=>'btn btn-default join')) }}
				@endif
			<div class="panel panel-default student-card">
				<div class="panel-heading">
					<h3 class="panel-title">About the tutor</h3>
				</div>
			  <div class="panel-body padding-panel author">
			  		<a href="{{ URL::action('ProfileController@user', [$user->id]) }}">
			  		<img src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"alt="{{ $user->name }}'s profile">
			  		</a>
					@if ($user->date != '')
					<span class="age" data-toggle="tooltip" data-placement="left" title="{{ageCalculator( $user->date )}} years old">
						{{ageCalculator( $user->date )}}
					</span>
					@endif 
				    @if ($user->country != '')
					<span class="country" style="background:url('{{ URL::asset(countryFlag( $user->country ))}}') center center" 
						data-toggle="tooltip" data-placement="left" title="{{ $user->city }}, {{ $user->country }}">
					</span>
					@endif
			  		<h4><a href="{{ URL::action('ProfileController@user', [$user->id]) }}">{{ $user->name }} </a></h4>
			  		<small>{{ $user->city }}, {{ $user-> country }}</small>
			  	</div>
				<div class="row">
				<hr>
				@if($user->decription != '')
					<p>{{$user->decription}}</p>
				@endif
				</div>
			</div>
	    </div>
    </div>

@endsection