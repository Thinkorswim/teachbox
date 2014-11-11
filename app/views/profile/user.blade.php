@extends('layouts.master-after')

@section('content')
	User Email: {{ $user->email }}
	<br><br>
	User Name: {{ $user->name }}
	<br><br>
	Country: {{ $user->country }}
	<br><br>
	City: {{ $user->city }}
	<br><br>
	Date of birth: {{ $user->date }}
	<br><br>
	Pic: <img src="{{ URL::asset('img/'. Auth::user()->id . '/' . Auth::user()->pic) }}" style="width:200px;height:200px;">
	<br><br>
	
@endsection