@extends('layouts.master-after')

@section('description')
	
@stop

@section('content')

@if(count($courses) > 0)
<!--
	<section class="carousel-section">
	<div class="container">
		<h2>Featured courses</h2>
		<div id="course-slider" class="carousel slide carousel-fade" data-ride="carousel">
		  <div class="carousel-inner" role="listbox">
		    <?php $isActive = true; ?>
		    @foreach($courses as $course)
		    <?php $user = User::find($course->user_id); ?>
			    @if($isActive)
			    <div class="item active">
					<div class="course">
						<div class="panel panel-default course-panel">
						  <div class="panel-body">
						  	<div class="col-xs-12 col-sm-3">
							  <a href="{{ URL::action('CourseController@course', [$course->id]) }}">
								<img src="{{ URL::asset('courses/'. $course->id . '/img/' . $course->pic) }}">
							  </a>
							</div>
							<div class="col-xs-12 col-sm-9">
						  	  <h3><a href="{{ URL::action('CourseController@course', [$course->id]) }}"> {{ $course->name; }} </a></h3>
							   <p><a href="{{ URL::action('ProfileController@user', $user->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"></a>
						  	  <strong><a href="{{ URL::action('ProfileController@user', $course->user_id) }}"> {{  $user->name }} </a></strong></p>
							  <p>{{ excerpt($course->description) }}</p>
							</div>
						  </div>
						</div>
					</div>
			    </div>
			    <?php $isActive = false; ?>
			    @else
			    <div class="item">
					<div class="course">
						<div class="panel panel-default course-panel">
						  <div class="panel-body">
						  	<div class="col-xs-12 col-sm-3">
							  <a href="{{ URL::action('CourseController@course', [$course->id]) }}">
								<img src="{{ URL::asset('courses/'. $course->id . '/img/' . $course->pic) }}">
							  </a>
							</div>
							<div class="col-xs-12 col-sm-9">
						  	  <h3><a href="{{ URL::action('CourseController@course', [$course->id]) }}"> {{ $course->name; }} </a></h3>
							   <p><a href="{{ URL::action('ProfileController@user', $user->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"></a>
						  	  <strong><a href="{{ URL::action('ProfileController@user', $course->user_id) }}"> {{  $user->name }} </a></strong></p>
							  <p>{{ excerpt($course->description) }}</p>
			
							</div>
						  </div>
						</div>
					</div>
				</div>
			    @endif
		    @endforeach
		</div>  

		</div>
		  Controls 
		  <a class="left carousel-control" href="#course-slider" role="button" data-slide="prev">
		    <span class="fa fa-chevron-left" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="right carousel-control" href="#course-slider" role="button" data-slide="next">
		    <span class="fa fa-chevron-right" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>
	</div>
	</section>
@endif
-->
<div class="container">
		<div class="col-xs-12 col-sm-8 status">
		@if(count($timeline) == 0)
			<div class="panel panel-default settings-panel actions place">
				<div class="panel-body padding-panel">
					<h2><strong>Nothing on the timeline yet.</strong></h2>
				</div>
			</div>
		@endif
		<div class="scroll place">
		@foreach ($timeline as $post)
			@if (is_numeric($post->email))
				  <?php $course = Course::find($post->id); 
				  $userT = User::find($post->email);
				  ?>

				<div class="panel panel-default settings-panel actions">
					<div class="panel-body">
					  	<p class="heading"><a href="{{ URL::action('ProfileController@user', $userT->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $userT->id . '/' . $userT->pic) }}"></a>
						<strong>
						<a href="{{ URL::action('ProfileController@user', $userT->id) }}"> {{  $userT->name }} </a></strong> 
						@if (is_numeric($post->follower_id))
						    joined
						@else
							created
						@endif
						<strong><a href="{{ URL::action('CourseController@course', $course->id) }}"> {{	$course->name }} </a></strong> course.
						</p>
						<div class="clock">
							<small><i class="fa fa-clock-o"></i>{{dateTimeline($post->created_at)}}</small>
						</div>
						<hr>
						<div class="content-status">
							<div class="course">
								<div class="panel panel-default course-panel">
								  <div class="panel-body">
								  	<div class="col-xs-12 col-lg-3">
										<a href="{{ URL::action('CourseController@course', $course->id) }}">
											<img src="{{ URL::asset('courses/'. $course->id . '/img/' . $course->pic) }}">
										</a>
									</div>
									<div class="col-xs-12 col-lg-9">
								  	  <h3><a href="{{ URL::action('CourseController@course', $course->id) }}"> {{$course->name }} </a></h3>
									  @if (is_numeric($post->follower_id))
									   	   <?php  $userF = User::find($post->follower_id); ?>
										   <p><a href="{{ URL::action('ProfileController@user', $userF->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $userF->id . '/' . $userF->pic) }}"></a>
									  	   <strong><a href="{{ URL::action('ProfileController@user', $userF->id) }}"> {{  $userF->name }} </a></strong></p>
										   <p> {{ excerpt($course->description) }}</p>
									  @else
									  	   <p><a href="{{ URL::action('ProfileController@user', $userT->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $userT->id . '/' . $userT->pic) }}"></a>
									  	   <strong><a href="{{ URL::action('ProfileController@user', $userT->id) }}"> {{  $userT->name }} </a></strong></p>
										   <p> {{ excerpt($course->description) }}</p>
				 					  @endif
									</div>
								  </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			@else
				<?php $userT = User::find($post->id);
					  $userF = User::find($post->follower_id);
				?>
				<div class="panel panel-default settings-panel actions">
					<div class="panel-body">
					  	 <p class="heading">
							<a href="{{ URL::action('ProfileController@user', $userF->id) }}">
					  	<img class="small-profile" src="{{ URL::asset('img/'. $userF->id . '/' . $userF->pic) }}"></a>
						 <strong>
							<a href="{{ URL::action('ProfileController@user', $userF->id) }}">
						  {{  $userF->name }}

						  </a></strong>
						 followed
						 <strong><a href="{{ URL::action('ProfileController@user', $userT->id) }}"> {{  $userT->name }} </a></strong>
						 </p>
						<div class="clock">
							<small><i class="fa fa-clock-o"></i>{{dateTimeline($post->created_at)}}</small>
						</div>
					</div>
				</div>
			@endif
		@endforeach
		@if(count($timeline) > 4)
			{{ $timeline->links() }}
		@endif
		</div>
		</div>
		</div>


@endsection
