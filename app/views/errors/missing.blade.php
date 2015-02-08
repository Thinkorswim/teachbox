@extends('layouts.master-before')

@section('title')

@stop

@section('description')
	Teach. Learn. Earn. Socialise.
@stop

@section('content')
<div class="missing-page">
	<img alt="Brand" src="{{ URL::asset('img/logo.png') }}">
	<h1>404</h1>
	<p>Someting went terribly wrong! <a href="{{ URL::route('home') }}" >Go home.</a></p>
</div>
@endsection