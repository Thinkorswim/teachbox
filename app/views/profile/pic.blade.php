@extends('layouts.master-after')

@section('content')
	{{ Form::open(array('action' => array('ProfileController@userPic', $user->id), 'files' => true  )) }}
		{{ Form::file('image') }}

		{{ Form::submit('upload') }}
	{{ Form::close() }}
@endsection