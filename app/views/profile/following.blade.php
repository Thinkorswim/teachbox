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
		<small>{{$followersCount}} followers | {{count($followingList)}} following</small>
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
	<div class="container follow">
		<div class="col-xs-12 col-sm-8">
			@foreach ($followingList as $follower)
			<div class="col-xs-12 col-sm-6 student">
				<div class="panel panel-default student-card">
				  <div class="panel-body padding-panel">
			  		<a href="{{ URL::action('ProfileController@user', [$follower->id]) }}">
			  			<img src="{{ URL::asset('img/'. $follower->id . '/' . $follower->pic) }}"alt="{{ $follower->name }}'s profile">						@if ($follower->date != '')
					</a>	
						<span class="age" data-toggle="tooltip" data-placement="left" title="{{ageCalculator( $follower->date )}} years old">
							{{ageCalculator( $follower->date )}}
						</span>
						@endif 
					    @if ($follower->country != '')
						<span class="country" style="background:url('{{ URL::asset(countryFlag( $follower->country ))}}') center center" 
							data-toggle="tooltip" data-placement="left" title="{{ $follower->city }}, {{ $follower->country }}">
						</span>
						@endif
				  		<h4><a href="{{ URL::action('ProfileController@user', [$follower->id]) }}">{{ $follower-> name }}</a></h4>
				  		<small>{{ $follower->city }}, {{ $follower->country }}</small>
				  </div>
				</div>
			</div>
			@endforeach
		</div>
		<div class="col-xs-12 col-sm-4">
			<p>some more ads</p>
		</div>
	</div>
@endsection