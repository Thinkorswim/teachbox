@extends('layouts.master-after')

@section('content')
	{{ Form::open(['route' => 'create-course']) }}	
		<br><br>
		Name: 
		 {{ Form::text('name') }}
		 @if($errors->has('name'))
			{{ $errors->first('name') }}
		@endif
		<br>
		Description: 
		 {{ Form::text('description') }}
		 @if($errors->has('description'))
			{{ $errors->first('description') }}
		@endif
		<br>
		{{ Form::token() }}
		{{ Form::submit('Create Course') }}
	{{ Form::close() }}	
@endsection