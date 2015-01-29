@extends('layouts.master-after')

@section('content')
<div class="container">
	<div id="course-slider" class="carousel slide carousel-fade" data-ride="carousel">
	  <div class="carousel-inner" role="listbox">
	    <div class="item active">
			<div class="course">
				<div class="panel panel-default course-panel">
				  <div class="panel-body">
				  	<div class="col-xs-12 col-lg-3">
					  <a href="">
						<img src="http://edition2013.mama-event.com/wmedias/festival/artistes/JeremyLoopsJemSolo.jpg">
					  </a>
					</div>
					<div class="col-xs-12 col-lg-9">
						<img class="ribbon" src="{{ URL::asset('img/free.png')}}">
						<h3><a href="#"> Heading</a></h3>
					   <p><a href=""><img class="small-profile" src="http://edition2013.mama-event.com/wmedias/festival/artistes/JeremyLoopsJemSolo.jpg"></a>
				  	  <strong><a href=""> Ivan Lebanov</a></strong></p>
					  <p> rj frjf krwjf 'werijf íwrejf wjf wjfw jfwj fw </p>
	
					</div>					  
				  </div>
				</div>
			</div>
	    </div>
	    <div class="item">
			<div class="course">
				<div class="panel panel-default course-panel">
				  <div class="panel-body">
				  	<div class="col-xs-12 col-lg-3">
					  <a href="">
						<img src="http://edition2013.mama-event.com/wmedias/festival/artistes/JeremyLoopsJemSolo.jpg">
					  </a>
					</div>
					<div class="col-xs-12 col-lg-9">
						<img class="ribbon" src="{{ URL::asset('img/free.png')}}">
						<h3><a href="#"> Heading</a></h3>
					   <p><a href=""><img class="small-profile" src="http://edition2013.mama-event.com/wmedias/festival/artistes/JeremyLoopsJemSolo.jpg"></a>
				  	  <strong><a href=""> Ivan Lebanov</a></strong></p>
					  <p> rj frjf krwjf 'werijf íwrejf wjf wjfw jfwj fw </p>
	
					</div>					  
				  </div>
				</div>
			</div>
	    </div>

	  </div>

	  <!-- Controls -->
	  <a class="left carousel-control" href="#course-slider" role="button" data-slide="prev">
	    <span class="fa fa-chevron-left" aria-hidden="true"></span>
	    <span class="sr-only">Previous</span>
	  </a>
	  <a class="right carousel-control" href="#course-slider" role="button" data-slide="next">
	    <span class="fa fa-chevron-right" aria-hidden="true"></span>
	    <span class="sr-only">Next</span>
	  </a>
	</div>
</div>
@endsection
