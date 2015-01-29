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
		@if (!$isFollowing && $user->id != Auth::user()->id)
			{{ Form::open(array('action' => array('ProfileController@postFollow', $user->id))) }}
				@if(Auth::check())
					{{ Form::token() }}
						{{ Form::button('<i class="fa fa-user-plus"></i>', array('type' => 'submit','class'=>'follow-circle',
						 'data-toggle' =>'tooltip','data-placement' =>'left','title' => 'Follow  '. $user->name)) }}
				@endif
			{{ Form::close() }}
		@else
			{{ Form::open(array('action' => array('ProfileController@postUnfollow', $user->id))) }}
				@if(Auth::check())
					{{ Form::token() }}
						{{ Form::button('<i class="fa fa-user-times"></i>', array('type' => 'submit','class'=>'follow-circle',
						 'data-toggle' =>'tooltip','data-placement' =>'left','title' => 'Unfollow  '. $user->name)) }}
				@endif
			{{ Form::close() }}		
		@endif
		<h1>{{ $user->name }}</h1>
		<h5>{{ $user->email }}</h5>
		<small>{{$followersCount}} followers | {{$followingCount}} following</small>
	</div>
	<div class="tabs-profile">
		<div class="container">
			<ul class="nav nav-pills">
			  <li role="presentation"><a href="{{ URL::action('ProfileController@user', [$user->id]) }}">Timeline</a></li>
			  <li role="presentation" class="active"><a href="{{ URL::action('ProfileController@userCourses', [$user->id]) }}">Courses</a></li>
			  <li role="presentation"><a href="{{ URL::action('ProfileController@userFollowers', [$user->id]) }}">Followers</a></li>
			  <li role="presentation"><a href="{{ URL::action('ProfileController@userFollowing', [$user->id]) }}">Following</a></li>
			</ul>
		</div>
	</div>
	<div class="container">
		<div class="col-xs-12 col-sm-8">
		@if(count($createdList) > 0)
			<div class="row">
				<h2>Created courses</h2>
				@foreach ($createdList as $course)
					<div class="col-xs-12 col-sm-6 course">
						<div class="panel panel-default course-panel">
						  <div class="panel-body">
							  <a href="{{ URL::action('CourseController@course', [$course->id]) }}">
								<img src="{{ URL::asset('courses/'. $course->id . '/3x2' . $course->pic) }}">
							  </a>
							  <img class="ribbon" src="{{ URL::asset('img/free.png')}}">
						  	  <h4><a href="{{ URL::action('CourseController@course', [$course->id]) }}"> {{ $course->name; }} </a></h4>
							   <p><a href="{{ URL::action('ProfileController@user', $user->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"></a>
						  	  <strong><a href="{{ URL::action('ProfileController@user', $course->user_id) }}"> {{  $user->name }} </a></strong></p>
							  <p>{{ excerpt($course->description) }}</p>	
						  </div>
						</div>
					</div>
				@endforeach
			</div>
			@endif
			@if(count($joinedList) - count($createdList) > 0)
			<h2>Enrolled courses</h2>
			@foreach ($joinedList as $course)
				@if ($course->user_id != Auth::user()->id)
					<div class="col-xs-12 col-sm-6 course">
						<div class="panel panel-default course-panel">
						  <div class="panel-body">
							  <a href="{{ URL::action('CourseController@course', [$course->id]) }}">
								<img src="{{ URL::asset('courses/'. $course->id . '/3x2' . $course->pic) }}">
							  </a>
							  <img class="ribbon" src="{{ URL::asset('img/free.png')}}">
						  	  <h4><a href="{{ URL::action('CourseController@course', [$course->id]) }}"> {{ $course->name; }} </a></h4>
						  </div>
						</div>
					</div>
				@endif
			@endforeach
			@endif
	    </div>
	<div class="col-xs-12 col-sm-4">
			
    </div>
@endsection