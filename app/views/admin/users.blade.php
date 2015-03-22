@extends('layouts.master-admin')
 
@section('content')
<div class="container">
    <div class="row">
    <h1> Users </h1>
     <table class="table table-responsive table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Location</th>
                <th>Age</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td><a href="{{ URL::action('ProfileController@user', [$user->id]) }}">{{ $user->name }}</a></td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->city }}, {{ $user->country }}</td>
                <td>
                @if(!empty($user->date))
                    {{ ageCalculator( $user->date ) }}
                @endif
                </td>
                <td>
                    {{ Form::open(array('action' => array('AdminController@makeAdmin', $user->id))) }} 

                            {{ Form::token() }}
                    <div class="btn-group">
                        <a href="{{ URL::action('AdminController@updateUser', [$user->id]) }}" class="btn btn-info pull-left">
                        <i class="fa fa-edit"></i>Edit
                        </a>
                        @if($user->admin != 1)
                                        {{ Form::button('<i class="fa fa-plus"></i> Make admin', array('type' => 'submit','class'=>'btn btn-info pull-left')) }}
                                @endif
                    {{ Form::close() }}
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    
</div>
@endsection