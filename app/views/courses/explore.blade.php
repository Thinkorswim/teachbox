@extends('layouts.master-after')
@section('title')
	 Explore -
@stop

@section('description')
	Explore the courses in teachbox
@stop

@section('content')
<div class="course-section">
	<div class="container centered">
		<h1>Courses in all categories.</h1>
		<ul class="nav nav-pills" style="text-align:center">
				<h5>Categories:
				@foreach ($all as $categori)
					<li role="presentation">
					<a  href="{{ URL::action('CourseController@category', $categori->category) }}"> 
						{{$categori->category}}
					</a>
					</li>
				@endforeach
				</h5>
		</ul>
	</div>
</div>
<div class="container follow">
	<div class="col-xs-12 col-sm-12">
		<div class="scroll place">
			<div class="row">
			<?php $m = 0; ?>
			@foreach ($courses as $course)
			<?php $user = User::find($course->user_id); ?>
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
								@for ($i=1; $i <= 5 ; $i++)
									<a href=""><i class="fa fa-star{{ ($i <= $avgReviews[$m]) ? '' : '-o'}}"></i></a>
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
			<?php $m++; ?>
			@endforeach
		</div>
	</div>
	</div>
</div>
@endsection