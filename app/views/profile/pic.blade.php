@extends('layouts.master-after')

@section('content')
	{{ Form::open(array('action' => array('ProfileController@postChangePic', $user->id), 'files' => true  )) }}
		{{ Form::file('image') }}

		{{ Form::submit('upload') }}

		{{ Form::token() }}
	{{ Form::close() }}
@endsection