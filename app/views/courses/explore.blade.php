@extends('layouts.master-after')
@section('title')
	 Explore -
@stop

@section('description')
	Explore the courses in teachbox
@stop

@section('content')

<div class="container follow">
	<div class="col-xs-12 col-sm-8">
		<div class="scroll place">
			@foreach ($courses as $course)
			<?php $user = User::find($course->user_id); ?>
					<div class="course">
						<div class="panel panel-default course-panel">
						  <div class="panel-body">
						  	<div class="col-xs-12 col-lg-3">
							  <a href="{{ URL::action('CourseController@course', [$course->id]) }}">
								<img src="{{ URL::asset('courses/'. $course->id . '/img/' . $course->pic) }}">
							  </a>
							</div>
							<div class="col-xs-12 col-lg-9">
						  	  <h3><a href="{{ URL::action('CourseController@course', [$course->id]) }}"> {{ $course->name; }} </a></h3>
							   <p><a href="{{ URL::action('ProfileController@user', $user->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"></a>
						  	  <strong><a href="{{ URL::action('ProfileController@user', $course->user_id) }}"> {{  $user->name }} </a></strong></p>
							  <p>{{ excerpt($course->description) }}</p>

							</div>
						  </div>
						</div>
					</div>

			@endforeach

		{{ $courses->links() }}
	</div>
	</div>
</div>
@endsection