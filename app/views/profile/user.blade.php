@extends('layouts.master-after')

@section('content')

	<div class="cover-section">
		<img src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"alt="{{ $user->name }}'s profile">
		@if ($user->date != '')
		<span class="age" data-toggle="tooltip" data-placement="left" title="{{ageCalculator( $user->date )}} years old">
			{{ ageCalculator( $user->date ) }}
		</span>
		@endif 
		@if ($user->country != '')
		<span class="country" style="background:url('{{ URL::asset(countryFlag( $user->country ))}}') center center" 
			data-toggle="tooltip" data-placement="left" title="{{ $user->city }}, {{ $user->country }}">
		</span>
		@endif
		@if (!$isFollowing && $user->id != Auth::user()->id)
			{{ Form::open(array('action' => array('ProfileController@postFollow', $user->id))) }}
				@if(Auth::check())
					{{ Form::token() }}
						{{ Form::button('<i class="fa fa-user-plus"></i>', array('type' => 'submit','class'=>'follow-circle',
						 'data-toggle' =>'tooltip','data-placement' =>'left','title' => 'Follow  '. $user->name)) }}
				@endif
			{{ Form::close() }}
		@else
			@if($user->id != Auth::user()->id)
			{{ Form::open(array('action' => array('ProfileController@postUnfollow', $user->id))) }}
				@if(Auth::check())
					{{ Form::token() }}
						{{ Form::button('<i class="fa fa-user-times"></i>', array('type' => 'submit','class'=>'follow-circle',
						 'data-toggle' =>'tooltip','data-placement' =>'left','title' => 'Unfollow  '. $user->name)) }}
				@endif
			@endif
			{{ Form::close() }}		
		@endif
		@if($user->id != Auth::user()->id)
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
					{{ Form::submit('Send message', array('class'=>'form-control', 'id' => 'send-message')) }}
		      </div>
		    </div>
		  </div>
		</div>
		@endif
		<h1>{{ $user->name }}</h1>
		<h5>{{ $user->email }}</h5>
		<small>{{$followersCount}} followers | {{$followingCount}} following</small>
	</div>
	<div class="tabs-profile">
		<div class="container">
			<ul class="nav nav-pills">
			  <li class="active" role="presentation"><a href="{{ URL::action('ProfileController@user', [$user->id]) }}">Timeline</a></li>
			  <li role="presentation"><a href="{{ URL::action('ProfileController@userCourses', [$user->id]) }}">Courses</a></li>
			  <li role="presentation"><a href="{{ URL::action('ProfileController@userFollowers', [$user->id]) }}">Followers</a></li>
			  <li role="presentation"><a href="{{ URL::action('ProfileController@userFollowing', [$user->id]) }}">Following</a></li>
			</ul>
		</div>
	</div>
	<div class="container">
		<div class="col-xs-12 col-sm-8 status">
		<div class="scroll">
		@foreach ($timeline as $post)
			@if (is_numeric($post->email))
			<?php $course = Course::find($post->id); 
				  $userT = User::find($post->email)?>
				<div class="panel panel-default settings-panel actions">
					<div class="panel-body">
					  	<p><a href="{{ URL::action('ProfileController@user', $user->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"></a>
						<strong><a href="{{ URL::action('ProfileController@user', $user->user_id) }}"> {{  $user->name }} </a></strong> 
						@if ($userT->id == $user->id)
						    created
						@else
							joined
						@endif
						<strong><a href="{{ URL::action('CourseController@course', $course->id) }}"> {{	$course->name }} </a></strong> course.
						</p>
						<hr>
						<div class="content-status">
							<div class="course">
								<div class="panel panel-default course-panel">
								  <div class="panel-body">
								  	<div class="col-xs-12 col-lg-3">
										<a href="{{ URL::action('CourseController@course', $course->id) }}">
											<img src="{{ URL::asset('courses/'. $course->id . '/' . $course->pic) }}">
										</a>
									</div>
									<div class="col-xs-12 col-lg-9">
								  	  <h3><a href="{{ URL::action('CourseController@course', $course->id) }}"> {{$course->name }} </a></h3>
									   <p><a href="{{ URL::action('ProfileController@user', $userT->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $userT->id . '/' . $userT->pic) }}"></a>
								  	  <strong><a href=""> {{  $userT->name }} </a></strong></p>
									  <p> {{ excerpt($course->description) }}</p>
					
									</div>					  
								  </div>
								</div>
							</div>
						</div>
					</div>		
				</div>
			@else
				<?php $userT = User::find($post->id)?>
				<div class="panel panel-default settings-panel actions">
					<div class="panel-body">
					  	 <p><a href="{{ URL::action('ProfileController@user', $user->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"></a>
						 <strong><a href="{{ URL::action('ProfileController@user', $user->user_id) }}"> {{  $user->name }} </a></strong> 
						 followed  
						 <strong><a href="{{ URL::action('ProfileController@user', $userT->user_id) }}"> {{  $userT->name }} </a></strong> 

						 </p>
						 <!--<div class="content-status">
						 	<a  href="{{ URL::action('ProfileController@user', $user->id) }}"><img data-toggle="tooltip" data-placement="top" title="{{ $user->name }}" class="small-profile" src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"></a>
						 	<a href="{{ URL::action('ProfileController@user', $user->id) }}"><img data-toggle="tooltip" data-placement="top" title="{{ $user->name }}" class="small-profile" src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"></a>
						 	<a href="{{ URL::action('ProfileController@user', $user->id) }}"><img data-toggle="tooltip" data-placement="top" title="{{ $user->name }}" class="small-profile" src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"></a>
						</div>-->
					</div>		
				</div>
			@endif
		@endforeach

		{{ $timeline->links() }}
		</div>
		</div>
		<div class="col-xs-12 col-sm-4">
		</div>
	</div>
@endsection