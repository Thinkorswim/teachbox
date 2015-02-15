@extends('layouts.master-after')
@section('title')
	Contacts -
@stop
@section('description')
	Contact the creators of teachbox.about(heading + paragraph), team(name, responsibilities, social media, email), contacts(support email, form)

@stop
@section('content')

		<div class="container">
				<div class="course place">
					<div class="panel panel-default course-panel">
					  <div class="panel-body">
					  	<div class="col-xs-12 col-lg-3">
							<img src="{{ URL::asset('img/teachbox-logo.jpg') }}">
						</div>
						<div class="col-xs-12 col-lg-9">
					  	  <h1><strong>About us</strong></h1>
						  <p>Teachbox is a education platform which is currently in beta.</p>
						</div>
					  </div>
					</div>
				</div>
				</div>
	<section id="team" class="full-screen us text-center">
		<div class="container">
			<div class="col-xs-12 col-sm-4 course">
				<div class="panel panel-default course-panel">
					<div class="panel-body">
						<img src="{{ URL::asset('img/martin.jpg') }}">
						<h3>Martin Georgiev</h3>
						<p>Co-founder, Lead programmer</p>
						<ul class="social">
						  <li>
							<a href="https://www.facebook.com/ivan.lebanov">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						  </li>
						  <li>
							<a href="https://twitter.com/ivansayshi">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						  </li>
						  <li>
							<a href="#">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						  </li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4 course">
				<div class="panel panel-default course-panel">
					<div class="panel-body">
						<img src="{{ URL::asset('img/ivan.jpg') }}">
						<h3>Ivan Lebanov</h3>
						<p>Co-founder, UX designer</p>
						<ul class="social">
						  <li>
							<a href="https://www.facebook.com/ivan.lebanov">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						  </li>
						  <li>
							<a href="https://twitter.com/ivansayshi">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						  </li>
						  <li>
							<a href="#">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						  </li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4 course">
				<div class="panel panel-default course-panel">
					<div class="panel-body">
						<img src="{{ URL::asset('img/latchezar.jpg') }}">
						<h3>Latchezar Mladenov</h3>
						<p>Co-founder, Programmer</p>
						<ul class="social">
						  <li>
							<a href="https://www.facebook.com/profile.php?id=100004670134982">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						  </li>
						  <li>
							<a href="https://twitter.com/llluchko">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						  </li>
						  <li>
							<a href="https://www.linkedin.com/profile/view?id=232796153">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						  </li>
						</ul>
					</div>
				</div>
			</div>
	</section>
@endsection