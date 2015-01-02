@extends('layouts.master-after')

@section('content')
{{ Form::open(array('action' => array('CourseController@postJoin', $course->id))) }}
	<div class="course-section">
		<div class="container">
			<div class="col-xs-3">
				<img src="{{ URL::asset('img/logo.png') }}" alt="kartinka za kursa geiove"/>
			</div>
			<div class="col-xs-9">
				<h1>Course name</h1>
				<h5>by <a href="profilamu">Ivan Lebanov</a></h5>
		{{ Form::token() }}
		{{ Form::submit('Join', array('class'=>'btn btn-default')) }}
			</div>
		</div>
	</div>
	{{ Form::close() }}	
@endsection