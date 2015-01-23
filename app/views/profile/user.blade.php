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
			  <li role="presentation" class="active"><a href="#">Timeline</a></li>
			  <li role="presentation"><a href="#">Courses</a></li>
			  <li role="presentation"><a href="#">Followers</a></li>
			  <li role="presentation"><a href="#">Following</a></li>
			</ul>
		</div>
	</div>
	<div class="container">
		@foreach ($courseList as $course)
 			<p> <a href="{{ URL::action('CourseController@course', [$course->id]) }}"> {{ $course->name; }} </a> </p>
   		 @endforeach
	</div>
@endsection