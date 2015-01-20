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
	  	<li class="active"><a href="#">Profile info</a></li>
		<li><a href="{{ URL::action('ProfileController@changePic', [$user->id]) }}"> Change picture </a></li>
		@if($user->active == 1)
		<li><a href="{{ URL::action('ProfileController@changePassword', [$user->id]) }}"> Change password </a></li>
		@endif
	  </ul>
	</div> 
	<div class="col-xs-12 col-sm-1"></div>
	<div class="col-xs-12 col-sm-8">
			<div class="panel panel-default">
			  <div class="panel-body">
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

							Date of birth: 
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