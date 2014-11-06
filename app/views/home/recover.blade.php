@extends('layouts.master-before')

@section('content')

	@if(Session::has('global'))
		<div>
				{{Session::get('global')}}
		</div>
	@endif

   <form action="{{ URL::route('password-send') }}" method="post">
   		<div class="field">
   		Email: <input type="text" name="email" {{Input::old('email') ? ' value="'. e(Input::old('email')) .'"' : ''}} >
   		@if($errors->has('email'))
   			{{ $errors->first('email') }}
   		@endif
   		</div>
   		<input type="submit" value="Recover" >
   		{{ Form::token() }}
   </form> 

@endsection
