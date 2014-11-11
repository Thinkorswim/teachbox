@extends('layouts.master-after')

@section('content')
	<a href="{{ URL::action('ProfileController@userSettings', [$user->id]) }}"> Edit Profile </a>
	<br> <br>
	<a href="{{ URL::action('ProfileController@changePic', [$user->id]) }}"> Change picture </a>
	<br> <br>
	@if($user->active == 1)
		<a href="{{ URL::action('ProfileController@changePassword', [$user->id]) }}"> Change password </a>
	@endif

	@if(Session::has('global-positive'))
		<div class="alert alert-success" role="alert">
		{{Session::get('global-positive')}}
		</div>
	@endif
	@if(Session::has('global-negative'))
		<div class="alert alert-danger" role="alert">
		{{Session::get('global-negative')}}
		</div>
	@endif

	{{ Form::open(array('action' => array('ProfileController@postUserSettings', $user->id))) }}
		<br><br>
		Name: 
		 {{ Form::text('name', $user->name) }}
		 @if($errors->has('name'))
			{{ $errors->first('name') }}
		@endif
		<br>
		Country: 
		 {{ Form::text('country', $user->country) }}
		 @if($errors->has('country'))
			{{ $errors->first('country') }}
		 @endif
		<br>
		City: 
		 {{ Form::text('city', $user->city) }}
		 @if($errors->has('city'))
			{{ $errors->first('city') }}
		 @endif
		<br>
		Date of birth: 
		{{ Form::selectRange('day', 1, 31, getDay($user->date)) }}
	    {{ Form::selectMonth('month',getMonth($user->date)) }}
		{{ Form::selectRange('year', 2014, 1914, getYear($user->date)) }}
		<br>
		{{ Form::token() }}
		{{ Form::submit('Save Changes') }}
	{{ Form::close() }}	

@endsection