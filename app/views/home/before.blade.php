@extends('layouts.master-before')

@section('title')

@stop

@section('description')
	Teachbox is an educational website that helps you find or create online courses. Learn and earn while socializing and having fun.
@stop

@section('content')

	<section class="full-screen main-screen">

	<img src="{{ URL::asset('img/teachbox-logo-front.png') }}" alt="teachbox" height="100px">
		<h2 class="centered">Find and create interactive courses.</h2>
		<div class="container">
			<div class="col-xs-12 col-sm-12 col-md-7 front-video">
				<div class="embed-responsive embed-responsive-16by9">
				<iframe id="thevideo" class="embed-responsive-item" src="https://www.youtube.com/embed/MK0Y2M2KFME?rel=0&showinfo=0&autohide=1" frameborder="0" allowfullscreen></iframe>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-1">
			</div>
				@if(Session::has('global-positive') || Session::has('global-negative') || $errors->has('email_s')
				|| $errors->has('password_s') || $errors->has('name') || $errors->has('email') ||$errors->has('password')
				|| $errors->has('password_again'))
			<div class="col-xs-12 col-sm-12 col-md-4 tab-register shake">
			@else
			<div class="col-xs-12 col-sm-12 col-md-4 tab-register">
            @endif
				<ul class="nav nav-tabs" role="tablist">
				  <li role="presentation" class="active"><a href="#login" role="tab" data-toggle="tab">Login</a></li>
				  <li role="presentation" class="register"><a href="#register" role="tab" data-toggle="tab">Register</a></li>
				</ul>
				<div class="tab-content">
				<!-- Login -->
				    <div role="tabpanel" class="tab-pane active" id="login">

						<a class="btn btn-lg btn-fb" href="{{ URL::route('fb-login') }}">
						<i class="fa fa-facebook"></i> Login with Facebook
						</a>
						<h6><span  class="line-center">or</span></h6>

						@if(Session::has('global-positive'))
						<div class="alert alert-success" role="alert">
						{{Session::get('global-positive')}}
						</div>
						@endif
						@if(Session::has('global-negative'))
						<div class="alert alert-danger" role="alert">
						{{Session::get('global-negative')}}
						</div>
						@endif
						<div>
						@if($errors->has('email_s'))
						<span id="mistake-mail" class="input input--hoshi" data-toggle="tooltip" title="{{$errors->first('email_s')}}">
						 @else
						<span class="input input--hoshi">
						 @endif
						{{ Form::open(['route' => 'sign-in']) }}
							 {{ Form::text('email_s', null , array('placeholder'=>'E-mail','id'=>'input-4', 'class'=>'input__field input__field--hoshi')) }}
							<label class="input__label input__label--hoshi" for="input-4">
								<span class="input__label-content input__label-content--hoshi">E-mail</span>
							</label>
						</span>
						</div>
						<div>
						@if($errors->has('password_s'))
						<span id="mistake-pass" class="input input--hoshi" data-toggle="tooltip" title="{{$errors->first('password_s')}}">
						  @else
						<span id="hooshi-start" class="input input--hoshi">
						 @endif
						 	{{ Form::password('password_s', array('placeholder'=>'Password','id'=>'input-5','class'=>'input__field input__field--hoshi')) }}
							<label class="input__label input__label--hoshi" for="input-5">
								<span class="input__label-content input__label-content--hoshi">Password</span>
							</label>
						</span>
						</div>
						<div class="row">
							<div class="col-xs-6">
								<div class="checkbox">
									<label>
										 {{ Form::checkbox('remember') }} Remember me
									 </label>
								</div>
							</div>
							<div class="col-xs-6">
								<a href="{{ URL::route('password-recovery') }}">Forgot Password</a>
							</div>
						</div>
						<div class="input-group submit">
						{{ Form::token() }}
							 {{ Form::submit('Login', array('class'=>'form-control')) }}
						</div>

						{{ Form::close() }}
					</div>


					<!-- Registration -->
					<div role="tabpanel" class="tab-pane register centered" id="register">
						{{ Form::open(['route' => 'create-account']) }}
						@if($errors->has('name'))
						<span id="user-error" class="input input--hoshi" data-toggle="tooltip" title="{{$errors->first('name')}}">
						@else
						<span class="input input--hoshi">
						@endif
							 {{ Form::text('name', null,  array('placeholder'=>'Full name', 'id'=>'input-6','class'=>'input__field input__field--hoshi')) }}
							<label class="input__label input__label--hoshi" for="input-6">
								<span class="input__label-content input__label-content--hoshi">Full name</span>
							</label>
						</span>

						@if($errors->has('email'))
						<span id="mail-error" class="input input--hoshi" data-toggle="tooltip" title="{{$errors->first('email')}}">
						@else
						<span id="mail" class="input input--hoshi" data-toggle="tooltip" title="It will be used for your authenticaion">
						@endif
							 {{ Form::text('email', null , array('placeholder'=>'E-mail','id'=>'input-7', 'class'=>'input__field input__field--hoshi')) }}
							<label class="input__label input__label--hoshi" for="input-7">
								<span class="input__label-content input__label-content--hoshi">E-mail</span>
							</label>
						</span>

						 @if($errors->has('password'))
						 <span id="pass-error" class="input input--hoshi" data-toggle="tooltip" title="{{$errors->first('password')}}">
						 @else
						<span id="password" class="input input--hoshi" data-toggle="tooltip" title="Your password needs to be 6-20 characters">
						@endif
							 {{ Form::password('password', array('placeholder'=>'Password','id'=>'input-8', 'class'=>'input__field input__field--hoshi')) }}
							<label class="input__label input__label--hoshi" for="input-8">
								<span class="input__label-content input__label-content--hoshi">Password</span>
							</label>
						</span>

						 @if($errors->has('password_again'))
						<span id="repeat-error" class="input input--hoshi" data-toggle="tooltip" title="{{$errors->first('password_again')}}">
						@else
						<span id="repeat" class="input input--hoshi">
						@endif
							 {{ Form::password('password_again', array('placeholder'=>'Repeat Password','id'=>'input-9', 'class'=>'input__field input__field--hoshi')) }}
							<label class="input__label input__label--hoshi" for="input-9">
								<span class="input__label-content input__label-content--hoshi">Repeat password</span>
							</label>
						</span>

						<div class="input-group submit sub-reg">
							 {{ Form::submit('Register', array('class'=>'form-control register-button')) }}
						</div>
						<small>By clicking register you agree with our <strong><a href=""> Terms and conditions</a></strong></small>
						{{ Form::token() }}
						{{ Form::close() }}
					</div>
			</div>
		</div>
	</div>
		</div>
	</div>
	</section>

	<section class="full-screen learn-screen">
		<div class="container centered">
			<h1>Why teachbox?</h1>
			<div class="col-sm-12">
		<div role="tabpanel">

			  <!-- Nav tabs -->
			  <ul class="nav nav-pills front-ul" role="tablist">
			    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Learn</a></li>
			    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Teach</a></li>
			  </ul>

  <!-- Tab panes -->
			  <div class="tab-content">

			    <div role="tabpanel" class="tab-pane fade in  active" id="home">
			    	<div class="row">
						<div class="col-sm-3">
							<img class="icon" src="{{ URL::asset('svg/search.svg') }}" title="search.svg">
							<p>Search whaterver you want to learn.</p>
						</div>

						<div class="col-sm-3">
							<img class="icon" src="{{ URL::asset('svg/film_reel.svg') }}" title="film_reel.svg">
							<p>Watch a lesson max 5 minutes long.</p>
						</div>

						<div class="col-sm-3">
							<img class="icon" src="{{ URL::asset('svg/advance.svg') }}" title="advance.svg">
							<p>Take the course of the lesson.</p>
						</div>

						<div class="col-sm-3">
							<img class="icon" src="{{ URL::asset('svg/survey.svg') }}" title="survey.svg">
							<p>Answer a quick test.</p>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-3">
							<img class="icon" src="{{ URL::asset('svg/reading_ebook.svg') }}" title="reading_ebook.svg">
							<p>Learn more.</p>
						</div>
						<div class="col-sm-3">
							<img class="icon" src="{{ URL::asset('svg/bar_chart.svg') }}" title="bar_chart.svg">
							<p>Compete with the others.</p>
						</div>
						<div class="col-sm-3">
							<img class="icon" src="{{ URL::asset('svg/collaboration.svg') }}" title="collaboration.svg">
							<p>Talk to your friends and make new ones.</p>
						</div>

						<div class="col-sm-3">
							<img class="icon" src="{{ URL::asset('svg/faq.svg') }}" title="faq.svg">
							<p>Ask and answer.</p>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-3">
						</div>
						<div class="col-sm-3">
							<img class="icon" src="{{ URL::asset('svg/like.svg') }}" title="like.svg">
							<p>Like it or not, write a simple review.</p>
						</div>

						<div class="col-sm-3">
							<img class="icon" src="{{ URL::asset('svg/high_priority.svg') }}" title="high_priority.svg">
							<p>Absolutely free.</p>
						</div>
					</div>
			   </div>

			    <div role="tabpanel" class="tab-pane fade" id="profile">
							<div class="col-sm-3">
								<img class="icon" src="{{ URL::asset('svg/search.svg') }}" title="search.svg">
								<p>Search whaterver you want to learn.</p>
								<img class="icon" src="{{ URL::asset('svg/reading_ebook.svg') }}" title="reading_ebook.svg">
								<p>Learn more.</p>
							</div>
							<div class="col-sm-3">
								<img class="icon" src="{{ URL::asset('svg/film_reel.svg') }}" title="film_reel.svg">
								<p>Watch a lesson max 5 minutes long.</p>
							</div>
							<div class="col-sm-3">
								<img class="icon" src="{{ URL::asset('svg/advance.svg') }}" title="advance.svg">
								<p>Take the course of the lesson.</p>
								<img class="icon" src="{{ URL::asset('svg/collaboration.svg') }}" title="collaboration.svg">
								<p>Talk to your friends and make new ones.</p>
							</div>

							<div class="col-sm-3">
								<img class="icon" src="{{ URL::asset('svg/survey.svg') }}" title="survey.svg">
								<p>Answer a quick test.</p>
								<img class="icon" src="{{ URL::asset('svg/high_priority.svg') }}" title="high_priority.svg">
								<p>Absolutely free.</p>
							</div>
			    </div>
			  </div>

			</div>

		</div>
	</section>

	<header class="relative-header">
		<section class="full-screen explore">
			<div class="col-xs-3">
			</div>
			<div class="col-xs-12 col-sm-6">
				<h1>Search from hundreds of courses!</h1>
				{{ Form::open(array('url' => '/search')) }}
				    <div class="input-group">
				      {{ Form::text('keyword', null, array('class' => 'form-control', 'placeholder' => 'Search for...', 'id' => 'keyword-two' ))}}
				      <span class="input-group-btn">
				        <button class="btn" type="submit button"><i class="fa fa-search"></i></button>
				      </span>
				    </div>
			    {{ Form::close() }}
			</div>
		</section>
	</header>

	<section class="biz">
		<div class="container">
			<h2>If you have a business you'll be intereseted in our solution for your employees training.</h2>
			<a href="#" class="btn btn-default">Let's talk business!</a>
		</div>
	</section>

	<section class="full-screen testimonials">
		<div class="container">
			<div class="col-xs-12 col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>Emilian Kadiiski</strong> - teacher at SVHSE "John Atanasoff"
					</div>
					<div class="panel-body">
						<p>"Teachbox is a great opportunity to spread the learning possibilities in our everyday life."</p>
					</div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6">
				<div class="panel panel-default place">
					<div class="panel-heading">
						<strong>Nikola Donchev</strong> - Co-founder of Stepsss
					</div>
					<div class="panel-body">
						<p>"A new better and more entertainment way to learn new things and exchange your knowledge with other like you. It's definitely worth giving it a try!"</p>
					</div>
				</div>
			</div>

		</div>
	</section>
@endsection
