@extends('layouts.master-after')

@section('content')

<a href="{{ URL::action('CourseController@courseAdd', [$course->id]) }}"> Add Lesson </a>

@endsection