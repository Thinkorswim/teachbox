@extends('layouts.master-after')

@section('title')
	Create course -
@stop

@section('description')
	Create your course in teachbox.
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
							@if($errors->has('pic'))
								<div class="alert alert-danger" role="alert"> {{ $errors->first('pic') }} </div>
							@endif
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
							{{ Form::textarea('description', null, array('placeholder'=>'Description (min 30 characters)','class'=>'form-control')) }}
							</div>
							<div class="row">
									<img id="profile" src="{{ URL::asset('img/no.jpg')}}" class="circle"/>
								<div class="fileUpload btn btn-primary">
								    <span>Choose a picture</span>
									{{ Form::file('image', array('id'=>'uploadBtn','class'=>'upload'))}}
								</div>
							</div>
							<div class="row-add">
								<div class="alert alert-info" role="alert">
									<p> Upload only *.png and *.jpg files with a max size of 4mb.</p>
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
						<h3>Revolution in online teaching</h3>
						<p>Create your course and teach people all over the world!
						 We give you the freedom to create a great course when you start adding lessons. Our platform is social so when the course is ready start to advertise it by following new people.
						 If you are a novice watch our lessons: </p><p> "How to create professional online course". </p>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-body padding-panel">
						<h3>Guidelines</h3>
						<ul>
							<li>Course name should be between 4 and 128 symbols</li>
							<li>Course description should be maximum 4096 symbols.</li>
							<li>Your course will be sent for approvement and it won't be public unless it's approved.</li>
							<li>Every lesson will be sent for approvement as well.</li>
							<li>If anything is wrong with your with your course we'll inform you.</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection