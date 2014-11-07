@extends('layouts.master-before')

@section('content')

<!-- After registration -->
	@if(Session::has('global'))
		<div>
				{{Session::get('global')}}
		</div>
	@endif
	<section class="full-screen">
		<div class="container">
			<div class="col-xs-1 col-sm-3 col-md-4">
				<!--<h1>Education is the key!</h1>-->
			</div>
			<div class="col-xs-10 col-sm-6 col-md-4 tab-register">	
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
						{{ Form::close() }}
					</div>
			</div>
		</div>
	</div>
	</section>
@endsection
