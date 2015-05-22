@extends('layouts.master-after')

@section('title')
  {{ $user->name }}'s courses -
@stop

@section('description')
  	{{ excerpt($user->decription) }}
@stop

@section('fb-image')
	{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}
@stop

@section('content')
	<div class="cover-section">
		<div class="activity_rounded">
			<img src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"alt="{{ $user->name }}'s profile">
		</div>
		@if ($user->date != '')
		<span class="age" data-toggle="tooltip" data-placement="left" title="{{ageCalculator( $user->date )}} years old">
			<?php echo ageCalculator( $user->date ) ?>
		</span>
		@elseif(Auth::check() && $user->id == Auth::user()->id)
		<a href="{{ URL::action('ProfileController@userSettings', [Auth::user()->id]) }}"  class="age" data-toggle="tooltip" data-placement="left" title="Add your age">
			<i class="fa fa-plus"></i>
		</a>
		@endif
		@if ($user->country != '')
		<span class="country" style="background:url('{{ URL::asset(countryFlag( $user->country ))}}') center center"
			data-toggle="tooltip" data-placement="left" title="{{ $user->city }}@if($user->country != '' && $user->city != ''), @endif {{ $user->country }}">
		</span>
		@elseif(Auth::check() && $user->id == Auth::user()->id)
		<a href="{{ URL::action('ProfileController@userSettings', [Auth::user()->id]) }}"  class="country" data-toggle="tooltip" data-placement="left" title="Add your country">
			<i class="fa fa-plus"></i>
		</a>
		@endif
		@if (Auth::check() && !$isFollowing && $user->id != Auth::user()->id)
			{{ Form::open(array('action' => array('ProfileController@postFollow', $user->id))) }}
				@if(Auth::check())
					{{ Form::token() }}
						{{ Form::button('<i class="fa fa-user-plus"></i>', array('type' => 'submit','class'=>'follow-circle',
						 'data-toggle' =>'tooltip','data-placement' =>'left','title' => 'Follow  '. $user->name)) }}
				@endif
			{{ Form::close() }}
		@else
			@if(Auth::check() && $user->id != Auth::user()->id)
			{{ Form::open(array('action' => array('ProfileController@postUnfollow', $user->id))) }}
				@if(Auth::check())
					{{ Form::token() }}
						{{ Form::button('<i class="fa fa-user-times"></i>', array('type' => 'submit','class'=>'follow-circle',
						 'data-toggle' =>'tooltip','data-placement' =>'left','title' => 'Unfollow  '. $user->name)) }}
				@endif
			@endif
			{{ Form::close() }}
		@endif
		@if(Auth::check() && $user->id != Auth::user()->id)
		{{ Form::button('<i class="fa fa-comment"></i>', array(
		'data-toggle'=>'modal', 'data-target'=>'#exampleModal', 'class'=>'message-circle',
		 'data-placement' =>'left','title' => 'Start conversation with  '. $user->name)) }}
		<div class="modal fade settings-panel actions" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
		        <h4 class="modal-title" id="exampleModalLabel">New message to {{ $user->name }}</h4>
		      </div>
		      <div class="modal-body padding-panel">
					{{ Form::textarea('description', null, array('placeholder' => 'Say hi!',
					'rows' => '5', 'class'=>'form-control', 'id' => 'text')) }}
					<div class="row"> 
					{{ Form::submit('Send message', array('class'=>'form-control pull-right', 'id' => 'send-message')) }}
					</div>
		      </div>
		    </div>
		  </div>
		</div>
		@endif
		<h1>{{ $user->name }}</h1>
		@if($user->hide_email == 0)
		<h5>{{ $user->email }}</h5>
		@endif
		<small>{{$followersCount}} followers | {{$followingCount}} following</small>
	</div>
	<div id="visible" class="tabs-profile">
		<div class="container">
			<ul class="nav nav-pills">
			  <li role="presentation"><a href="{{ URL::action('ProfileController@user', [$user->id]) }}">Timeline</a></li>
			  <li role="presentation" class="active"><a href="{{ URL::action('ProfileController@userCourses', [$user->id]) }}">Courses</a></li>
			  <li role="presentation"><a href="{{ URL::action('ProfileController@userFollowers', [$user->id]) }}">Followers</a></li>
			  <li role="presentation"><a href="{{ URL::action('ProfileController@userFollowing', [$user->id]) }}">Following</a></li>
			</ul>
		</div>
	</div>
	<div id="hidden" class="tabs-profile hidden">
		<div class="container">
			<ul class="nav nav-pills">
			  <li role="presentation"><a href="{{ URL::action('ProfileController@user', [$user->id]) }}">Timeline</a></li>
			  <li role="presentation" class="active"><a href="{{ URL::action('ProfileController@userCourses', [$user->id]) }}">Courses</a></li>
			  <li role="presentation"><a href="{{ URL::action('ProfileController@userFollowers', [$user->id]) }}">Followers</a></li>
			  <li role="presentation"><a href="{{ URL::action('ProfileController@userFollowing', [$user->id]) }}">Following</a></li>
			</ul>
		</div>
	</div>
	<div class="container follow">
	<div class="col-xs-12 col-sm-4 col-sm-push-8">
			@if($user->decription != '')
				<div class="panel panel-default actions no-timeline bio">
				  <div class="panel-heading">
				    <h3 class="panel-title">About</h3>
				  </div>
				  <div class="panel-body padding-panel">
					<p>{{$user->decription}}</p>
					</div>
				  </div>
			@endif
    </div>
		<div class="col-xs-12 col-sm-8 col-sm-pull-4">
		<div class="row">
		@if(count($createdList) > 0)
			<h2>Created courses</h2>
				<?php $l=0; ?>
				@foreach ($createdList as $course)
					<div class="col-xs-12 col-sm-6 course two-in-line created">
						<div class="panel panel-default course-panel">
						  <div class="panel-body">
							  <a href="{{ URL::action('CourseController@course', [$course->id]) }}">
								<figure class="effect-winston">
									<img src="{{ URL::asset('courses/'. $course->id . '/img/'. '/3x2' . $course->pic) }}">
									<figcaption>
										<h2><a href="{{ URL::action('ProfileController@user', $user->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"></a>
							  	  		<strong><a href="{{ URL::action('ProfileController@user', $user->id) }}"> {{ $user->name; }} </a></strong></h2>
										<p>
									@for ($m=1; $m <= 5 ; $m++)
										<a href=""><i class="fa fa-star{{ ($m <= $createdAvgReviews[$l]) ? '' : '-o'}}"></i></a>
									@endfor
										</p>
									</figcaption>
								</figure>
							  </a>
						  	  <h4><a href="{{ URL::action('CourseController@course', [$course->id]) }}"> {{ $course->name; }} </a></h4>
						  	  <small>Category: <a href="{{ URL::action('CourseController@category', $course->category) }}"> {{ $course->category; }}</a></small>
							  <p>{{ excerpt($course->description) }}</p>
						  </div>
						</div>
					</div>
					<?php $l++; ?>
				@endforeach
		@else
		@endif
			</div>

			<div class="row">
			<h2>Enrolled courses</h2>
			<?php $i = 0; $myId =  $user->id; ?>
			@if(count($joinedList) - $createdAll > 0)
			@foreach ($joinedList as $course)
				@if ( $course->user_id != $user->id)
				<?php $creator = User::find($course->user_id);?>
					<div class="col-xs-12 col-sm-6 course two-in-line joined">
						<div class="panel panel-default course-panel">
						  <div class="panel-body">
						  <a href="{{ URL::action('CourseController@course', [$course->id]) }}">
							<figure class="effect-winston">
								<img src="{{ URL::asset('courses/'. $course->id . '/img/'. '/3x2' . $course->pic) }}">
								<figcaption>
									<h2><a href="{{ URL::action('ProfileController@user', $creator->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $creator->id . '/' . $creator->pic) }}"></a>
						  	  		<strong><a href="{{ URL::action('ProfileController@user', $course->user_id) }}"> {{ $creator->name; }} </a></strong></h2>
									<p>
								@for ($m=1; $m <= 5 ; $m++)
									<a href=""><i class="fa fa-star{{ ($m <= $avgReviews[$i]) ? '' : '-o'}}"></i></a>
								@endfor
									</p>
								</figcaption>
							</figure>
						  </a>
						  	  <h4><a href="{{ URL::action('CourseController@course', [$course->id]) }}"> {{ $course->name; }} </a></h4>
						  	  <small>Category: <a href="{{ URL::action('CourseController@category', $course->category) }}"> {{ $course->category; }}</a></small>
							  <p>{{ excerpt($course->description) }}</p>
							  @if($doneArray[$i] != 100)
								<div class="progress">
								  <div class="progress-bar"role="progressbar" aria-valuenow="{{$doneArray[$i]}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$doneArray[$i]}}%;">
								  </div>
								</div>
								<div class="col-xs-6"><p><strong>Completed <br>{{$doneArray[$i]}}%</strong></p></div>
								<div class="col-xs-6"><p><strong>
								Grade: @if($doneArray[$i] != 0){{calculateMark($avgArray[$i])}} @else N/A @endif <br>@if($doneArray[$i] != 0){{$avgArray[$i]}}% @endif</strong></p></div>
							@else
								<div class="row completed">
									<h5>Completed!</h5>
									<p>You got <strong>{{calculateMark($avgArray[$i])}}</strong> ({{$avgArray[$i]}}%)</p>
								</div>
								<?php $i++; ?>
							@endif
						  </div>
						</div>
					</div>

				@endif
				
			@endforeach
		@else
			<div class="panel panel-default settings-panel actions">
				<div class="panel-body padding-panel">
					<h4><strong>No enrolled courses yet.</strong></h4>
				</div>
			</div>
		@endif
	    </div>
	</div>

</div>
	@if(!Auth::check())
		<section class="full-screen explore like-it new-here">
			<div class="container">
				<div class="col-xs-3">
				</div>
				<div class="col-xs-12 col-sm-6 text-center">
					<h1>Do you know {{$user->name}}?</h1>
					<a href="{{ URL::route('home') }}" class="btn btn-default">Register and learn together</a>
				</div>
			</div>
		</section>
	@endif
@endsection