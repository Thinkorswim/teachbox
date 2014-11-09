@extends('layouts.master-after')

@section('content')
	User Email: {{ $user->email }}
	<br><br>
	Pic: <img src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}" style="witdh:300px;height:225;">
	<br><br>
	<a href="{{ URL::action('ProfileController@changePic', [$user->id]) }}"> Change picture </a>
@endsection