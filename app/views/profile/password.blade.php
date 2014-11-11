@extends('layouts.master-after')

@section('content')


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


	{{ Form::open(array('action' => array('ProfileController@postChangePassword', $user->id))) }}
		
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