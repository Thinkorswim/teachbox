@extends('layouts.master-after')

@section('title')
	{{ $course->name }} -
@stop

@section('description')
	{{ excerpt($course->description) }}
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
			<div class="col-xs-12 col-md-9">
					<h1>{{ $course->name }}</h1>
					<h5> in <strong><a href="#"> {{ $course->category; }} </a></strong></h5>
				    <h5> by <strong><a href="{{ URL::action('ProfileController@user', $user->id) }}"> {{ $user->name; }} </a></strong></h5>
			</div>
		</div>
	</div>

	<div id="visible" class="tabs-profile">
		<div class="container">
			<ul class="nav nav-pills">
			  <li role="presentation" class="active"><a href="{{ URL::action('CourseController@course', [$course->id]) }}">About the course</a></li>
			  <li role="presentation"><a href="{{ URL::action('CourseController@courseStudents', [$course->id]) }}">Students</a></li>
			</ul>
		</div>
	</div>

	<div id="hidden" class="tabs-profile hidden">
		<div class="container">
			<ul class="nav nav-pills">
			  <li role="presentation" class="active"><a href="{{ URL::action('CourseController@course', [$course->id]) }}">About the course</a></li>
			  <li role="presentation"><a href="{{ URL::action('CourseController@courseStudents', [$course->id]) }}">Students</a></li>
			</ul>
		</div>
	</div>
	<div class="container follow">
		<div class="col-xs-12 col-sm-8">
			<div class="panel panel-default description">
			  <div class="panel-body">
				<p>{{ $course->description }}</p>
			  </div>
			</div>
		@if (count($lessonList) > 0)
			<?php $i = 1; ?>
		<div class="panel panel-default actions" >
		  <div class="panel-heading">
		  	<h3 class="panel-title">Lessons</h3>
		  </div>
		  <div class="panel-body"> 
			  	<div class="list-group">
					@foreach ($lessonList as $lesson)
					 	<div class="list-group-item" >
							<div class="col-xs-9">
							 	<strong><?php echo $i; $i++; ?>.</strong> {{ $lesson->name; }} 
							</div>
				 			<div class="col-xs-3">
				 			 	<div class="pull-right">{{ $lesson->duration; }}</div> 
				 			</div>
				 		</div>
					@endforeach
	    		</div>
	       </div>
	    </div>
	    @endif
	    </div>
	    <div class="col-xs-12 col-sm-4 student author-card">
		    @if(Auth::check())
			    <div class="panel panel-default settings-panel  join ask">
				    {{ Form::open(array('action' => array('CourseController@postJoin', $course->id))) }}
								{{ Form::token() }}
								{{ Form::submit('Take this course', array('class'=>'btn btn-default join')) }}

					{{ Form::close() }}
				</div>
			@endif
			<div class="panel panel-default student-card">
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
						data-toggle="tooltip" data-placement="left" title="{{ $user->city }}@if($user->country && $user->country), @endif {{ $user->country }}">
					</span>
					@endif
			  		<h4><a href="{{ URL::action('ProfileController@user', [$user->id]) }}">{{ $user->name }} </a></h4>
			  		<small>{{ $user->city }}@if($user->country && $user->country), @endif {{ $user-> country }}</small>
			  	</div>
				<div class="row">
				<hr>
				@if($user->decription != '')
					<p>{{$user->decription}}</p>
				@endif
				</div>
			</div>
	    </div>
    </div>
<section class="reviews status">
	<div class="container">
		<h2>Reviews by students</h2>
		@foreach($reviews as $review)
			<div class="col-xs-12 col-sm-4">
				<div class="panel panel-default settings-panel actions">
					<div class="panel-body">
						<?php $userT = User::find($review->user_id); ?>
					  	<p class="heading"><a href="{{ URL::action('ProfileController@user', $user->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $userT->id . '/' . $userT->pic) }}"></a>
						</strong><a href="{{ URL::action('ProfileController@user', $userT->id) }}"> {{ $userT->name }} </a></strong> 
						rated
					    @for ($i=1; $i <= 5 ; $i++)
					      <span class="fa fa-star{{ ($i <= $review->rating) ? '' : '-empty'}}"></span>
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
          <a class="btn btn-primary" href="{{ URL::action('CourseController@courseReviews', [$course->id]) }}">All reviews</a>
	<div class="modal fade settings-panel actions" id="reviews" tabindex="-1" role="dialog" aria-labelledby="newModal" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
	        <h4 class="modal-title" id="exampleModalLabel"> Login</h4>
	      </div>
	      <div class="modal-body">
            <div id="post-review-box" >
                  {{ Form::open(array('action' => array('CourseController@postCourseReview', $course->id))) }}
                        <input id="ratings-hidden" name="rating" type="hidden"> 
                        <textarea class="form-control animated" cols="50" id="new-review" name="comment" placeholder="Enter your review here..." rows="5"></textarea>
        
                        <div class="text-right">
                            <div class="stars starrr" data-rating="1"></div>
                            <a class="btn btn-danger" href="#" id="close-review-box" style="display:none; margin-right: 10px;">
                            <span class="fa fa-times"></span>Cancel</a>
								{{ Form::token() }}
								<div class="row"> 
								{{ Form::submit('Submit', array('class'=>'btn btn-success')) }}
								</div>
                        </div>
				 {{ Form::close() }}
        </div>
        </div>
        </div>
        </div>
</section>
    	@if(!Auth::check())
		<section class="full-screen explore like-it">
		<div class="container">
			<div class="col-xs-3">
			</div>
			<div class="col-xs-12 col-sm-6 text-center">
				
					<h1>Do you want to take {{$course->name}} course?</h1>
					<a href="{{ URL::route('home') }}" class="btn btn-default">Register for free</a>
			</div>
		</div>
		</section>
		@endif
@endsection