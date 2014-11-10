@extends('layouts.master-after')

@section('content')
	User Email: {{ $user->email }}
	{{ $user->name }}
	<br><br>
	Pic: 
	<br><br>
	
@endsection