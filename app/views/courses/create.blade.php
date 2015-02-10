@extends('layouts.master-after')

@section('title')
	Create course -
@stop

@section('description')
	????
@stop

@section('content')
	<section class="full-screen teach-screen">
		<div class="container">
			<div class="col-xs-12 col-md-5">	
				<div class="panel panel-default settings-panel actions">
					<div class="panel-heading">
					    <h3 class="panel-title">Start your teachning journey!</h3>
					</div>
					<div class="panel-body padding-panel">
						{{ Form::open(['route' => 'create-course','files' => true ]) }}	
							@if($errors->has('name'))
							<div class="input-group shown" data-toggle="tooltip" title="{{ $errors->first('name') }}">  
							@else             
							<div class="input-group">
							@endif  
							<span class="input-group-addon"><i class="fa fa-university"></i></span>
							 {{ Form::text('name', null, array('placeholder'=>'Name of course','class'=>'form-control')) }}
							 </div>
							@if($errors->has('description'))
							<div class="input-group shown" data-toggle="tooltip" title="{{ $errors->first('description') }}">  
							@else             
							<div class="input-group">
							@endif  
							{{ Form::textarea('description', null, array('placeholder'=>'Description (min 50 characters ako sum prav de!)','class'=>'form-control')) }}
							 </div>
						<div class="row">
							<img id="profile" src="{{ URL::asset('img/no.jpg')}}" class="circle"/>
							<div class="fileUpload btn btn-primary">
							    <span>Choose a picture</span>
								{{ Form::file('image', array('id'=>'uploadBtn','class'=>'upload'))}}
							</div>
						</div>
							{{ Form::token() }}
							{{ Form::submit('Create Course', array('class'=>'form-control register-button')) }}
						{{ Form::close() }}	
					</div>
				</div>
			</div>
			<div class="col-xs-12  col-md-7">
				<div class="panel panel-default">
					<div class="panel-body padding-panel">
						<h3>Some heading</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
						In sed dapibus eros, sed varius tortor. Etiam at pharetra enim, sit amet blandit nisi. Etiam a hendrerit lectus, sed sollicitudin purus.
						 Nunc aliquet ac sapien a lobortis. Cras tincidunt dapibus finibus. Mauris convallis fermentum leo, ac tempus ligula ultricies eu. 
						 Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed in ligula accumsan mi commodo pretium.
						 Mauris sollicitudin ex quis varius finibus. Phasellus in quam id purus lobortis pellentesque sit amet ut ante.</p>
					</div>
				</div>
			</div>
		</div>
	</section>
<section class="full-screen learn-screen">

</section>
@endsection