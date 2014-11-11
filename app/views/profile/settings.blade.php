@extends('layouts.master-after')

@section('content')
	<a href="{{ URL::action('ProfileController@changePic', [$user->id]) }}"> Change picture </a>
	<br> <br>
	@if($user->active == 1)
		<a href="{{ URL::action('ProfileController@changePassword', [$user->id]) }}"> Change password </a>
	@endif
@endsection