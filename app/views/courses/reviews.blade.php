
@extends('layouts.master-after')

@section('fb-image')
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
			<div class="col-xs-12 col-md-9">
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
			  <li role="presentation"><a href="{{ URL::action('DiscussionController@courseQuestion', [$course->id]) }}"> Discussion </a></li>
			  <li role="presentation"><a href="{{ URL::action('StudentController@courseStudents', [$course->id]) }}">Students</a></li>
			</ul>
		</div>
	</div>
	<div id="hidden" class="tabs-profile hidden">
		<div class="container">
			<ul class="nav nav-pills">
			  <li role="presentation" ><a href="{{ URL::action('CourseController@course', [$course->id]) }}">About the course</a></li>
			  <li role="presentation"><a href="{{ URL::action('DiscussionController@courseQuestion', [$course->id]) }}"> Discussion </a></li>
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
			<?php $num = 1; ?>
			<div class="panel panel-default actions rankings">
				<div class="panel-heading">
					<h3 class="panel-title">Ranking</h3>
				</div>
			  <div class="panel-body">
			<div class="list-group">
			@foreach($rankingList as $ranking)
			 <a class="list-group-item" href="{{ URL::action('ProfileController@user', $ranking->id) }}"> 
			<strong><?php echo $num; ?>.</strong> {{$ranking->name}}  <span class="pull-right">{{$ranking->avg}}%</span>
			 </a>
			 <?php $num++; ?>
			@endforeach
			</div>
			</div>
			</div>
	    </div>
		<div class="col-xs-12 reviews status col-sm-8 col-sm-pull-4">
		@if(count($reviews) == 0)
			<div class="panel panel-default settings-panel actions no-timeline">
				<div class="panel-body padding-panel">
					<span><h2><strong>No reviews yet.</strong></h2></span>
					
				</div>
			</div>
		@endif
		@foreach($reviews as $review)
			<div class="col-xs-12 col-sm-6 student">
				<div class="panel panel-default settings-panel actions">
					<div class="panel-body">
						<?php $userT = User::find($review->user_id); ?>
					  	<p class="heading"><a href="{{ URL::action('ProfileController@user', $user->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $userT->id . '/' . $userT->pic) }}"></a>
						</strong><a href="{{ URL::action('ProfileController@user', $userT->id) }}"> {{ $userT->name }} </a></strong> 
						rated
					    @for ($i=1; $i <= 5 ; $i++)
					      <span class="fa fa-star{{ ($i <= $review->rating) ? '' : '-o'}}"></span>
					    @endfor
						</p>
						<hr>
						<div class="content-status">
							<p>{{{$review->text}}}</p>
						</div>
					</div>
				</div>
			</div>
		@endforeach
		</div>
	</div>
	</div>
	
@endsection