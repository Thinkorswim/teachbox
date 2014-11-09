@extends('layouts.master-after')

@section('content')
	User Profile: {{ $user->email }}
@endsection