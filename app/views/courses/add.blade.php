@extends('layouts.master-after')

@section('title')
	Add lesson in {{$course->name}} -
@stop

@section('description')
	{{ excerpt($course->description) }}
@stop

@section('fb-image')
	{{ URL::asset('courses/'. $course->id . '/img/' . $course->pic) }}
@stop

@section('content')
<div class="absolute-icon">
	<i class="fa fa-spinner fa-pulse fa-4x"></i>
</div>
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
			<h5> by <strong><a href="{{ URL::action('ProfileController@user', $user->id) }}"> {{ $user->name; }} </a></strong></h5>
		</div>
	</div>
</div>
<div id="visible" class="tabs-profile">
	<div class="container">
		<ul class="nav nav-pills">
		  <li role="presentation"><a href="{{ URL::action('CourseController@course', [$course->id]) }}">About the course</a></li>
		  <li role="presentation"><a href="{{ URL::action('CourseController@courseQuestion', [$course->id]) }}"> Discussion </a></li>
		  <li role="presentation"><a href="{{ URL::action('CourseController@courseStudents', [$course->id]) }}">Students</a></li>
		</ul>
	</div>
</div>
<div id="hidden" class="tabs-profile hidden">
	<div class="container">
		<ul class="nav nav-pills">
		  <li role="presentation"><a href="{{ URL::action('CourseController@course', [$course->id]) }}">About the course</a></li>
		  <li role="presentation"><a href="{{ URL::action('CourseController@courseQuestion', [$course->id]) }}"> Discussion </a></li>
		  <li role="presentation"><a href="{{ URL::action('CourseController@courseStudents', [$course->id]) }}">Students</a></li>
		</ul>
	</div>
</div>
<div class="container">
	<div class="col-xs-12 col-sm-8">
		<div class="panel panel-default settings-panel actions place upload-panel">
		  <div class="panel-heading">
		    <h3 class="panel-title">Add lesson</h3>
		  </div>
		  <div class="panel-body padding-panel">
		  	{{ Form::open(array('action' => array('CourseController@coursePostAdd', $course->id), 'enctype' => 'multipart/form-data', 'files' => true, 'class'=>'ac-custom ac-radio ac-circle', 'autocomplete'=>'off' )) }}
			<ul class="nav nav-tabs hidden">
			    <li class="active"><a href="#upload" data-toggle="tab">Shipping</a></li>
			    <li><a href="#lesson-info" data-toggle="tab">Quantities</a></li>
			    <li><a href="#test" data-toggle="tab">Summary</a></li>
			    <li><a href="#confirm" data-toggle="tab">Summary</a></li>
			</ul>
		<div class="tab-content">
		    <div role="tabpanel" class="tab-pane  active" id="upload">
		    	@if($errors->has('video'))
					<div class="alert alert-danger" role="alert"> {{ $errors->first('video') }} </div>
				@endif
				<div class="fileUpload btn btn-primary no-upload">
				    <span id="choosen">
				    <i class="fa fa-4x fa-cloud-upload"></i>
				    <h2 class="info-heading">
				    Choose a file to upload</h2></span>
			    	{{ Form::file('video', array('id'=>'uploadBtn','class'=>'upload upload-video-input')) }}
			    </div>
			    <div class="row-add">
							<div class="alert alert-info" role="alert">
								<p>Please upload only *.mp4 files with a maximum length of 5 minutes. Do not refresh while loading.</p>
							</div>
			    </div>
			    <a class="btn btn-primary btnNext pull-right" >Next</a>
		    </div>
		    <div role="tabpanel" class="tab-pane" id="lesson-info">
				@if($errors->has('name'))
				<div class="input-group shown" data-toggle="tooltip" title="{{ $errors->first('name') }}">  
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
				
		    	<div class="row">
			        <a class="btn btn-primary btnPrevious" >Previous</a>
			        <a class="btn btn-primary btnNext pull-right" >Next</a>
		        </div>
		  	</div>
		    <div role="tabpanel" class="tab-pane" id="test">
		    	@if($errors->has('test'))
					<div class="alert alert-danger" role="alert"> {{ $errors->first('test') }} </div>
				@endif
				<section>
					<div class="alert alert-info" role="alert">
						<p><strong>Hint:</strong>Click on any of the green circles to mark the right answer.</p>
					</div>
						<div id="qCollection">
							<div class="row">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-question"></i>
								</span>
									<input placeholder="Your question" class="form-control" name="q1" type="text">
							</div>
							</div>
							<ul id="question-1">
								<div class="row">
								<li><input name="r1" value="11" type="radio">
								<label for="r1">
									<input placeholder="Option 1" class="form-control" name="11" type="text">
								</label></li>
								<li><input name="r1" value="12" type="radio">
								<label for="r1">
									<input placeholder="Option 2" class="form-control" name="12" type="text">
								</label></li>
								</div>
							</ul>
							
							<button type="button" id="1" class="btn btn-default btn-add-choice">Add choice</button>

						</div>

						<button type="button" class="btn btn-default btn-add-question">Add question</button>
				</section>

			    <div class="row blocked">
			        <a class="btn btn-primary btnPrevious" >Previous</a>
			        {{ Form::submit('Submit', array('class'=>'btn btn-primary btnNext pull-right', 'id' => 'upload-video')) }}
			    </div>
		    </div>
		</div>

<!--

				{{ Form::submit('Upload', array('class'=>'form-control', 'id'=>'upload-video')) }}
			{{ Form::close() }}-->
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
			  <a class="list-group-item active" href="{{ URL::action('CourseController@courseAdd', [$course->id]) }}"><i class="fa fa-plus fa-fw"></i> Add Lesson</a>
			  <a class="list-group-item" href="{{ URL::action('CourseController@courseEdit', [$course->id]) }}"><i class="fa fa-edit fa-fw"></i> Edit Course</a>
			</div>
		  </div>
		</div>
		@endif
	</div>
</div>
@endsection