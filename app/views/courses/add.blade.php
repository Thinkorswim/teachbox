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
		  <li role="presentation"><a href="">About the course</a></li>
		  <li role="presentation"><a href="{{ URL::action('CourseController@courseQuestion', [$course->id]) }}"> Discussion </a></li>
		  <li role="presentation"><a href="#">Students</a></li>
		</ul>
	</div>
</div>
<div class="container">
	<div class="col-xs-12 col-sm-8">
		<div class="panel panel-default settings-panel actions">
		  <div class="panel-heading">
		    <h3 class="panel-title">Add lesson</h3>
		  </div>
		  <div class="panel-body padding-panel">   
			{{ Form::open(array('action' => array('CourseController@coursePostAdd', $course->id), 'enctype' => 'multipart/form-data', 'files' => true  )) }}                          
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-book"></i>
					</span> 
					 {{ Form::text('name', null, array('placeholder' => 'Lesson name', 'class'=>'form-control')) }}
					 @if($errors->has('name'))
						{{ $errors->first('name') }}
					@endif
				</div>
				<div class="input-group">
					 {{ Form::textarea('description', null, array('placeholder' => 'Describe the lesson', 'class'=>'form-control')) }}
					 @if($errors->has('description'))
						{{ $errors->first('description') }}
					 @endif
				</div>
				<div>Upload image</div>
				<input id="uploadFile" placeholder="Choose File" disabled="disabled" />
				<div class="fileUpload btn btn-primary">
				    <span>Choose a picture</span>
			    	{{ Form::file('video', array('id'=>'uploadBtn','class'=>'upload')) }} 
			    </div> 
				{{ Form::submit('Upload', array('class'=>'form-control')) }}
			{{ Form::close() }}
		  </div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-4">
		@if (Auth::user()->id == $course->user_id)
		<div class="panel panel-default actions">
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