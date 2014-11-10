@extends('layouts.master-after')

@section('content')
	<a href="{{ URL::action('ProfileController@changePic', [$user->id]) }}"> Change picture </a>
@endsection