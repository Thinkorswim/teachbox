@extends('layouts.master-before')

@section('content')

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
            <div class="tab-pane">
               <h4>Recover your password</h4>
               <form action="{{ URL::route('password-send') }}" method="post">
               		<div class="input-group">
                    @if($errors->has('email'))
                    <span id="mistake-mail" class="input-group-addon" data-toggle="tooltip" title="{{$errors->first('email')}}">
                     <i class="pe-7s-mail"></i>
                    </span>   
                    @else
                    <span class="input-group-addon"><i class="pe-7s-mail"></i></span>
                    @endif
                        <input id="mail" type="text" class="form-control" placeholder="E-mail" {{Input::old('email') ? ' value="'. e(Input::old('email')) .'"' : ''}} >
               		</div>
                     <div class="input-group submit">
                  		<input type="submit" value="Recover" class="form-control">
                  		{{ Form::token() }}
                     </div>
               </form> 
            </div>
         </div>
      </div>
   </section>

@endsection
