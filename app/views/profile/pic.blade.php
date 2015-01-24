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
				<a class="list-group-item" href="{{ URL::action('ProfileController@userSettings', [$user->id]) }}">Profile information</a>
				<a class="list-group-item active" href="{{ URL::action('ProfileController@changePic', [$user->id]) }}"> Change picture </a>
				@if($user->active == 1)
				<a class="list-group-item" href="{{ URL::action('ProfileController@changePassword', [$user->id]) }}"> Change password </a>
				@endif
			</div>
		 </div>
		</div> 
	</div>
	<div class="col-xs-12 col-sm-8">
		<div class="panel panel-default settings-panel actions">
			<div class="panel-heading">
				<h3 class="panel-title">Change picture</h3>
			</div>
		  	<div class="panel-body padding-panel">
				{{ Form::open(array('action' => array('ProfileController@postChangePic', $user->id), 'files' => true  )) }}
				<img src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}" class="circle"/>
				<input id="uploadFile" placeholder="Choose File" disabled="disabled" />
				<div class="fileUpload btn btn-primary">
				    <span>Choose a picture</span>
					{{ Form::file('image', array('id'=>'uploadBtn','class'=>'upload'))}}
				</div>
				{{ Form::submit('Save changes', array('class'=>'form-control register-button')) }}
				{{ Form::token() }}
				{{ Form::close() }}
				</div>
			</div>
	</div>
</div>
@endsection