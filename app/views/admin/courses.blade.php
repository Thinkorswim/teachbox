@extends('layouts.master-admin')
 
@section('content')
 
<div class="col-lg-10 col-lg-offset-1">

    <h1> Courses </h1>
 
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
 
            <thead>
                <tr>
                    <th>Name</th>
                    <th>User id</th>
                    <th>Is approved</th>
                </tr>
            </thead>
 
            <tbody>
                @foreach ($courses as $course)
                <tr>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->user_id }}</td>
                    <td>{{ $course->approved }}</td>
                    <td>
                        <a href="/admin/courses/{{ $course->id }}/edit" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
 
        </table>
    </div>
    
</div>

@endsection