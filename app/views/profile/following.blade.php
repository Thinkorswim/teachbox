@extends('layouts.master-after')

@section('content')
	<div class="cover-section">
		<img src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"alt="{{ $user->name }}'s profile"/>
		@if ($user->date != '')
		<span class="age" data-toggle="tooltip" data-placement="left" title="{{ageCalculator( $user->date )}} years old">
			 {{ ageCalculator( $user->date ) }}
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
		      <li role="presentation"><a href="{{ URL::action('ProfileController@user', [$user->id]) }}">Timeline</a></li>
			  <li role="presentation"><a href="{{ URL::action('ProfileController@userCourses', [$user->id]) }}">Courses</a></li>
			  <li role="presentation"><a href="{{ URL::action('ProfileController@userFollowers', [$user->id]) }}">Followers</a></li>
			  <li role="presentation" class="active"><a href="{{ URL::action('ProfileController@userFollowing', [$user->id]) }}">Following</a></li>
			</ul>
		</div>
	</div>
	<div class="container">

	</div>
@endsection