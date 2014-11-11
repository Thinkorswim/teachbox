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
		
		{{ Form::password('password', array('placeholder'=>'Password')) }}
		@if($errors->has('password'))
			{{ $errors->first('password') }}
		@endif
		<br>
		{{ Form::password('new_password', array('placeholder'=>'New Password')) }}
		@if($errors->has('new_password'))
			{{ $errors->first('new_password') }}
		@endif
		<br>
		{{ Form::password('new_password_again', array('placeholder'=>'New Password Again')) }}
		@if($errors->has('new_password_again'))
			{{ $errors->first('new_password_again') }}
		@endif
		<br>

		{{ Form::submit('Change password') }}

		{{ Form::token() }}
	{{ Form::close() }}
@endsection