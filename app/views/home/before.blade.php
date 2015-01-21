@extends('layouts.master-before')

@section('content')

<!-- After registration -->
	<section class="full-screen main-screen">
		<div class="container">
			<div class="col-xs-1 col-sm-3 col-md-4">
				<!--<h1>Education is the key!</h1>-->
			</div>
				@if(Session::has('global-positive') || Session::has('global-negative') || $errors->has('email_s')
				|| $errors->has('password_s') || $errors->has('name') || $errors->has('email') ||$errors->has('password')
				|| $errors->has('password_again'))
			<div class="col-xs-10 col-sm-6 col-md-4 tab-register shake">	
			@else
			<div class="col-xs-10 col-sm-6 col-md-4 tab-register">	
            @endif
				<ul class="nav nav-tabs" role="tablist">
				  <li role="presentation" class="active"><a href="#login" role="tab" data-toggle="tab">Login</a></li>
				  <li role="presentation" class="register"><a href="#register" role="tab" data-toggle="tab">Register</a></li>
				</ul>
				<div class="tab-content">	
				<!-- Login -->
				    <div role="tabpanel" class="tab-pane in active" id="login">	
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
						@if($errors->has('email_s'))					
						<div id="mistake-mail" class="input-group" data-toggle="tooltip" title="{{$errors->first('email_s')}}">
						 @else
						<div class="input-group">
						 @endif	
						 <span class="input-group-addon"><i class="pe-7s-mail"></i></span> 					
						{{ Form::open(['route' => 'sign-in']) }}
							 {{ Form::text('email_s', null , array('placeholder'=>'E-mail','class'=>'form-control')) }}
						</div>
						@if($errors->has('password_s'))
						<div id="mistake-pass" class="input-group" data-toggle="tooltip" title="{{$errors->first('password_s')}}">
						  @else
						<div class="input-group">
						 @endif	
						  <span class="input-group-addon"><i class="pe-7s-lock"></i></span>
						 	{{ Form::password('password_s', array('placeholder'=>'Password','class'=>'form-control')) }}
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
							 {{ Form::submit('Login', array('class'=>'form-control')) }}
						</div>
						{{ Form::token() }}
						{{ Form::close() }}
					</div>


					<!-- Registration -->
					<div role="tabpanel" class="tab-pane register" id="register">
						{{ Form::open(['route' => 'create-account']) }}	 
						@if($errors->has('name'))
						<div id="user-error" class="input-group" data-toggle="tooltip" title="{{$errors->first('name')}}">
						@else
						<div class="input-group">
						@endif
						  <span class="input-group-addon"><i class="pe-7s-user"></i></span>
							 {{ Form::text('name', null,  array('placeholder'=>'Full name', 'class'=>'form-control')) }}
						</div>

						@if($errors->has('email'))
						<div id="mail-error" class="input-group" data-toggle="tooltip" title="{{$errors->first('email')}}">
						@else
						<div id="mail" class="input-group" data-toggle="tooltip" title="It will be used for your authenticaion">
						@endif
						  <span class="input-group-addon"><i class="pe-7s-mail"></i></span>
							 {{ Form::text('email', null , array('placeholder'=>'E-mail', 'class'=>'form-control')) }}
						</div>

						 @if($errors->has('password'))
						 <div id="pass-error" class="input-group" data-toggle="tooltip" title="{{$errors->first('password')}}">
						 @else
						<div id="password" class="input-group" data-toggle="tooltip" title="Your password needs to be 6-20 characters">
						@endif 	
						  <span class="input-group-addon"><i class="pe-7s-lock"></i></span>
							 {{ Form::password('password', array('placeholder'=>'Password', 'class'=>'form-control')) }}								 
						</div>

						 @if($errors->has('password_again'))
						<div id="repeat-error" class="input-group" data-toggle="tooltip" title="{{$errors->first('password_again')}}">
						@else
						<div id="repeat" class="input-group">
						@endif
						  <span class="input-group-addon"><i class="pe-7s-lock"></i></span>
							 {{ Form::password('password_again', array('placeholder'=>'Repeat Password', 'class'=>'form-control')) }}		 
						</div>

						<div class="input-group submit">
							 {{ Form::submit('Register', array('class'=>'form-control register-button')) }}
						</div>
						{{ Form::token() }}
						{{ Form::close() }}
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
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
			</div>
			<div class="col-sm-3">
				<i class="fa-4x pe-7s-notebook"></i>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
			</div>
			<div class="col-sm-3">
				<i class="fa-4x pe-7s-cash"></i>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>				
			</div>
			<div class="col-sm-3">
				<i class="fa-4x pe-7s-chat"></i>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>				
			</div>
		</div>
	</section>
	<section class="full-screen testimonials">
		<div class="container">
			<h2>People talk about us</h2>
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			  <!-- Indicators -->
			  <ol class="carousel-indicators">
			    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
			  </ol>

			  <!-- Wrapper for slides -->
			  <div class="carousel-inner" role="listbox">
			    <div class="item active">
			        <h3><i class="fa fa-2x fa-quote-left"></i>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </h3>
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
	</section>
	<header class="relative-header">
		<section class="full-screen explore">
			<div class="col-xs-3">
			</div>
			<div class="col-xs-6">
				<h1>Search from hundreds of courses!</h1>
				{{ Form::open(array('url' => '/search')) }}
				    <div class="input-group">
				      {{ Form::text('keyword', null, array('class' => 'form-control', 'placeholder' => 'Search for...', 'id' => 'keyword' ))}}
				      <span class="input-group-btn">
				        <button class="btn" type="submit button"><i class="fa fa-search"></i></button>
				      </span>
				    </div>
			    {{ Form::close() }}
			</div>
		</section>
	</header>
	<footer class="front-page-footer">
		<div class="container">
				<h3>The teachbox</h3>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
				<a href="">Privacy</a>
				<a href="">Terms</a>
				<a href="">Cookies</a>
				<a href="">Advertising</a>
				<ul>
				  <li>
					<a href="https://www.facebook.com/">
						<span class="fa-stack fa-lg">
						  <i class="fa fa-circle fa-stack-2x"></i>
						  <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
						</span>
					</a>
				  </li>
				  <li>
					<a href="https://twitter.com/">
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
				  <li>
					<a href="#">
						<span class="fa-stack fa-lg">
						  <i class="fa fa-circle fa-stack-2x"></i>
						  <i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
						</span>
					</a>
				  </li>
				</ul>	
				<small>All rights reserved Teachbox 2014</small>
		</div>
	</footer>
@endsection
