@extends('layouts.master-after')

@section('content')
<div class="container">
	<div class="col-xs-12 col-sm-8">
		<h1>Search for <strong>search term</strong></h1>
		
		
			@foreach ($courses as $course)
			<?php $user = User::find($course->user_id); ?>
					<div class="course">
						<div class="panel panel-default course-panel">
						  <div class="panel-body">
						  	<div class="col-xs-12 col-sm-3">
							  <a href="{{ URL::action('CourseController@course', [$course->id]) }}">
								<img src="{{ URL::asset('courses/'. $course->id . '/' . $course->pic) }}">
							  </a>
							</div>
							<div class="col-xs-12 col-sm-9">
						  	  <h3><a href="{{ URL::action('CourseController@course', [$course->id]) }}"> {{ $course->name; }} </a></h3>
							   <p><a href="{{ URL::action('ProfileController@user', $user->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"></a>
						  	  <strong><a href="{{ URL::action('ProfileController@user', $course->user_id) }}"> {{  $user->name }} </a></strong></p>
							  <p>{{ excerpt($course->description) }}</p>
								<p>{{ Form::open(array('action' => array('CourseController@postJoin', $course->id))) }}
									@if(Auth::check())
										{{ Form::token() }}
										{{ Form::submit('Join', array('class'=>'btn btn-default')) }}
									@endif		
								{{ Form::close() }}		
								</p>			
							</div>					  
						  </div>
						</div>
					</div>
			@endforeach

	</div>
	<div class="col-xs-12 col-sm-4">
		<div class="panel panel-default course-panel">
			<div class="panel-body">
				<img src="http://edition2013.mama-event.com/wmedias/festival/artistes/JeremyLoopsJemSolo.jpg">
				<h3><a href="#"> Heading</a></h3>
				<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit.
				 Aenean aliquam diam ut purus gravida aliquam. Curabitur et lobortis lorem, 
				quis aliquet arcu.</p>
			</div>
		</div>
		<div class="panel panel-default course-panel">
			<div class="panel-body">
				<img src="http://edition2013.mama-event.com/wmedias/festival/artistes/JeremyLoopsJemSolo.jpg">
				<h3><a href="#"> Heading</a></h3>
				<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean aliquam diam ut purus gravida aliquam.
				 Curabitur et lobortis lorem, quis aliquet arcu.</p>
			</div>
		</div>
	</div>
</div>
@endsection