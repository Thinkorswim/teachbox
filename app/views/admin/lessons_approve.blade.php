@extends('layouts.master-admin')
 
@section('content')
 
<div class="container">

  <div class="tabs-profile fixed">
          <div class="container">
            <ul class="nav nav-pills">
              <li><a href="{{ URL::action('AdminController@coursesApprove') }}">Courses</a></li>
              <li class="active" role="presentation"><a href="{{ URL::action('AdminController@lessonsApprove') }}">Lessons</a></li>
            </ul>
          </div>
        </div>
    <div class="row place">
        <h2 class="place"> Lessons for approvement </h2>
        <div class="col-xs-12"> 
				@if(count($lessons) > 0)
				<div class="panel panel-default actions">
				  <div class="panel-heading">
				  	<h3 class="panel-title">Lessons</h3>
				  </div>
				  <div class="panel-body">
				  <div class="list-group tutor-list">
							@foreach ($lessons as $lesson)
                    <?php $course = Course::find($lesson->course_id);
                          $user = User::find($course->user_id); ?>
                <div class="list-group-item">
							 	<a href="{{ URL::action('LessonController@courseLesson', [$course->id, $lesson->order]  ) }}"> {{ $lesson->name; }}</a>
                from <a href="{{ URL::action('CourseController@course', [$course->id]) }}">{{$course->name}}</a>
                by <a href="{{ URL::action('ProfileController@user', [$user->id]) }}">{{$user->name}}</a> 
                                {{ Form::open(array('action' => array('AdminController@approveLesson', $lesson->id))) }}
                                    @if(Auth::check())
                                        {{ Form::token() }}
                                            {{ Form::button('<i class="fa fa-check"></i>', array('type' => 'submit','class'=>'edit-lesson')) }}
                                    @endif
                                {{ Form::close() }}
                                {{ Form::open(array('action' => array('AdminController@deleteLesson', $lesson->id))) }}
                                    @if(Auth::check())
                                        {{ Form::token() }}
                                            {{ Form::button('<i class="fa fa-times"></i>', array('type' => 'submit','class'=>'delete-lesson')) }}
                                    @endif
                                {{ Form::close() }}
                      </div>
							@endforeach
			    		</div>
			    	{{ $lessons->links() }}
			       </div>
			    </div>
			    @endif
        </div>
        <div class="col-xs-12 col-sm-4">
    	</div>
</div>
@endsection



