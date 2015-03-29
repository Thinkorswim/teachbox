@extends('layouts.master-after')

@section('title')
  {{ $user->name }}'s followers -
@stop

@section('description')
  	{{ excerpt($user->decription) }}
@stop

@section('fb-image')
	{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}
@stop

@section('content')
	<div class="cover-section">
		<div class="activity_rounded">
			<img src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"alt="{{ $user->name }}'s profile">
		</div>
		@if ($user->date != '')
		<span class="age" data-toggle="tooltip" data-placement="left" title="{{ageCalculator( $user->date )}} years old">
			<?php echo ageCalculator( $user->date ) ?>
		</span>
		@elseif(Auth::check() && $user->id == Auth::user()->id)
		<a href="{{ URL::action('ProfileController@userSettings', [Auth::user()->id]) }}"  class="age" data-toggle="tooltip" data-placement="left" title="Add your age">
			<i class="fa fa-plus"></i>
		</a>
		@endif
		@if ($user->country != '')
		<span class="country" style="background:url('{{ URL::asset(countryFlag( $user->country ))}}') center center"
			data-toggle="tooltip" data-placement="left" title="{{ $user->city }}@if($user->country != '' && $user->city != ''), @endif {{ $user->country }}">
		</span>
		@elseif(Auth::check() && $user->id == Auth::user()->id)
		<a href="{{ URL::action('ProfileController@userSettings', [Auth::user()->id]) }}"  class="country" data-toggle="tooltip" data-placement="left" title="Add your country">
			<i class="fa fa-plus"></i>
		</a>
		@endif
		@if (Auth::check() && !$isFollowing && $user->id != Auth::user()->id)
			{{ Form::open(array('action' => array('ProfileController@postFollow', $user->id))) }}
				@if(Auth::check())
					{{ Form::token() }}
						{{ Form::button('<i class="fa fa-user-plus"></i>', array('type' => 'submit','class'=>'follow-circle',
						 'data-toggle' =>'tooltip','data-placement' =>'left','title' => 'Follow  '. $user->name)) }}
				@endif
			{{ Form::close() }}
		@else
			@if(Auth::check() && $user->id != Auth::user()->id)
			{{ Form::open(array('action' => array('ProfileController@postUnfollow', $user->id))) }}
				@if(Auth::check())
					{{ Form::token() }}
						{{ Form::button('<i class="fa fa-user-times"></i>', array('type' => 'submit','class'=>'follow-circle',
						 'data-toggle' =>'tooltip','data-placement' =>'left','title' => 'Unfollow  '. $user->name)) }}
				@endif
			@endif
			{{ Form::close() }}		
		@endif
		@if(Auth::check() && $user->id != Auth::user()->id)
		{{ Form::button('<i class="fa fa-comment"></i>', array(
		'data-toggle'=>'modal', 'data-target'=>'#exampleModal', 'class'=>'message-circle',
		 'data-placement' =>'left','title' => 'Start conversation with  '. $user->name)) }}
		<div class="modal fade settings-panel actions" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
		        <h4 class="modal-title" id="exampleModalLabel">New message to {{ $user->name }}</h4>
		      </div>
		      <div class="modal-body padding-panel">
					{{ Form::textarea('description', null, array('placeholder' => 'Say hi!',
					'rows' => '5', 'class'=>'form-control', 'id' => 'text')) }}
					<div class="row"> 
					{{ Form::submit('Send message', array('class'=>'form-control pull-right', 'id' => 'send-message')) }}
					</div>
		      </div>
		    </div>
		  </div>
		</div>
		@endif
		<h1>{{ $user->name }}</h1>
		<h5>{{ $user->email }}</h5>
		<small>{{$followersCount}} followers | {{$followingCount}} following</small>
	</div>
	<div id="visible" class="tabs-profile">
		<div class="container">
			<ul class="nav nav-pills">
			  <li role="presentation"><a href="{{ URL::action('ProfileController@user', [$user->id]) }}">Timeline</a></li>
			  <li role="presentation"><a href="{{ URL::action('ProfileController@userCourses', [$user->id]) }}">Courses</a></li>
			  <li role="presentation"  class="active"><a href="{{ URL::action('ProfileController@userFollowers', [$user->id]) }}">Followers</a></li>
			  <li role="presentation"><a href="{{ URL::action('ProfileController@userFollowing', [$user->id]) }}">Following</a></li>
			</ul>
		</div>
	</div>
	<div id="hidden" class="tabs-profile hidden">
		<div class="container">
			<ul class="nav nav-pills">
			  <li role="presentation"><a href="{{ URL::action('ProfileController@user', [$user->id]) }}">Timeline</a></li>
			  <li role="presentation"><a href="{{ URL::action('ProfileController@userCourses', [$user->id]) }}">Courses</a></li>
			  <li role="presentation"  class="active"><a href="{{ URL::action('ProfileController@userFollowers', [$user->id]) }}">Followers</a></li>
			  <li role="presentation"><a href="{{ URL::action('ProfileController@userFollowing', [$user->id]) }}">Following</a></li>
			</ul>
		</div>
	</div>
	<div class="container follow">
		<div class="col-xs-12 col-sm-8">
			@if(count($followerList) == 0)
			<div class="panel panel-default settings-panel actions no-timeline">
				<div class="panel-body padding-panel">
					<h2><strong>Doesn't have followers yet.</strong></h2>
					@if (Auth::check() && $user->id == Auth::user()->id)
						<small>Share your profile with your friends.  </small>
					@endif
				</div>
			</div>
			@endif
			@foreach ($followerList as $follower)
			<div class="col-xs-12 col-sm-6 student">
				<div class="panel panel-default student-card">
				  <div class="panel-body padding-panel">
			  		<a href="{{ URL::action('ProfileController@user', [$follower->id]) }}">
			  		<img src="{{ URL::asset('img/'. $follower->id . '/' . $follower->pic) }}"alt="{{ $follower->name }}'s profile">				
					</a>@if ($follower->date != '')
						<span class="age" data-toggle="tooltip" data-placement="right" title="{{ageCalculator( $follower->date )}} years old">
							{{ageCalculator( $follower->date )}}
						</span>
						@endif 
					    @if ($follower->country != '')
						<span class="country" style="background:url('{{ URL::asset(countryFlag( $follower->country ))}}') center center" 
							data-toggle="tooltip" data-placement="right" title="{{ $follower->city }}@if($follower->country != '' && $follower->city != ''), @endif {{ $follower->country }}">
						</span>
						@endif
				  		<h4><a href="{{ URL::action('ProfileController@user', [$follower->id]) }}">{{ $follower-> name }}</a></h4>
				  		<small>{{ $follower->city }}@if($follower->country != '' && $follower->city != ''), @endif {{ $follower->country }}</small>
				  </div>
				</div>
			</div>
			@endforeach
			</div>
		<div class="col-xs-12 col-sm-4">
			@if($user->decription != '')
				<div class="panel panel-default actions bio">
				  <div class="panel-heading">
				    <h3 class="panel-title">About</h3>
				  </div>
				  <div class="panel-body padding-panel">
					<p>{{$user->decription}}</p>
					</div>
				  </div>
			@endif
		</div>
	</div>
	@if(!Auth::check())
		<section class="full-screen explore like-it new-here">
			<div class="container">
				<div class="col-xs-3">
				</div>
				<div class="col-xs-12 col-sm-6 text-center">
					<h1>Do you know {{$user->name}}?</h1>
					<a href="{{ URL::route('home') }}" class="btn btn-default">Register and learn together</a>
				</div>
			</div>
		</section>
	@endif
@endsection