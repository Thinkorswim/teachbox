@extends('layouts.master-admin')
 
@section('title') Edit User @stop
 
@section('content')
 
<div class='col-lg-4 col-lg-offset-4'>
 
    <h1>Edit User {{$user->name}}</h1>

 
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
        {{ Form::label('city', 'City') }}
        {{ Form::text('city', $user->city, array('class'=>'form-control')) }}
    </div>
         
        <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-globe"></i>
                    </span>
                 {{ Form::select('country', $country_array, $user->country, array('class'=>'form-control')) }}
        </div>
                <div>Date of birth:</div>
                {{ Form::selectRange('day', 1, 31, getDay($user->date)) }}
                {{ Form::selectMonth('month',getMonth($user->date)) }}
                {{ Form::selectRange('year', 2014, 1914, getYear($user->date)) }}
    <div class='form-group'>
        {{ Form::submit('Save', ['class' => 'btn btn-primary']) }}
    </div>
 
    {{ Form::close() }} 

</div>

@stop
