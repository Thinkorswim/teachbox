@extends('layouts.master-after')

@section('content')
<div class="container">
	<div id="course-slider" class="carousel slide carousel-fade" data-ride="carousel">
	  <div class="carousel-inner" role="listbox">
	    <?php $courses = Course::all()->take(10);
	    $isActive = true; ?>
	    @foreach($courses as $course)
	    <?php $user = User::find($course->user_id); ?>
		    @if($isActive)
		    <div class="item active">
				<div class="course">
					<div class="panel panel-default course-panel">
					  <div class="panel-body">
					  	<img class="ribbon" src="{{ URL::asset('img/free.png')}}">
					  	<div class="col-xs-12 col-lg-3">
						  <a href="{{ URL::action('CourseController@course', [$course->id]) }}">
							<img src="{{ URL::asset('courses/'. $course->id . '/' . $course->pic) }}">
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
		    </div>
		    <?php $isActive = false; ?>
		    @else
		    <div class="item">
				<div class="course">
					<div class="panel panel-default course-panel">
					  <div class="panel-body">
					  	<div class="col-xs-12 col-lg-3">
						  <a href="{{ URL::action('CourseController@course', [$course->id]) }}">
							<img src="{{ URL::asset('courses/'. $course->id . '/' . $course->pic) }}">
						  </a>
						</div>
						<div class="col-xs-12 col-lg-9">
						  <img class="ribbon" src="{{ URL::asset('img/free.png')}}">
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

	  <!-- Controls -->
	  <a class="left carousel-control" href="#course-slider" role="button" data-slide="prev">
	    <span class="fa fa-chevron-left" aria-hidden="true"></span>
	    <span class="sr-only">Previous</span>
	  </a>
	  <a class="right carousel-control" href="#course-slider" role="button" data-slide="next">
	    <span class="fa fa-chevron-right" aria-hidden="true"></span>
	    <span class="sr-only">Next</span>
	  </a>
	</div>
</div>
@endsection
