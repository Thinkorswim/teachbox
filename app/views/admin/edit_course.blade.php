@extends('layouts.master-admin')
 
@section('title') Edit Course @stop
 
@section('content')
 
<div class='col-lg-4 col-lg-offset-4'>
 

    <h1>Edit Course</h1>
 
    {{ Form::open(array('action' => array('AdminController@updateCourse', $course->id))) }}
    
    <div class='form-group'>
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', $course->name, array('class'=>'form-control')) }}
    </div>
 
    <div class='form-group'>
        {{ Form::label('description', 'Description') }}
        {{ Form::textarea('description', $course->description, array('class'=>'form-control')) }}
    </div>

    <div class='form-group'>
        {{ Form::submit('Save', ['class' => 'btn btn-primary']) }}
    </div>
 
    {{ Form::close() }} 

 
</div>

@stop
