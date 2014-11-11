@extends('layouts.master-after')

@section('content')
	<a href="{{ URL::action('ProfileController@userSettings', [$user->id]) }}"> Edit Profile </a>
	<br> <br>
	<a href="{{ URL::action('ProfileController@changePic', [$user->id]) }}"> Change picture </a>
	<br> <br>
	@if($user->active == 1)
		<a href="{{ URL::action('ProfileController@changePassword', [$user->id]) }}"> Change password </a>
	@endif
	
	{{ Form::open(array('action' => array('ProfileController@postChangePic', $user->id), 'files' => true  )) }}
		{{ Form::file('image') }}

		{{ Form::submit('upload') }}

		{{ Form::token() }}
	{{ Form::close() }}
@endsection