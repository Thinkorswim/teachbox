@extends('layouts.master-after')
@section('title')
  Change your profile -
@stop

@section('description')
  	{{ excerpt($user->decription) }}
@stop
@section('content')
<div class="container follow">
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
		<div class="panel panel-default actions place">
		  <div class="panel-heading">
		    <h3 class="panel-title">Settings</h3>
		  </div>
		<div class="panel-body">
			<div class="list-group">
				<a class="list-group-item active" href="{{ URL::action('ProfileController@userSettings', [$user->id]) }}">Profile information</a>
				<a class="list-group-item" href="{{ URL::action('ProfileController@changePic', [$user->id]) }}"> Change picture </a>
				@if($user->active == 1)
				<a class="list-group-item" href="{{ URL::action('ProfileController@changePassword', [$user->id]) }}"> Change password </a>
				@endif
			</div>
		</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-8">
		<div class="panel panel-default settings-panel actions place">
			<div class="panel-heading">
				<h3 class="panel-title">Profile information</h3>
			</div>
		  	<div class="panel-body padding-panel">
				{{ Form::open(array('action' => array('ProfileController@postUserSettings', $user->id))) }}
					<div>Name</div>
					@if($errors->has('name'))
					<div class="input-group" data-toggle="tooltip" title="{{ $errors->first('name') }}">
					@else
					<div class="input-group">
					@endif
					<span class="input-group-addon">
						<i class="fa fa-user"></i>
					</span>
					 {{ Form::text('name', $user->name, array('id'=>'input-8', 'class'=>'form-control')) }}
				</div>
				@if($errors->has('city'))
					<div class="input-group" data-toggle="tooltip" title="{{ $errors->first('city') }}">  
					@else
					<div class="input-group">
					@endif
					<span class="input-group-addon">
						<i class="fa fa-map-marker"></i>
					</span>
				 {{ Form::text('city', $user->city, array('id'=>'input-9', 'class'=>'form-control')) }}
				</div>
				Country:
					@if($errors->has('country'))
					<div class="input-group shown" data-toggle="tooltip" title="{{ $errors->first('country') }}">  
					@else
					<div class="input-group">
					@endif
					<span class="input-group-addon">
						<i class="fa fa-globe"></i>
					</span>
				 {{ Form::select('country', $country_array, $user->country, array('class'=>'form-control')) }}
				 </div>
				 <div>
				Describe yourself in a few words:
					@if($errors->has('decription'))
					<div class="input-group shown" data-toggle="tooltip" title="{{ $errors->first('decription') }}">  
					@else
					<div class="input-group">
					@endif
				 {{ Form::textarea('decription', $user->decription, array('class'=>'form-control','rows' => '5')) }}
				 </div>

				<div>Date of birth:
				{{ Form::selectRange('day', 1, 31, getDay($user->date)) }}
			    {{ Form::selectMonth('month',getMonth($user->date)) }}
				{{ Form::selectRange('year', 2014, 1914, getYear($user->date)) }}
				</div>
				<div>
				{{ Form::token() }}
				{{ Form::submit('Save Changes', array('class'=>'form-control')) }}
				</div>
			{{ Form::close() }}
	
		  </div>
		</div>
	</div>
</div>
@endsection