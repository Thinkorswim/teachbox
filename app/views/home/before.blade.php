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
						<span class="input input--hoshi">
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

					@if($max_users < 1000)
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

					@else
					<!-- Subscribe -->
					<div role="tabpanel" class="tab-pane register centered" id="register">
						
						<h1>Subscribe</h1>
						<p>Subscribe now to recieve information about our launch.</p>
						  	{{ Form::open(['route' => 'post-subscribe']) }}
							@if($errors->has('email'))
							<div id="mail-error" class="input-group" data-toggle="tooltip" title="{{$errors->first('email')}}">
							@else
							<div id="mail" class="input-group" data-toggle="tooltip" title="It will be used for your authenticaion">
							@endif
							<span class="input-group-addon"><i class="pe-7s-mail"></i></span>
						 	{{ Form::text('email', null , array('placeholder'=>'E-mail', 'class'=>'form-control')) }}
						  	</div>
							<div class="input-group submit">
								 {{ Form::submit('Subscribe', array('class'=>'form-control')) }}
							</div>

						  {{ Form::close() }}
					</div>
				</div>
					@endif
		</div>
	</div>
		      <!-- <a href="" class="more"><i class="fa-4x pe-7s-angle-down-circle"></i></a> -->

	</section>
	<section class="full-screen learn-screen">
		<div class="container">
			<div class="col-sm-3">
				
				<img src="{{ URL::asset('img/Browserpen.png') }}" alt="broswer pen">
				<h2 class="centered">Teach</h2>
				<p> Everyone has some knowledge to share. Spit it out. Teach the world. </p>
			</div>
			<div class="col-sm-3">
				
				<img src="{{ URL::asset('img/Education.png') }}" alt="edcation hat">
				<h2 class="centered">Learn</h2>
				<p> Nobody is perfect. Get something out of that knowledge box. </p>
			</div>
			<div class="col-sm-3">
				
				<img src="{{ URL::asset('img/Dollarbag.png') }}" alt="dollar bag">
				<h2 class="centered">Earn</h2>
				<p> Earn by creating something and doing something great. </p>
			</div>
			<div class="col-sm-3">
				
				<img src="{{ URL::asset('img/Hearts.png') }}" alt="hearts">
				<h2 class="centered">Socialise</h2>
				<p> Share your experience with your friends. Know what they are up to.</p>
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
	<section class="full-screen responsive">
		<div class="container">
		<h2 class="centered">Learn on the go or in the comfort of your home!</h2>
		<img src="{{ URL::asset('img/devices.png') }}">
		</div>
	</section>
	<!--
	<section class="full-screen testimonials">
		<div class="container">
			<h1>People talk about us</h1>
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			  
			  <div class="carousel-inner" role="listbox">
			    <div class="item active">
			        <h3><i class="fa fa-2x fa-quote-left"></i>
						"A new better and more entertainment way to learn new things and exchange your knowledge with other like you. It's definitely worth giving it a try!"
						 <small>Koko Donchev, Stepsss</small>
			        </h3>
			       
			    </div>
			    <div class="item">
			        <h3><i class="fa fa-2x fa-quote-left"></i>The teachbox is on the right path. </h3>
			    </div
			</div>
		</div>
	</div>
	</section>-->
@endsection
