@extends('layouts.master-after')

@section('content')
	<div class="cover-section">
		<img src="{{ URL::asset('img/'. Auth::user()->id . '/' . Auth::user()->pic) }}"alt="{{ $user->name }}'s profile"/>
		<span class="age" data-toggle="tooltip" data-placement="left" title="{{ageCalculator( $user->date )}} years old">
			<?php echo ageCalculator( $user->date ) ?>
		</span>
		<span class="country" style="background:url({{countryFlag( $user->country ) }}) center center" 
			data-toggle="tooltip" data-placement="left" title="{{ $user->city }}, {{ $user->country }}">
		</span>
		<h1>{{ $user->name }}</h1>
		<h5>{{ $user->email }}</h5>
		<small>130 followers | 180 following</small>
	</div>
	<div class="tabs-profile">
		<div class="container">
			<ul class="nav nav-pills">
			  <li role="presentation" class="active"><a href="#">Timeline</a></li>
			  <li role="presentation"><a href="#">Courses</a></li>
			  <li role="presentation"><a href="#">About</a></li>
			  <li role="presentation"><a href="#">Friends</a></li>
			</ul>
		</div>
	</div>
	<div class="container">

	</div>
@endsection