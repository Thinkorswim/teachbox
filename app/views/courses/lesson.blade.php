@extends('layouts.master-after')

@section('content')

<div class="container">
	<div class="col-xs-3">

	</div>
	<div class="col-xs-6">
		<!--<video class="video-js" preload="auto" poster="{{ URL::asset('img/82.jpg') }}" data-setup="{}">
		  <source src="{{ URL::asset('courses/' . $course->id . '/' . $lesson->order . '/' . $lesson->filepath) }}" type="video/mp4">  	
		</video>-->
		<video class="video-js vjs-default-skin"
		  controls preload="auto" width="640" height="264"
		  poster="http://video-js.zencoder.com/oceans-clip.png" >
  			<source src="{{ URL::asset('courses/' . $course->id . '/' . $lesson->order . '/' . $lesson->filepath) }}" type="video/mp4">  	
		 <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
		</video>
	</div>
	<div class="col-xs-3">
		
	</div>
</div>

@endsection