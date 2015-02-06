@extends('layouts.master-after')

@section('content')

	<div class="course-section">
		<div class="container">
			<div class="col-xs-12 col-md-3">
					<img src="{{ URL::asset('courses/'. $course->id . '/' . $course->pic) }}" alt="{{ $course->name }}"/>
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
	<div class="container">

		<div class="col-xs-12 col-sm-8">
		@if (count($questionList) > 0)
		<div class="panel panel-default actions">
		  <div class="panel-heading">
		  	<h3 class="panel-title">Questions</h3>
		  </div>
		  <div class="panel-body"> 
			  	<div class="list-group">
					@foreach ($questionList as $question)
					 	<a class="list-group-item" href="{{ URL::action('CourseController@courseAnswer', [$course->id, $question->id]) }}">
					 		 {{ $question->title; }} 
					 	</a>
					@endforeach
	    		</div>
	       </div>
	    </div>
	    @endif
		</div>
	    <div class="col-xs-12 col-sm-4">
	    	<div class="panel panel-default settings-panel actions">
				<div class="panel-heading">
				  	<h3 class="panel-title">Ask your question</h3>
				</div>
			  	<div class="panel-body padding-panel">   
				{{ Form::open(array('action' => array('CourseController@postCourseQuestion', $course->id), 'enctype' => 'multipart/form-data')) }}                          
						 @if($errors->has('title'))
						<div class="input-group shown" data-toggle="tooltip" title="{{ $errors->first('title') }}">      
						@else             
						<div class="input-group">
						@endif  
						<span class="input-group-addon">
							<i class="fa fa-question-circle"></i>
						</span> 
						 {{ Form::text('title', null, array('placeholder' => 'Title', 'class'=>'form-control')) }}
					</div>
						 @if($errors->has('question'))
						<div class="input-group shown" data-toggle="tooltip" title="{{ $errors->first('question') }}">      
						@else             
						<div class="input-group">
						@endif  
						 {{ Form::textarea('question', null, array('rows' => '5', 'placeholder' => 'Describe the question', 'class'=>'form-control')) }}
					</div>
					{{ Form::submit('Post', array('class'=>'form-control')) }}
				{{ Form::close() }}
			  </div>
			</div>
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
@endsection