@extends('layouts.master-admin')
 
@section('content')
<div class="col-lg-10 col-lg-offset-1">

    <h1> Users </h1>
 
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
 
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Activated</th>
                    <th>Is admin</th>
                </tr>
            </thead>
 
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->active }}</td>
                    <td>
                    <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>
                    {{ Form::open(array('action' => array('AdminController@makeAdmin', $user->id))) }}
                        @if(Auth::check())
                            {{ Form::token() }}
                                {{ Form::button('<i class="fa fa-user-plus"></i> Make admin', array('type' => 'submit','class'=>'btn btn default')) }}
                        @endif
                    {{ Form::close() }}
                    </td>
                </tr>
                @endforeach
            </tbody>
 
        </table>
    </div>
    
</div>
@endsection