@extends('layouts.master-before')

@section('title')

@stop

@section('description')
	Teach. Learn. Earn. Socialise.
@stop

@section('content')

<!-- After registration -->
	<section class="full-screen main-screen">
		<div class="container">
			<div class="col-xs-12 col-sm-12 col-md-7 front-video">
				<div class="panel panel-default">
				<div class="panel-body padding-body">
				<div class="embed-responsive embed-responsive-16by9">
				<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/MK0Y2M2KFME?rel=0&showinfo=0&autohide=1" frameborder="0" allowfullscreen></iframe>
				</div>
				</div>
				</div>
			</div> 
			
		</div>
		       <a href="" class="more"><i class="fa-4x pe-7s-angle-down-circle"></i></a>

	</section>
	<section class="full-screen learn-screen">
		<div class="container">
			<h1 class="centered">Teach. Learn. Earn. Socialise.</h2>
			<div class="col-sm-3">
				<i class="fa-4x pe-7s-glasses"></i>
				<p> Everyone has some knowledge to share. Spit it out. Teach the world. </p>
			</div>
			<div class="col-sm-3">
				<i class="fa-4x pe-7s-notebook"></i>
				<p> Nobody is perfect. Get something out of that knowledge box. </p>
			</div>
			<div class="col-sm-3">
				<i class="fa-4x pe-7s-cash"></i>
				<p> Earn while having fun and doing something great. </p>				
			</div>
			<div class="col-sm-3">
				<i class="fa-4x pe-7s-chat"></i>
				<p> Share your experience with your friends. Know what they are up to.</p>				
			</div>
		</div>
	</section>
	<!--<section class="full-screen testimonials">
		<div class="container">
			<h1>People talk about us</h1>
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			  
			  <ol class="carousel-indicators">
			    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
			  </ol>

			  <div class="carousel-inner" role="listbox">
			    <div class="item active">
			        <h3><i class="fa fa-2x fa-quote-left"></i>Simply the best.</h3>
			    </div>
			    <div class="item">
			        <h3><i class="fa fa-2x fa-quote-left"></i>The teachbox is on the right path. </h3>
			    </div>
			    <div class="item">	
			        <h3><i class="fa fa-2x fa-quote-left"></i>The teachbox is great. </h3>
			    </div>
			</div>
		</div>
	</div>
	</section>-->
	
@endsection
