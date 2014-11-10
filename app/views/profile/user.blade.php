@extends('layouts.master-after')

@section('content')
	User Email: {{ $user->email }}
	{{ $user->name }}
	<br><br>
	Pic: 
	<br><br>
	<a href="{{ URL::action('ProfileController@changePic', [$user->id]) }}"> Change picture </a>
@endsection