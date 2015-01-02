@extends('layouts.master-after')

@section('content')
	<a href="{{ URL::action('CourseController@create')}}"> Create Course </a>
<div class="container">
	<div class="col-xs-3">
		<video class="video-js" preload="auto" poster="{{ URL::asset('img/82.jpg') }}" data-setup="{}">
		  <source src="http://iurevych.github.com/Flat-UI-videos/big_buck_bunny.mp4" type="video/mp4">
		  	
		</video>
	</div>
</div>
@endsection
