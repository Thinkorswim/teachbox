@extends('layouts.master-after')

@section('content')
	<section class="full-screen teach-screen">
		<div class="container">
			<div class="col-xs-1 col-sm-3 col-md-4">
			</div>
			<div class="col-xs-10 col-sm-6 col-md-4 tab-register">	
				<div class="tab-pane">
					<h4>Start your teachning journey!</h4>
					{{ Form::open(['route' => 'create-course']) }}	
						Name: 
						 {{ Form::text('name') }}
						 @if($errors->has('name'))
							{{ $errors->first('name') }}
						@endif
						Description: 
						 {{ Form::text('description') }}
						 @if($errors->has('description'))
							{{ $errors->first('description') }}
						@endif
						{{ Form::token() }}
						{{ Form::submit('Create Course') }}
					{{ Form::close() }}	
				</div>
</div>
</div>
</section>
<section class="full-screen learn-screen">

</section>
@endsection