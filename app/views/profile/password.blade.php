@extends('layouts.master-after')

@section('content')
<div class="container">
	<div class="row">
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
	</div>

	<div class="col-xs-12 col-sm-4">
		<div class="panel panel-default actions">
		  <div class="panel-heading">
		    <h3 class="panel-title">Settings</h3>
		  </div>
		<div class="panel-body">
			<div class="list-group">
				<a class="list-group-item" href="#">Profile information</a>
				<a class="list-group-item" href="{{ URL::action('ProfileController@changePic', [$user->id]) }}"> Change picture </a>
				@if($user->active == 1)
				<a class="list-group-item active" href="{{ URL::action('ProfileController@changePassword', [$user->id]) }}"> Change password </a>
				@endif
			</div>
		</div>
		</div> 
	</div>
	<div class="col-xs-12 col-sm-8">
		<div class="panel panel-default settings-panel actions">
			<div class="panel-heading">
				<h3 class="panel-title">Change password</h3>
			</div>
		  <div class="panel-body padding-panel">	

			{{ Form::open(array('action' => array('ProfileController@postUserSettings', $user->id))) }}
			<div class="input-group">
				<span class="input-group-addon">
					<i class="fa fa-lock"></i>
				</span> 				
				{{ Form::password('password', array('placeholder'=>'Password', 'class'=>'form-control')) }}
				@if($errors->has('password'))
					{{ $errors->first('password') }}
				@endif
				</div>
			<div class="input-group">
				<span class="input-group-addon">
					<i class="fa fa-lock"></i>
				</span> 
				{{ Form::password('new_password', array('placeholder'=>'New Password', 'class'=>'form-control')) }}
				@if($errors->has('new_password'))
					{{ $errors->first('new_password') }}
				@endif
				</div>
			<div class="input-group">
				<span class="input-group-addon">
					<i class="fa fa-lock"></i>
				</span> 
				{{ Form::password('new_password_again', array('placeholder'=>'New Password Again', 'class'=>'form-control')) }}
				@if($errors->has('new_password_again'))
					{{ $errors->first('new_password_again') }}
				@endif
				</div>
				{{ Form::submit('Change password', array('class'=>'form-control')) }}
				{{ Form::token() }}
			{{ Form::close() }}
		   </div>
		</div>
	</div>
</div>
@endsection