@extends('layouts.master-after')

@section('title')
	{{$currentLesson->name}} -
@stop

@section('description')
	{{ excerpt($currentLesson->description) }}
@stop

@section('fb-image')
	{{ URL::asset('courses/' . $course->id . '/' . $currentLesson->order . '/thumb.png') }}
@stop

@section('content')
<div class="modal fade" id="testModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Test</h4>
      </div>
      <div class="modal-body">
		<ul class="nav nav-tabs hidden">
			<li class="active"><a href="#first" data-toggle="tab">Shipping</a></li>
			<li><a href="#second" data-toggle="tab">Quantities</a></li>
			<li><a href="#third" data-toggle="tab">Summary</a></li>
			<li><a href="#forth" data-toggle="tab">Summary</a></li>
			<li><a href="#fifth" data-toggle="tab">Summary</a></li>
		</ul>
		<div class="tab-content">
		    <div role="tabpanel" class="tab-pane  active" id="first">
		        <h4>First Question</h4>
					<section>
						<form class="ac-custom ac-radio ac-circle" autocomplete="off">
							<ul>
								<li><input id="r1" name="r2" type="radio"><label for="r1">Objectively integrate emerging core competencies</label></li>
								<li><input id="r2" name="r2" type="radio"><label for="r2">Progressively maintain extensive infomediaries</label></li>
								<li><input id="r3" name="r2" type="radio"><label for="r3">Proactively fabricate one-to-one materials</label></li>
								<li><input id="r4" name="r2" type="radio"><label for="r4">Quickly aggregate B2B users</label></li>
							</ul>
						</form>
					</section>
					<div class="row">
					 	<a class="btn btn-primary btnNext pull-right" >Next</a>
					 </div>
      		</div>
		    <div role="tabpanel" class="tab-pane" id="second">
		        <h4>Second Question</h4>
					<section>
						<form class="ac-custom ac-radio ac-circle" autocomplete="off">
							<ul>
								<li><input id="r5" name="r2" type="radio"><label for="r5">Objectively integrate emerging core competencies</label></li>
								<li><input id="r6" name="r2" type="radio"><label for="r6">Progressively maintain extensive infomediaries</label></li>
								<li><input id="r7" name="r2" type="radio"><label for="r7">Proactively fabricate one-to-one materials</label></li>
								<li><input id="r8" name="r2" type="radio"><label for="r8">Quickly aggregate B2B users</label></li>
							</ul>
						</form>
					</section>
					<a class="btn btn-primary btnPrevious" >Previous</a>
					<a class="btn btn-primary btnNext pull-right" >Next</a>
      		</div>
		    <div role="tabpanel" class="tab-pane" id="third">
		        <h4>Third Question</h4>
					<section>
						<form class="ac-custom ac-radio ac-circle" autocomplete="off">
							<ul>
								<li><input id="r9" name="r2" type="radio"><label for="r9">Objectively integrate emerging core competencies</label></li>
								<li><input id="r10" name="r2" type="radio"><label for="r10">Progressively maintain extensive infomediaries</label></li>
								<li><input id="r11" name="r2" type="radio"><label for="r11">Proactively fabricate one-to-one materials</label></li>
								<li><input id="r12" name="r2" type="radio"><label for="r12">Quickly aggregate B2B users</label></li>
							</ul>
						</form>
					</section>
					<div class="row">
					<a class="btn btn-primary btnNext pull-right submit-test" >Submit</a>
					</div>
      		</div>
      		</div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<section class="video-section">
	<div class="container">
		<nav class="nav-reveal">
			@if ($currentLesson->order != 1)
			<a class="prev" href="{{ URL::action('CourseController@courseLesson', [$course->id,($previousLesson->order)]) }}">
				<span class="icon-wrap">
					<i class="fa fa-2x fa-chevron-left"></i>
				</span>
				<div>
					<h3> {{ $previousLesson->name }} <span>by {{ $creator->name; }}</span></h3>
					<img src="{{ URL::asset('courses/' . $course->id . '/' . $previousLesson->order . '/thumb100x100.png') }}" alt="Previous thumb">
				</div>
			</a>
			@endif
			@if ($currentLesson->order != $lessonList->count())
			<a class="next" href="{{ URL::action('CourseController@courseLesson', [$course->id,($nextLesson->order)]) }}">
				<span class="icon-wrap">
					<i class="fa fa-2x fa-chevron-right"></i>
				</span>
				<div>
					<h3> {{ $nextLesson->name }}<span>by {{ $creator->name; }}</span></h3>
					<img src="{{ URL::asset('courses/' . $course->id . '/' . $nextLesson->order . '/thumb100x100.png') }}" alt="Next thumb">
				</div>
			</a>
			@endif
		</nav>
		<div class="col-xs-1"></div>
		<div class="col-xs-10">
			<video id="video_main" class="video-js vjs-default-skin vjs-big-play-centered" controls
			 preload="auto" width="100%" height="500"   poster="{{ URL::asset('courses/' . $course->id . '/' . $currentLesson->order . '/thumb.png') }}"
			 data-setup="{}">
				<source src="{{ URL::asset('courses/' . $course->id . '/' . $currentLesson->order . '/' . $currentLesson->filepath) }}" type="video/mp4" />
				<source src="{{ URL::asset('courses/' . $course->id . '/' . $currentLesson->order . '/video.webm') }}" type="video/webm" />
			    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
			</video>
			<div id="on-end">
				<button id="repeat" type="button" onclick="playVid()"><i class="fa fa-repeat fa-4x" ></i></button>
				or
				<button class="btn btn-default btn-primary btn-lg" type="button" data-target="#testModal" data-toggle="modal" data-backdrop="static">Take the test</button>
			</div>
		</div>
		<div class="col-xs-1"></div>
	</div>
</section>
<div class="container">
	<div class="col-xs-12 col-sm-8">
		<div class="panel panel-default place">
		  <div class="panel-body">
			<h1>{{ $currentLesson->name }}</h1>
	        <p>{{ $currentLesson->description }}</p>
	        @if (Auth::user()->id == $course->user_id)
				<a class="edit-lesson" href ="{{ URL::action('CourseController@lessonEdit', [$course->id,$currentLesson->order]) }}" >
						<i class="fa fa-edit"></i>
				</a>
			@endif
		 </div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-4">
		<div class="panel panel-default actions playlist-panel place">
		  <div class="panel-heading">
		  	<h3 class="panel-title">
		  		<a href="{{ URL::action('CourseController@course', [$course->id]) }}"> {{ $course->name; }} </a>
		  	</h3>
		  	<small> by <strong><a href="{{ URL::action('ProfileController@user', $creator->id) }}"> {{ $creator->name; }} </a></strong></small>
		  </div>
		  <div class="panel-body">
			  <div class="list-group" id="list-lessons">
			  <?php $i = 1; ?>
				@foreach ($lessonList as $lesson)
				@if(Auth::user()->admin || $lesson->approved)
					@if ($lesson->order == $currentLesson->order)
			 		 	<a class="list-group-item active" id="active"  href="{{ URL::action('CourseController@courseLesson', [$course->id,$lesson->order]) }}">
							<div class="col-xs-9">
				 				<strong><?php echo $i; $i++; ?>. </strong> {{' '. $lesson->name; }}
				 			</div>
				 			<div class="col-xs-3">
				 			 	<div class="pull-right">{{ $lesson->duration; }}</div> 
				 			</div>
			 		 	 </a>
			 		@else
				 		<a class="list-group-item" href="{{ URL::action('CourseController@courseLesson', [$course->id,$lesson->order]) }}">
							<div class="col-xs-9">
				 				<strong><?php echo $i; $i++; ?>. </strong> {{' '. $lesson->name; }}
				 			</div>
				 			<div class="col-xs-3">
				 			 	 <div class="pull-right">{{ $lesson->duration; }}</div> 
				 			</div>
				 		</a>
			 		@endif
			 	@endif
			    @endforeach
			   </div>
		  </div>
		</div>
	</div>
</div>


@endsection