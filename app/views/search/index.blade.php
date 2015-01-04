@extends('layouts.master-after')

@section('content')
	@foreach ($courses as $course)
    	<p>{{ $course->name }}</p>
	@endforeach

@endsection