@extends('layouts.master-admin')
 
@section('content')
<div class="container">
          
        <div id="curve_chart" style="width: 100%; height: 500px"></div>
        {{ Form::open(array('action' => array('AdminController@usermails'))) }} 

                {{ Form::token() }}
                                        {{ Form::button('<i class="fa fa-plus"></i> Make spam', array('type' => 'submit','class'=>'btn btn-info pull-left')) }}
                    {{ Form::close() }}
    <h1> Admins </h1>
        <table class="table table-responsive table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admins as $admin)
                <tr>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td><a href="{{ URL::action('AdminController@updateUser', [$admin->id]) }}" class="btn btn-info pull-left">Edit</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
</div>
@endsection