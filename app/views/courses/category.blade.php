@extends('layouts.master-after')
@section('title')
	 {{$category}} courses -
@stop

@section('description')
	 {{$category}} courses in teachbox
@stop

@section('content')
<div class="course-section">
	<div class="container centered">
		<h1>{{$category}} courses.</h1>
<ul class="nav nav-pills" style="text-align:center">
		<h5>Check also:
		@foreach ($all as $categori)
			@if( $categori->category != $category)

			<li role="presentation">
			<a  href="{{ URL::action('CourseController@category', $categori->category) }}">
				{{$categori->category}}
			</a>
			</li>
			@endif
		@endforeach
		</h5>
</ul>
	</div>
</div>

<div class="container follow">
	<div class="col-xs-12 col-sm-12">
		<div class="scroll place">
			<div class="row">
			<?php $l = 0;?>
			@foreach ($courses as $course)
			<?php $user = User::find($course->user_id);?>
					<div class="col-xs-12 col-sm-4 course three-in-line">
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
									<a href=""><i class="fa fa-star{{ ($m <= $avgReviews[$l]) ? '' : '-o'}}"></i></a>
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
			<?php $l++;?>
			@endforeach
		</div>
	</div>
	</div>
</div>
@endsection