@extends('layouts.master-after')

@section('content')

<div class="container">
	<div class="col-xs-3">

	</div>
	<div class="col-xs-6">
		<video class="video-js" preload="auto" poster="{{ URL::asset('img/82.jpg') }}" data-setup="{}">
		  <source src="{{ URL::asset('courses/' . $course->id . '/' . $lesson->order . '/' . $lesson->filepath) }}" type="video/mp4">  	
		</video>
	</div>
	<div class="col-xs-3">
		
	</div>
</div>

@endsection