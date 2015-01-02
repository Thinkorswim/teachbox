@extends('layouts.master-after')

@section('content')
	<a href="{{ URL::action('CourseController@create')}}"> Create Course </a>
@endsection
