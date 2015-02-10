






@extends('layouts.master-after')

@section('title')
	{{ $question->title }} -
@stop

@section('description')
	{{ excerpt($question->question) }}
@stop

@section('content')

	<div class="course-section">
		<div class="container">
			<div class="col-xs-12 col-md-3">
					<img src="{{ URL::asset('courses/'. $course->id . '/img/' . $course->pic) }}" alt="{{ $course->name }}"/>
				<span class="age" data-toggle="tooltip" data-placement="right" title="@if($studentCount == 1) {{ $studentCount ." student" }}@else{{ $studentCount ." students" }}@endif">
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
			  <li role="presentation" class="active"><a href="{{ URL::action('CourseController@courseQuestion', [$course->id]) }}"> Discussion </a></li>
			  <li role="presentation"><a href="{{ URL::action('CourseController@courseStudents', [$course->id]) }}">Students</a></li>
			</ul>
		</div>
	</div>
	<div class="container follow">
		<div class="col-xs-12 col-sm-8">
			<div class="panel panel-default settings-panel actions">
			<div class="panel-heading">
			  	<h3 class="panel-title">
			  	{{ $question->title }}
			  	</h3>
			</div>
			  <div class="panel-body padding-panel">

			  	<p>{{ $question->question }}</p>
			  	<?php $user = User::find($question->user_id) ?>
			  	<a href="{{ URL::action('ProfileController@user', $user->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"></a>
				<strong> <a href="{{ URL::action('ProfileController@user', $user->id) }}"> {{ $user->name; }} </a> </strong>
			  </div>
			</div>
			@if (count($answerList) > 0)
			  		@foreach ($answerList as $answer)
					 <div class="panel panel-default settings-panel actions">
					  	<div class="panel-body padding-panel">
						  	<p>{{ $answer->answer }} </p>
						  	<?php $user = User::find($answer->user_id) ?>
						  	<a href="{{ URL::action('ProfileController@user', $user->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"></a>
							<strong> <a href="{{ URL::action('ProfileController@user', $user->id) }}"> {{ $user->name; }} </a> </strong>
						</div>
					 </div>
				   	@endforeach
			 @endif
		<div class="col-xs-12 col-sm-8">
			<div class="panel panel-default settings-panel actions">
			<div class="panel-heading">
			  	<h3 class="panel-title">Answer</h3>
			</div>
			  <div class="panel-body padding-panel">
				{{ Form::open(array('action' => array('CourseController@postCourseAnswer', $course->id, $question->id), 'enctype' => 'multipart/form-data')) }}                          
				@if($errors->has('answer'))
				<div class="input-group shown" data-toggle="tooltip" title="{{ $errors->first('answer') }}">  
				@else             
				<div class="input-group">
				@endif  
				{{ Form::textarea('answer', null, array('rows' => '5', 'placeholder' => 'Answer the question', 'class'=>'form-control')) }}
				</div>
					{{ Form::submit('Answer', array('class'=>'form-control')) }}
				{{ Form::close() }}
				</div>
			</div>
	   </div>
	   </div>
	    <div class="col-xs-12 col-sm-4 author-card">
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