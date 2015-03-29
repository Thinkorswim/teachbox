@extends('layouts.master-after')
@section('title')
	 search term -
@stop

@section('description')
	Search the courses in teachbox
@stop

@section('content')
	<div class="search-page">
	<div class="container">
		@if($keyword)
		<h1>Search for <strong>{{ $keyword }}</strong></h1>
		@else
		<h1>Please type at least one letter.</strong></h1>
		@endif
	</div>
	</div>
@if($keyword)
<div class="container follow">
	<div class="col-xs-12 col-sm-4">

		<div class="panel panel-default actions results">
		  <div class="panel-heading">
		    <h3 class="panel-title">Results</h3>
		  </div>
			<div class="panel-body">
				<div class="list-group">
				  <a class="list-group-item" href="{{ URL::action('SearchController@search', [$keyword]) }}">
				    <span class="badge">{{$countCourse}}</span>
				    Courses
				  </a>
				  <a class="list-group-item active" href="{{ URL::action('SearchController@searchUser', [$keyword]) }}">
				    <span class="badge">{{$countUser}}</span>
				    People
				  </a>

				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-8">
		@if(count($users) == 0)
			<div class="place row centered">
				<h2><strong>No users.</strong></h2>
				<small>Maybe change your search to something less specific. </small>
			</div>
		@endif
		<div class="scroll">
			@foreach ($users as $result)
			
			<div class="col-xs-12 col-sm-6 student">
				<div class="panel panel-default student-card">
				  <div class="panel-body padding-panel">
			  		<a href="{{ URL::action('ProfileController@user', [$result->id]) }}">
			  		<img src="{{ URL::asset('img/'. $result->id . '/' . $result->pic) }}"alt="{{ $result->name }}'s profile">
					</a>@if ($result->date != '')
						<span class="age" data-toggle="tooltip" data-placement="right" title="{{ageCalculator( $result->date )}} years old">
							{{ageCalculator( $result->date )}}
						</span>
						@endif 
					    @if ($result->country != '')
						<span class="country" style="background:url('{{ URL::asset(countryFlag( $result->country ))}}') center center" 
							data-toggle="tooltip" data-placement="right" title="{{ $result->city }}@if($result->country != '' && $result->city != ''), @endif {{ $result->country }}">
						</span>
						@endif
				  		<h4><a href="{{ URL::action('ProfileController@user', [$result->id]) }}">{{ $result-> name }}</a></h4>
				  		<small>{{ $result->city }}@if($result->country != '' && $result->city != ''), @endif {{ $result->country }}</small>
				  </div>
				</div>
			</div>

			@endforeach

		{{ $users->links() }}
	</div>
	</div>
</div>
@endif
@endsection