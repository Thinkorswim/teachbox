@extends('layouts.master-admin')
 
@section('content')
 
<div class="container">

  <div class="tabs-profile fixed">
          <div class="container">
            <ul class="nav nav-pills">
              <li class="active"><a href="{{ URL::action('AdminController@coursesApprove') }}">Courses</a></li>
              <li role="presentation"><a href="{{ URL::action('AdminController@lessonsApprove') }}">Lessons</a></li>
            </ul>
          </div>
        </div>
    <div class="row place">
        <h2 class="place"> Courses for approvement </h2>
        <div class="col-xs-12 col-sm-8"> 
            @foreach ($courses as $course)
            <?php $user = User::find($course->user_id); ?>
                    <div class="course">
                        <div class="panel panel-default course-panel">
                          <div class="panel-body">
                            <div class="col-xs-12 col-lg-3">
                              <a href="{{ URL::action('CourseController@course', [$course->id]) }}">
                                <img src="{{ URL::asset('courses/'. $course->id . '/img/' . $course->pic) }}">
                              </a>
                            </div>
                            <div class="col-xs-12 col-lg-9">
                              <h3><a href="{{ URL::action('CourseController@course', [$course->id]) }}"> {{ $course->name; }} </a></h3>
                               <p><a href="{{ URL::action('ProfileController@user', $user->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"></a>
                              <strong><a href="{{ URL::action('ProfileController@user', $course->user_id) }}"> {{  $user->name }} </a></strong></p>
                              <p>{{ excerpt($course->description) }}</p>
                                {{ Form::open(array('action' => array('AdminController@approveCourse', $course->id))) }}
                                    @if(Auth::check())
                                        {{ Form::token() }}
                                            {{ Form::button('<i class="fa fa-check"></i> Approve course', array('type' => 'submit','class'=>'btn btn default')) }}
                                    @endif
                                {{ Form::close() }}
                                {{ Form::open(array('action' => array('AdminController@deleteCourse', $course->id))) }}
                                    @if(Auth::check())
                                        {{ Form::token() }}
                                            {{ Form::button('<i class="fa fa-times"></i> Delete course', array('type' => 'submit','class'=>'btn btn default')) }}
                                    @endif
                                {{ Form::close() }}
                            </div>
                          </div>
                        </div>
                    </div>
                @endforeach
        {{ $courses->links() }}
        </div>
        <div class="col-xs-12 col-sm-4">
    </div>   
</div>
@endsection