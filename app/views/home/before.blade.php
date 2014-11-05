@extends('layouts.master-before')

@section('content')

<!-- After registration -->
	@if(Session::has('global'))
		<div>
				{{Session::get('global')}}
		</div>
	@endif
	

<!-- Sign in -->
	{{ Form::open(['route' => 'sign-in']) }}
		 {{ Form::text('email_s', null , array('placeholder'=>'E-mail')) }}
		  @if($errors->has('email_s'))
		 	{{$errors->first('email_s')}}
		  @endif
		 </br>
		 {{ Form::password('password_s', array('placeholder'=>'Password')) }}
		  @if($errors->has('password_s'))
		 	{{$errors->first('password_s')}}
		  @endif
		 </br>
		 {{ Form::label('remember', 'Remember me') }}
		 {{ Form::checkbox('remember') }}
		  </br>
		 {{ Form::submit('Sign in') }}
	{{ Form::close() }}


<!-- Sign up -->
	{{ Form::open(['route' => 'create-account']) }}	 
		 {{ Form::text('email', null , array('placeholder'=>'E-mail')) }}
		 @if($errors->has('email'))
		 	{{$errors->first('email')}}
		 @endif
		 </br>
		 {{ Form::text('name', null,  array('placeholder'=>'Username')) }}
		 @if($errors->has('name'))
		 	{{$errors->first('name')}}
		 @endif
		  </br>
		 {{ Form::password('password', array('placeholder'=>'Password')) }}
		 @if($errors->has('password'))
		 	{{$errors->first('password')}}
		 @endif 
		  </br>
		 {{ Form::password('password_again', array('placeholder'=>'Repeat Password')) }}
		 @if($errors->has('password_again'))
		 	{{$errors->first('password_again')}}
		 @endif
		  </br>
		 {{ Form::submit('Register') }}
	{{ Form::close() }}
@endsection
