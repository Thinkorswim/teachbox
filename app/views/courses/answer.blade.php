
@extends('layouts.master-after')

@section('title')
	{{ $question->title }} -
@stop

@section('description')
	{{ excerpt($question->question) }}
@stop

@section('fb-image')
	{{ URL::asset('courses/'. $course->id . '/img/' . $course->pic) }}
@stop


@section('content')

	<div class="course-section">
		<div class="container">
			<div class="col-xs-12 col-md-3">
			<div class="activity_rounded">
				<img src="{{ URL::asset('courses/'. $course->id . '/img/' . $course->pic) }}" alt="{{ $course->name }}">
			</div>
			<span class="age" data-toggle="tooltip" data-placement="right" title="@if($studentCount == 1) {{ $studentCount ." student" }}@else{{ $studentCount ." students" }}@endif">
						{{ $studentCount }}
					</span>
			</div>
			<div class="col-xs-12 col-xs-9">
				<h1>{{ $course->name }}</h1>
				<h4> in <strong><a href="{{ URL::action('CourseController@category', $course->category) }}"> {{ $course->category; }} </a></strong></h4>
				<h5> by <strong><a href="{{ URL::action('ProfileController@user', $user->id) }}"> {{ $user->name; }} </a></strong></h5>
				<h5>
					 <strong>@for ($i=1; $i <= 5 ; $i++)
						<span class="fa fa-star{{ ($i <= $avgReview) ? '' : '-o'}}"></span>
					@endfor</strong>
				</h5>
			</div>
		</div>
	</div>
	<div id="visible" class="tabs-profile">
		<div class="container">
			<ul class="nav nav-pills">
			  <li role="presentation" ><a href="{{ URL::action('CourseController@course', [$course->id]) }}">About the course</a></li>
			  <li role="presentation" class="active"><a href="{{ URL::action('DiscussionController@courseQuestion', [$course->id]) }}"> Discussion </a></li>
			  <li role="presentation"><a href="{{ URL::action('StudentController@courseStudents', [$course->id]) }}">Students</a></li>
			</ul>
		</div>
	</div>
	<div id="hidden" class="tabs-profile hidden">
		<div class="container">
			<ul class="nav nav-pills">
			  <li role="presentation" ><a href="{{ URL::action('CourseController@course', [$course->id]) }}">About the course</a></li>
			  <li role="presentation" class="active"><a href="{{ URL::action('DiscussionController@courseQuestion', [$course->id]) }}"> Discussion </a></li>
			  <li role="presentation"><a href="{{ URL::action('StudentController@courseStudents', [$course->id]) }}">Students</a></li>
			</ul>
		</div>
	</div>
	<div class="container follow">
	<div class="row">
    <div  class="col-xs-12 col-sm-4 col-sm-push-8">
			@if (Auth::user()->id == $course->user_id)
			<div class="panel panel-default actions">
			  <div class="panel-heading">
			    <h3 class="panel-title">Actions</h3>
			  </div>
			  <div class="panel-body">
				<div class="list-group">
				  <a class="list-group-item" href="{{ URL::action('LessonController@courseAdd', [$course->id]) }}"><i class="fa fa-plus fa-fw"></i> Add Lesson</a>
				  <a class="list-group-item" href="{{ URL::action('CourseController@courseEdit', [$course->id]) }}"><i class="fa fa-edit fa-fw"></i> Edit Course</a>
				</div>
			  </div>
			</div>
			@endif
		    @if(Auth::check() && !$isJoined)
			    <div class="panel panel-default settings-panel actions join ask">
				    {{ Form::open(array('action' => array('CourseController@postJoin', $course->id))) }}
								{{ Form::token() }}
								{{ Form::submit('Take this course', array('class'=>'btn btn-default join')) }}

					{{ Form::close() }}
				</div>
			@endif
			<div class="panel panel-default author-card student-card">
				<div class="panel-heading">
					<h3 class="panel-title">About the tutor</h3>
				</div>
			  <div class="panel-body padding-panel author">
			  		<a href="{{ URL::action('ProfileController@user', [$user->id]) }}">
			  		<img src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"alt="{{ $user->name }}'s profile">
			  		</a>
					@if ($user->date != '')
					<span class="age" data-toggle="tooltip" data-placement="left" title="{{ageCalculator( $user->date )}} years old">
						{{ageCalculator( $user->date )}}
					</span>
					@endif
				    @if ($user->country != '')
					<span class="country" style="background:url('{{ URL::asset(countryFlag( $user->country ))}}') center center"
						data-toggle="tooltip" data-placement="left" title="{{ $user->city }}@if($user->city != '' && $user->country != ''), @endif {{ $user->country }}">
					</span>
					@endif
			  		<h4><a href="{{ URL::action('ProfileController@user', [$user->id]) }}">{{ $user->name }} </a></h4>
			  		<small>{{ $user->city }}@if($user->city != '' && $user->country != ''), @endif {{ $user-> country }}</small>
			  	</div>
				<div class="row">
				@if($user->decription != '')
				<hr>

					<p>{{$user->decription}}</p>
				@endif
				</div>
			</div>
			<?php $num = 1;
$isMore = true;?>
			@foreach($rankingList as $ranking)
				@if ($ranking->id != $course->user_id)
					<?php $isMore = false;?>
				@endif
			@endforeach

			@if(!$isMore)
			<div class="panel panel-default actions rankings">
				<div class="panel-heading">
					<h3 class="panel-title">Ranking</h3>
				</div>
			  	<div class="panel-body">
					<div class="list-group">
					@foreach($rankingList as $ranking)
					@if ($ranking->id != $course->user_id && $doneArray[$num] == 100)
					 <a class="list-group-item" href="{{ URL::action('ProfileController@user', $ranking->id) }}">
					<strong><?php echo $num;?>.</strong> {{$ranking->name}}  <span class="pull-right">{{$ranking->avg}}%</span>
					 </a>
					 <?php $num++;?>
					 @endif

					@endforeach
					</div>
				</div>
			</div>
			@endif
	    </div>
		<div class="col-xs-12 col-sm-8 col-sm-pull-4">
			<div class="panel panel-default settings-panel actions question">
			<div class="panel-heading">
			  	<h3 class="panel-title">
			  	{{ $question->title }}
			  	</h3>
			</div>
			  <div class="panel-body padding-panel">

			  	<p>{{ $question->question }}</p>
			  	<?php $user = User::find($question->user_id)?>
			  	<a href="{{ URL::action('ProfileController@user', $user->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"></a>
				<strong> <a href="{{ URL::action('ProfileController@user', $user->id) }}"> {{ $user->name; }} </a> </strong>
			  </div>
			</div>
			@if (count($answerList) > 0)
			  		@foreach ($answerList as $answer)
					 <div class="panel panel-default settings-panel actions question">
					  	<div class="panel-body padding-panel">
						  	<p>{{ $answer->answer }} </p>
						  	<?php $user = User::find($answer->user_id)?>
						  	<a href="{{ URL::action('ProfileController@user', $user->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"></a>
							<strong> <a href="{{ URL::action('ProfileController@user', $user->id) }}"> {{ $user->name; }} </a> </strong>
						</div>
					 </div>
				   	@endforeach
			 @endif
		<div class="col-xs-12 col-sm-8 answer">
			<div class="panel panel-default settings-panel actions">
			<div class="panel-heading">
			  	<h3 class="panel-title">Answer</h3>
			</div>
			  <div class="panel-body padding-panel">
				{{ Form::open(array('action' => array('DiscussionController@postCourseAnswer', $course->id, $question->id), 'enctype' => 'multipart/form-data')) }}
				@if($errors->has('answer'))
				<div class="input-group shown" data-toggle="tooltip" title="{{ $errors->first('answer') }}">
				@else
				<div class="input-group">
				@endif
				{{ Form::textarea('answer', null, array('rows' => '5', 'placeholder' => 'Answer the question', 'class'=>'form-control')) }}
				</div>
					{{ Form::submit('Answer', array('class'=>'form-control')) }}
				{{ Form::close() }}
				</div>
			</div>
	   </div>
	   </div>

			</div>
	    </div>
    </div>



@endsection