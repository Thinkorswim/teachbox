@extends('layouts.master-before')

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
               		<div class="input-group">
                    @if($errors->has('email'))
                    <span id="mistake-mail" class="input-group-addon" data-toggle="tooltip" title="{{$errors->first('email')}}">
                     <i class="pe-7s-mail"></i>
                    </span>   
                    @else
                    <span class="input-group-addon"><i class="pe-7s-mail"></i></span>
                    @endif
                        <input id="mail" type="text" name="email" class="form-control" placeholder="E-mail" {{Input::old('email') ? ' value="'. e(Input::old('email')) .'"' : ''}} >
               		</div>
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
