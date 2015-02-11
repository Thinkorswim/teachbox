@extends('layouts.master-after')
@section('title')
	{{$course->name}} -
@stop
@section('description')
	{{ excerpt($course->description) }}
@stop
@section('content')