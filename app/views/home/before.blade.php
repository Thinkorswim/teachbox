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
				  <li role="presentation"><a href="#register" role="tab" data-toggle="tab">Register</a></li>
				</ul>
				<div class="tab-content">	
				<!-- Login -->
				    <div role="tabpanel" class="tab-pane in active" id="login">	
						<a class="btn btn-lg btn-fb" href="">
						<i class="fa fa-facebook"></i> Login with Facebook
						</a>
						<h6><span  class="line-center">or</span></h6>					
						<div class="input-group">
						  @if($errors->has('email_s'))
						  <span id="mistake-mail" class="input-group-addon" data-toggle="tooltip" title="{{$errors->first('email_s')}}">
						  	<i class="pe-7s-mail"></i>
						  </span>	
						  @else
						  <span class="input-group-addon"><i class="pe-7s-mail"></i></span>
						  @endif					
						{{ Form::open(['route' => 'sign-in']) }}
							 {{ Form::text('email_s', null , array('placeholder'=>'E-mail','class'=>'form-control')) }}
						</div>
						<div class="input-group">
						  @if($errors->has('password_s'))
						  <span id="mistake-pass" class="input-group-addon" data-toggle="tooltip" title="{{$errors->first('password_s')}}">
						  	<i class="pe-7s-lock"></i>
						  </span>	
						  @else
						  <span class="input-group-addon"><i class="pe-7s-lock"></i></span>
						  @endif	
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
					<div role="tabpanel" class="tab-pane" id="register">
						{{ Form::open(['route' => 'create-account']) }}	 
						<div class="input-group">
						  <span class="input-group-addon"><i class="pe-7s-user"></i></span>
							 {{ Form::text('name', null,  array('placeholder'=>'Username', 'class'=>'form-control')) }}
							 @if($errors->has('name'))
								{{$errors->first('name')}}
							 @endif
						</div>
						<div id="mail" class="input-group">
						  <span class="input-group-addon"><i class="pe-7s-mail"></i></span>
							 {{ Form::text('email', null , array('placeholder'=>'E-mail', 'class'=>'form-control')) }}
							 @if($errors->has('email'))
								{{$errors->first('email')}}
							 @endif
						</div>
						<div id="password" class="input-group">
						  <span class="input-group-addon"><i class="pe-7s-lock"></i></span>
							 {{ Form::password('password', array('placeholder'=>'Password', 'class'=>'form-control')) }}
							 @if($errors->has('password'))
								{{$errors->first('password')}}
							 @endif 
						</div>
						<div id="repeat" class="input-group">
						  <span class="input-group-addon"><i class="pe-7s-lock"></i></span>
							 {{ Form::password('password_again', array('placeholder'=>'Repeat Password', 'class'=>'form-control')) }}
							 @if($errors->has('password_again'))
								{{$errors->first('password_again')}}
							 @endif
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
