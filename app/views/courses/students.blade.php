@extends('layouts.master-after')


@section('content')

<div class="course-section">
	<div class="container">
		<div class="col-xs-12 col-md-3">
				<img src="{{ URL::asset('courses/'. $course->id . '/' . $course->pic) }}" alt="{{ $course->name }}"/>
				<span class="age" data-toggle="tooltip" data-placement="right" title="{{ $studentCount }} student(s)">
					{{ $studentCount }} 
				</span>
		</div>
		<div class="col-xs-12 col-xs-9">
			<h1>{{ $course->name }}</h1>
			<h5> by <strong><a href="{{ URL::action('ProfileController@user', $user->id) }}"> {{ $user->name; }} </a></strong></h5>
		</div>
	</div>
</div>
<div class="tabs-profile">
	<div class="container">
		<ul class="nav nav-pills">
		  <li role="presentation" ><a href="{{ URL::action('CourseController@course', [$course->id]) }}">About the course</a></li>
		  <li role="presentation" ><a href="{{ URL::action('CourseController@courseQuestion', [$course->id]) }}"> Discussion </a></li>
		  <li role="presentation" class="active"><a href="{{ URL::action('CourseController@courseStudents', [$course->id]) }}">Students</a></li>
		</ul>
	</div>
</div>
<div class="container follow">
	<div class="col-xs-12 col-sm-8">
		@foreach ($studentList as $student)
		@if ($student->id != $user->id)
		<div class="col-xs-12 col-sm-6 student">
			<div class="panel panel-default student-card">
			  <div class="panel-body padding-panel">
			  		<a href="{{ URL::action('ProfileController@user', [$student->id]) }}">
			  		<img src="{{ URL::asset('img/'. $student->id . '/' . $student->pic) }}"alt="{{ $student->name }}'s profile">
			  		</a>
					@if ($student->date != '')
					<span class="age" data-toggle="tooltip" data-placement="left" title="{{ageCalculator( $student->date )}} years old">
						{{ageCalculator( $student->date )}}
					</span>
					@endif 
				    @if ($student->country != '')
					<span class="country" style="background:url('{{ URL::asset(countryFlag( $student->country ))}}') center center" 
						data-toggle="tooltip" data-placement="left" title="{{ $student->city }}, {{ $student->country }}">
					</span>
					@endif
			  		<h4><a href="{{ URL::action('ProfileController@user', [$student->id]) }}">{{ $student->name }} </a></h4>
			  		<small>{{ $student->city }}, {{ $student-> country }}</small>
			  </div>
			</div>
		</div>
		@endif
		@endforeach
   </div>
    <div class="col-xs-12 col-sm-4">
		@if (Auth::user()->id == $course->user_id)
		<div class="panel panel-default actions">
		  <div class="panel-heading">
		    <h3 class="panel-title">Actions</h3>
		  </div>
		  <div class="panel-body">
			<div class="list-group">
			  <a class="list-group-item" href="{{ URL::action('CourseController@courseAdd', [$course->id]) }}"><i class="fa fa-plus fa-fw"></i> Add Lesson</a>
			  <a class="list-group-item" href="{{ URL::action('CourseController@courseEdit', [$course->id]) }}"><i class="fa fa-edit fa-fw"></i> Edit Course</a>
			</div>
			
		  </div>
		</div>
		@endif
    </div>
</div>

@endsection