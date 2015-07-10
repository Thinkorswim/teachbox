@extends('layouts.master-before')

@section('title')

@stop

@section('description')
	Teachbox is an educational website that helps you find or create online courses. Learn and earn while socializing and having fun.
@stop

@section('content')


	<section class="full-screen main-screen">
		<div class="container">
			<div class="col-xs-12 col-sm-12 col-md-8">

				<h2>Find and create interactive courses.</h2>
				<p>Teachbox is an online educational platform where you can conquer new frontiers by learning from high quality courses on various topics and sharing your immense knowledge with everyone in the world.</p>
				<a class="btn btn-empty" href="https://www.youtube.com/embed/MK0Y2M2KFME" data-toggle="lightbox"><svg  version="1.1" id="play"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					 width="32px" height="32px" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
				<g>
					<polygon class="path" fill="none" stroke="#2c3e50" stroke-width="2" stroke-linejoin="bevel" stroke-miterlimit="10" points="27,21 41,32 
						27,43 	"/>
					<path class="path" fill="none" stroke="#2c3e50" stroke-width="2" stroke-miterlimit="10" d="M53.92,10.081
						c12.107,12.105,12.107,31.732,0,43.838c-12.106,12.108-31.734,12.108-43.839,0c-12.107-12.105-12.107-31.732,0-43.838
						C22.186-2.027,41.813-2.027,53.92,10.081z"/>
				</g>
				</svg>
				<div>Watch a video</div>
				</a>

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
		<div class="container">
			<h1 class="centered">Introducing teachbox.</h1>
			<div class="col-sm-4">
				<h3>Fast lessons.</h3>
				<p>We prioritize your time. In teachbox all lessons are no longer than 5 mniutes.</p>
				<h3>Test yourself.</h3>
				<p>There is a short test after every lesson.</p>
				<h3>It's all free.</h3>
				<p>You can join and create interactive courses without paying any fees.</p>
				<h3>Connect.</h3>
				<p>Stay in touch with your friends and get to know people with similar interests as yours.</p>
			</div>

			<div class="col-sm-4">
			
			<img class="img-responsive" src="{{ URL::asset('img/women.jpg') }}" alt="women">
			</div>

			<div class="col-sm-4">
				<h3>Share knowledge.</h3>
				<p>Create a course, spread your knowledge and change a life. Every video counts. </p>
				<h3>Earn money.</h3>
				<p>Get a big user base and we will offer you a partnership programme. Build a community that will be with you through every step of the journey.</p>
				<h3>Marketing.</h3>
				<p>Show off your brand by educating thousands of users. Teach people how to use your product and make them want it.</p>
			</div>

		</div>
	</section>
	<section class="biz">
		<div class="container">
			<h2>Business owners and leaders, train your employees online!</h2>
			<a href="{{ URL::action('BusinessController@businessinfo')}}" class="btn btn-default">Let's talk business!</a>
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
						<p>"A new better and more entertaining way to learn new things and exchange your knowledge with other like you. It's definitely worth giving it a try!"</p>
					</div>
				</div>
			</div>

		</div>
	</section>
@endsection
