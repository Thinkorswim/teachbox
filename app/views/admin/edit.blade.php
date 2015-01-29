@extends('layouts.master-admin')
 
@section('title') Edit User @stop
 
@section('content')
 
<div class='col-lg-4 col-lg-offset-4'>
 
 
    <h1>Edit User</h1>
 
    {{ Form::model($user, ['role' => 'form', 'url' => '/admin/' . $user->id, 'method' => 'PUT']) }}
 
 
    <div class='form-group'>
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) }}
    </div>
 
    <div class='form-group'>
        {{ Form::label('email', 'Email') }}
        {{ Form::email('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) }}
    </div>

    <div class='form-group'>
        {{ Form::label('admin', 'Is admin') }}
        {{ Form::text('admin', null, ['placeholder' => 'Is admin', 'class' => 'form-control']) }}
    </div>


    <div class='form-group'>
        {{ Form::submit('Save', ['class' => 'btn btn-primary']) }}
    </div>
 
    {{ Form::close() }}
 
</div>

@stop
