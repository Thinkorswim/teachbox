@extends('layouts.master-after')

@section('title')
  Change password -
@stop

@section('description')
  	{{ excerpt($user->decription) }}
@stop

@section('content')
<div class="container">
	<div class="col-xs-12 col-sm-4">
		<div class="panel panel-default actions place">
		  <div class="panel-heading">
		    <h3 class="panel-title">Settings</h3>
		  </div>
		<div class="panel-body">
			<div class="list-group">
				<a class="list-group-item" href="{{ URL::action('ProfileController@userSettings', [$user->id]) }}">Profile information</a>
				<a class="list-group-item" href="{{ URL::action('ProfileController@changePic', [$user->id]) }}"> Change picture </a>
				@if($user->active == 1)
				<a class="list-group-item active" href="{{ URL::action('ProfileController@changePassword', [$user->id]) }}"> Change password </a>
				@endif
			</div>
		</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-8">
		<div class="panel panel-default settings-panel actions place">
			<div class="panel-heading">
				<h3 class="panel-title">Change password</h3>
			</div>
		  <div class="panel-body padding-panel">
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
			{{ Form::open(array('action' => array('ProfileController@postChangePassword', $user->id))) }}
			<div>
				@if($errors->has('password'))
				<span class="input input--hoshi shown" data-toggle="tooltip" title="{{ $errors->first('password') }}">
				@else
				<span class="input input--hoshi">
				@endif
				{{ Form::password('password', array('placeholder'=>'Password','id'=>'input-6', 'class'=>'input__field input__field--hoshi')) }}
				<label class="input__label input__label--hoshi" for="input-6">
					<span class="input__label-content input__label-content--hoshi">Password</span>
				</label>
				</span>
				</div>
				<div>
				@if($errors->has('new_password'))
				<span class="input input--hoshi shown" data-toggle="tooltip" title="{{ $errors->first('new_password') }}">
				@else
				<span class="input input--hoshi">
				@endif
				{{ Form::password('new_password', array('placeholder'=>'New Password', 'id'=>'input-7', 'class'=>'input__field input__field--hoshi')) }}
				<label class="input__label input__label--hoshi" for="input-7">
					<span class="input__label-content input__label-content--hoshi">New Password</span>
				</label>
				</span>
				</div>
				<div>
				@if($errors->has('new_password_again'))
				<span class="input input--hoshi shown" data-toggle="tooltip" title="{{ $errors->first('new_password_again') }}">
				@else
				<span class="input input--hoshi">
				@endif
				{{ Form::password('new_password_again', array('placeholder'=>'New Password Again','id'=>'input-8', 'class'=>'input__field input__field--hoshi')) }}
				<label class="input__label input__label--hoshi" for="input-8">
					<span class="input__label-content input__label-content--hoshi">Repeat new password</span>
				</label>
				</span>
				</div>
				{{ Form::submit('Change password', array('class'=>'form-control')) }}
				{{ Form::token() }}
			{{ Form::close() }}
		   </div>
		</div>
	</div>
</div>
@endsection