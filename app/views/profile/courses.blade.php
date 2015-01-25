@extends('layouts.master-after')

@section('content')
	<div class="cover-section">
		<img src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"alt="{{ $user->name }}'s profile"/>
		@if ($user->date != '')
		<span class="age" data-toggle="tooltip" data-placement="left" title="{{ageCalculator( $user->date )}} years old">
			<?php echo ageCalculator( $user->date ) ?>
		</span>
		@endif 
		@if ($user->country != '')
		<span class="country" style="background:url('{{ URL::asset(countryFlag( $user->country ))}}') center center" 
			data-toggle="tooltip" data-placement="left" title="{{ $user->city }}, {{ $user->country }}">
		</span>
		@endif
		<h1>{{ $user->name }}</h1>
		<h5>{{ $user->email }}</h5>
		<small>130 followers | 180 following</small>
	</div>
	<div class="tabs-profile">
		<div class="container">
			<ul class="nav nav-pills">
			  <li role="presentation"><a href="#">Timeline</a></li>
			  <li role="presentation" class="active"><a href="{{ URL::action('ProfileController@userCourses', [$user->id]) }}">Courses</a></li>
			  <li role="presentation"><a href="{{ URL::action('ProfileController@userFollowers', [$user->id]) }}">Followers</a></li>
			  <li role="presentation"><a href="{{ URL::action('ProfileController@userFollowing', [$user->id]) }}">Following</a></li>
			</ul>
		</div>
	</div>
	<div class="container">
		<div class="col-xs-12 col-sm-8">
			<div class="row">
				<h2>Created courses</h2>
				@foreach ($courseList as $course)
					<div class="col-xs-12 col-sm-4">
						<div class="panel panel-default course-panel">
						  <div class="panel-body">
							  <a href="{{ URL::action('CourseController@course', [$course->id]) }}">
								<img src="http://edition2013.mama-event.com/wmedias/festival/artistes/JeremyLoopsJemSolo.jpg">
							  </a>
						  	  <h4><a href="{{ URL::action('CourseController@course', [$course->id]) }}"> {{ $course->name; }} </a></h4>
						  </div>
						</div>
					</div>
				@endforeach
			</div>
			<h2>Enrolled courses</h2>
			@foreach ($courseList as $course)
					<div class="col-xs-12 col-sm-4">
						<div class="panel panel-default course-panel">
						  <div class="panel-body">
							  <a href="{{ URL::action('CourseController@course', [$course->id]) }}">
								<img src="http://edition2013.mama-event.com/wmedias/festival/artistes/JeremyLoopsJemSolo.jpg">
							  </a>
						  	  <h4><a href="{{ URL::action('CourseController@course', [$course->id]) }}"> {{ $course->name; }} </a></h4>
						  </div>
						</div>
					</div>
			@endforeach
	    </div>
	    <div class="col-xs-12 col-sm-4">
			<h4>Fancy Ads</h4>
    </div>
@endsection