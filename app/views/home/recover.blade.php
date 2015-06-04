@extends('layouts.master-before')

@section('title')
  Recover password -
@stop

@section('description')
  Recover your password in teachbox in case you've forgotten it.
@stop

@section('content')
   <section class="full-screen main-screen">
      <div class="container">
         <div class="col-xs-1 col-sm-3 col-md-4">
         </div>
         <div class="col-xs-10 col-sm-6 col-md-4 tab-register">
            <div class="tab-pane">
               <h4>Recover your password</h4>
               <form action="{{ URL::route('password-send') }}" method="post">
                     @if(Session::has('global-negative'))
                     <div class="alert alert-danger" role="alert">
                     {{Session::get('global-negative')}}
                     </div>
                     @endif
                  @if($errors->has('email'))
               		 <span id="mistake-mail"  class="input input--hoshi" data-toggle="tooltip" title="{{$errors->first('email')}}">
                    @else
                    <span class="input input--hoshi">
                    @endif
                        <input id="input-4" type="text" name="email" class="input__field input__field--hoshi" placeholder="E-mail" {{Input::old('email') ? ' value="'. e(Input::old('email')) .'"' : ''}} >
                        <label class="input__label input__label--hoshi" for="input-4">
                          <span class="input__label-content input__label-content--hoshi">Email</span>
                        </label>
               		</span>
                     <div class="input-group submit">
                  		<input type="submit" value="Recover" class="form-control">
                     </div>
                     {{ Form::token() }}
               </form> 
                  		
        
            </div>
         </div>
      </div>
   </section>

@endsection
