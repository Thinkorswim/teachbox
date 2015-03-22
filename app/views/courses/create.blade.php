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
				<div class="panel panel-default actions">
					<div class="panel-body padding-panel">
						<h2>Revolution in online teaching</h2>
						<p>Create your course and share your knowledge with people all over the world!
						 We give you the technology and the support needed to create a fun and engaging course. 
						 Our platform is social so the best thing to do after creating your first course is to grow your community
						 by following and messaging new people.
						 If you are new to this watch our series: </p><p> <a href="https://teachbox.io/course/16">"How to create a professional online course"</a> </p>
					</div>
				</div>
				<div class="panel panel-default actions">
					<div class="panel-body padding-panel">
						<h2>Guidelines</h2>
						<ul style="padding-left: 20px;">
							<li>Your course  <strong>name</strong> should be between <strong>4</strong> and <strong>128</strong> characters</li>
							<li>Your course  <strong>description</strong> should be a maximum of <strong>4096</strong> characters.</li>
							<li>Your course will be sent for approval and it <strong>will not be accessible</strong> by other users until it is approved.</li>
							<li>Every <strong>lesson</strong> you upload will be sent for <strong>approval</strong> as well.</li>
							<li>If anything is <strong>wrong</strong> with your submissions we will <strong>inform</strong> you.</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection