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
	<div class="col-xs-12 col-sm-3">
	  <ul class="nav nav-pills nav-stacked settings-nav">
	  	<li><a href="{{ URL::action('ProfileController@userSettings', [$user->id]) }}">Profile info</a></li>
		<li class="active"><a href="{{ URL::action('ProfileController@changePic', [$user->id]) }}"> Change picture </a></li>
		@if($user->active == 1)
		<li><a href="{{ URL::action('ProfileController@changePassword', [$user->id]) }}"> Change password </a></li>
		@endif
	  </ul>
	</div> 
	<div class="col-xs-12 col-sm-1"></div>
	<div class="col-xs-12 col-sm-8">
			<div class="panel panel-default">
			  <div class="panel-body">	
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