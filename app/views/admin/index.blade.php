@extends('layouts.master-admin')
 
@section('title') Users @stop

@section('content')
 
<div class="col-lg-10 col-lg-offset-1">
 
    <h1> Users </h1>
 
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
 
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created at</th>
                    <th>Is admin</th>
                </tr>
            </thead>
 
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->admin }}</td>
                    <td>
                        <a href="/admin/{{ $user->id }}/edit" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
 
        </table>
    </div>
</div>
@endsection