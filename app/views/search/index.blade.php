@extends('layouts.master-after')

@section('content')
<div class="container">
	<div class="col-xs-12 col-sm-8">
		<h1>Search for <strong>search term</strong></h1>
		

			@foreach ($courses as $course)
					<div class="col-xs-12 col-sm-6 course">
						<div class="panel panel-default course-panel">
						  <div class="panel-body">
							  <a href="{{ URL::action('CourseController@course', [$course->id]) }}">
								<img src="{{ URL::asset('courses/'. $course->id . '/3x2' . $course->pic) }}">
							  </a>
						  	  <h2><a href="{{ URL::action('CourseController@course', [$course->id]) }}"> {{ $course->name; }} </a></h2>
						  </div>
						</div>
					</div>
			@endforeach

	</div>
	<div class="col-xs-12 col-sm-4">
		<div class="panel panel-default course-panel">
			<div class="panel-body">
				<img src="http://edition2013.mama-event.com/wmedias/festival/artistes/JeremyLoopsJemSolo.jpg">
				<h3><a href="#"> Heading</a></h3>
				<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit.
				 Aenean aliquam diam ut purus gravida aliquam. Curabitur et lobortis lorem, 
				quis aliquet arcu.</p>
			</div>
		</div>
		<div class="panel panel-default course-panel">
			<div class="panel-body">
				<img src="http://edition2013.mama-event.com/wmedias/festival/artistes/JeremyLoopsJemSolo.jpg">
				<h3><a href="#"> Heading</a></h3>
				<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean aliquam diam ut purus gravida aliquam.
				 Curabitur et lobortis lorem, quis aliquet arcu.</p>
			</div>
		</div>
	</div>
</div>
@endsection