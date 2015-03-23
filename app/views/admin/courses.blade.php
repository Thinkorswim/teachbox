@extends('layouts.master-admin')
 
@section('content')
 
<div class="container">
    <div class="row">
        <h1> Courses </h1>
        <table class="table table-responsive table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Creator</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                <?php $user = User::find($course->user_id); ?>
                <tr>
                    <td>
                        <a href="{{ URL::action('CourseController@course', [$course->id]) }}">{{ $course->name }}</a>
                    </td>
                    <td>
                        <a href="{{ URL::action('ProfileController@user', $user->id) }}">{{ $user->name }}</a>
                    </td>
                    <td> 
                        @if(Auth::check())
                        {{ Form::open(array('action' => array('AdminController@approveCourse', $course->id))) }} 
                        {{ Form::token() }}
                        <div class="btn-group">
                            <a href="{{ URL::action('AdminController@updateCourse', [$course->id]) }}" class="btn btn-info pull-left">
                                <i class="fa fa-edit"></i>Edit
                            </a>
                            @if($course->approved != 1)
                                            {{ Form::button('<i class="fa fa-check"></i> Approve course', array('type' => 'submit','class'=>'btn btn default')) }}
                                    @endif
                                
                        {{ Form::close() }}
                         @endif   
                        </div>
                    </td>
                </tr>
                @endforeach
                {{ $courses->links() }}
                            </tbody>
        </table>
    </div>   
</div>
@endsection