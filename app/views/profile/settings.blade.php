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
				<a class="list-group-item active" href="#">Profile information</a>
				<a class="list-group-item" href="{{ URL::action('ProfileController@changePic', [$user->id]) }}"> Change picture </a>
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
				<h3 class="panel-title">Profile information</h3>
			</div>
		  	<div class="panel-body padding-panel">
				{{ Form::open(array('action' => array('ProfileController@postUserSettings', $user->id))) }}
				<div>Name</div>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-user"></i>
					</span> 
					 {{ Form::text('name', $user->name, array('class'=>'form-control')) }}
					 @if($errors->has('name'))
						{{ $errors->first('name') }}
					@endif
				</div>
				Country: 
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-globe"></i>
					</span> 
				 {{ Form::select('country', $country_array, $user->country, array('class'=>'form-control')) }}
				 @if($errors->has('country'))
					{{ $errors->first('country') }}
				 @endif
				 </div>
				City: 
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-map-marker"></i>
					</span> 
				 {{ Form::text('city', $user->city, array('class'=>'form-control')) }}
				 @if($errors->has('city'))
					{{ $errors->first('city') }}
				 @endif
				 </div>

				<div>Date of birth:</div> 
				{{ Form::selectRange('day', 1, 31, getDay($user->date)) }}
			    {{ Form::selectMonth('month',getMonth($user->date)) }}
				{{ Form::selectRange('year', 2014, 1914, getYear($user->date)) }}

				{{ Form::token() }}
				{{ Form::submit('Save Changes', array('class'=>'form-control')) }}
			{{ Form::close() }}		

		  </div>
		</div>
					    	
	</div>
</div>
@endsection