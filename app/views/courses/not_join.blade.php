@extends('layouts.master-after')

@section('content')
{{ Form::open(array('action' => array('CourseController@postJoin', $course->id))) }}
	<div class="course-section">
		<div class="container">
			<div class="col-xs-3">
				<img src="{{ URL::asset('courses/'. $course->id . '/' . $course->pic) }}" alt="{{ $course->name }}"/>
			</div>
			<div class="col-xs-9">
					<h1>{{ $course->name }}</h1>
				    <h5> by <a href="{{ URL::action('ProfileController@user', $user->id) }}"> {{ $user->name; }} </a></h5>
			@if(Auth::check())
				{{ Form::token() }}
				{{ Form::submit('Join', array('class'=>'btn btn-default')) }}
			@endif
			</div>
		</div>
	</div>
	{{ Form::close() }}	
@endsection