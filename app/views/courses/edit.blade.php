@extends('layouts.master-after')

@section('title')
	Edit {{ $course->name }} -
@stop

@section('description')
	{{ excerpt($course->description) }}
@stop

@section('fb-image')
	{{ URL::asset('courses/'. $course->id . '/img/' . $course->pic) }}
@stop

@section('content')
<div class="course-section">
	<div class="container">
		<div class="col-xs-12 col-md-3">
			<div class="activity_rounded">
				<img src="{{ URL::asset('courses/'. $course->id . '/img/' . $course->pic) }}" alt="{{ $course->name }}">
			</div>
				<span class="age" data-toggle="tooltip" data-placement="right" title="@if($studentCount == 1) {{ $studentCount ." student" }}@else{{ $studentCount ." students" }}@endif">
					{{ $studentCount }}
				</span>
		</div>
		<div class="col-xs-12 col-md-9">
			<h1>{{ $course->name }}</h1>
			<h4> in <strong><a href="{{ URL::action('CourseController@category', $course->category) }}"> {{ $course->category; }} </a></strong></h4>
			<h5> by <strong><a href="{{ URL::action('ProfileController@user', $user->id) }}"> {{ $user->name; }} </a></strong></h5>
			<h5>
				 <strong>@for ($i=1; $i <= 5 ; $i++)
					<span class="fa fa-star{{ ($i <= $avgReview) ? '' : '-o'}}"></span>
				@endfor</strong>
				<small class="number">({{$reviewCount}} reviews)</small>
			</h5>
		</div>
	</div>
</div>
<div id="visible" class="tabs-profile">
	<div class="container">
		<ul class="nav nav-pills">
		  <li role="presentation"><a href="{{ URL::action('CourseController@course', [$course->id]) }}">About the course</a></li>
		<li role="presentation"><a href="{{ URL::action('LessonController@lessons', [$course->id]) }}"> Lessons </a></li>
		  <li role="presentation"><a href="{{ URL::action('DiscussionController@courseQuestion', [$course->id]) }}"> Discussion </a></li>
		<li role="presentation"><a href="{{ URL::action('StudentController@courseStudents', [$course->id]) }}">Students</a></li>
		</ul>
	</div>
</div>
<div id="hidden" class="tabs-profile hidden">
	<div class="container">
		<ul class="nav nav-pills">
		  <li role="presentation"><a href="{{ URL::action('CourseController@course', [$course->id]) }}">About the course</a></li>
		 <li role="presentation"><a href="{{ URL::action('LessonController@lessons', [$course->id]) }}"> Lessons </a></li>
		  <li role="presentation"><a href="{{ URL::action('DiscussionController@courseQuestion', [$course->id]) }}"> Discussion </a></li>
			  <li role="presentation"><a href="{{ URL::action('StudentController@courseStudents', [$course->id]) }}">Students</a></li>
		</ul>
	</div>
</div>
<div class="container">
	<div class="col-xs-12 col-sm-8 follow">
		<div class="panel panel-default settings-panel actions place">
		    <div class="panel-heading">
		    	<h3 class="panel-title">Edit course</h3>
		    </div>
		  	<div class="panel-body padding-panel">
				{{ Form::open(array('action' => array('CourseController@postCourseEdit', $course->id), 'files' => true )) }}
						@if($errors->has('pic'))
							<div class="alert alert-danger" role="alert"> {{ $errors->first('pic') }} </div>
						@endif
						Description:
						@if($errors->has('description'))
						<div class="input-group shown" data-toggle="tooltip" title="{{ $errors->first('description') }}">
						@else
						<div class="input-group">
						@endif
						{{ Form::textarea('description', $course->description, array('class'=>'form-control')) }}
						</div>


						<div class="row">
							<img id="profile" class="circle" src="{{ URL::asset('courses/'. $course->id . '/img/' . $course->pic) }}" alt="{{ $course->name }}">
							<div class="fileUpload btn btn-primary">
							    <span>Change the picture</span>
								{{ Form::file('image', array('id'=>'uploadBtn','class'=>'upload'))}}
							</div>
						</div>
						<div class="row-add">
							<div class="alert alert-info" role="alert">
								<p>Please upload only png and jpg files with maximum size 4mb.</p>
							</div>
						</div>
					{{ Form::token() }}
					{{ Form::submit('Save settings', array('class'=>'form-control register-button')) }}
				{{ Form::close() }}
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-4">
		@if (Auth::user()->id == $course->user_id)
		<div class="panel panel-default actions place">
		  <div class="panel-heading">
		    <h3 class="panel-title">Actions</h3>
		  </div>
		  <div class="panel-body">
			<div class="list-group">
			  <a class="list-group-item" href="{{ URL::action('LessonController@courseAdd', [$course->id]) }}"><i class="fa fa-plus fa-fw"></i> Add Lesson</a>
			  <a class="list-group-item active" href="{{ URL::action('CourseController@courseEdit', [$course->id]) }}"><i class="fa fa-edit fa-fw"></i> Edit Course</a>
			</div>
		  </div>
		</div>
		@endif
	    </div>
	</div>
</div>
@endsection