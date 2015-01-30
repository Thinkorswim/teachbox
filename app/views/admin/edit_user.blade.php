@extends('layouts.master-admin')
 
@section('title') Edit User @stop
 
@section('content')
 
<div class='col-lg-4 col-lg-offset-4'>
 
    <h1>Edit User</h1>

 
    {{ Form::open(array('action' => array('AdminController@updateUser', $user->id))) }}
    
    <div class='form-group'>
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', $user->name, array('class'=>'form-control')) }}
    </div>
 
    <div class='form-group'>
        {{ Form::label('email', 'Email') }}
        {{ Form::text('email', $user->email, array('class'=>'form-control')) }}
    </div>

    <div class='form-group'>
        {{ Form::label('admin', 'Is admin') }}
        {{ Form::text('admin', $user->admin, array('class'=>'form-control')) }}
    </div>


    <div class='form-group'>
        {{ Form::submit('Save', ['class' => 'btn btn-primary']) }}
    </div>
 
    {{ Form::close() }} 

</div>

@stop
