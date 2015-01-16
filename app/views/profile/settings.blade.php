@extends('layouts.master-after')

@section('content')
<div class="container">
	<div class="col-xs-12 col-sm-3">
	  <ul class="nav nav-tabs">
		<li>
			<a href="{{ URL::action('ProfileController@changePic', [$user->id]) }}" aria-controls="profile" role="tab" data-toggle="tab"> Change picture </a>
		</li>
		@if($user->active == 1)
		<li>
			<a href="{{ URL::action('ProfileController@changePassword', [$user->id]) }}" aria-controls="change-pass" role="tab" data-toggle="tab"> Change password </a>
		</li>
		@endif

	  </ul>
	</div> 
	<div class="col-xs-12 col-sm-9">
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
				{{ Form::open(array('action' => array('ProfileController@postUserSettings', $user->id))) }}
				<img src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}" style="width:200px;height:auto;"/>

					Name: 
					 {{ Form::text('name', $user->name) }}
					 @if($errors->has('name'))
						{{ $errors->first('name') }}
					@endif

					Country: 
					 {{ Form::text('country', $user->country) }}
					 @if($errors->has('country'))
						{{ $errors->first('country') }}
					 @endif

					City: 
					 {{ Form::text('city', $user->city) }}
					 @if($errors->has('city'))
						{{ $errors->first('city') }}
					 @endif

					Date of birth: 
					{{ Form::selectRange('day', 1, 31, getDay($user->date)) }}
				    {{ Form::selectMonth('month',getMonth($user->date)) }}
					{{ Form::selectRange('year', 2014, 1914, getYear($user->date)) }}

					{{ Form::token() }}
					{{ Form::submit('Save Changes') }}
				{{ Form::close() }}			    	
		    </div>
		</div>
@endsection