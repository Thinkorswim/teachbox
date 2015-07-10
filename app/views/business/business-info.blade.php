@extends('layouts.master-before')
@section('title')
	Contacts -
@stop
@section('description')


@stop
@section('content')

	<section class="full-screen biznes">
		<div class="container">
			<div class="col-xs-12 col-sm-12 col-md-8">
				<h2>Teachbox for business.</h2>
				<p>Make private courses for your company needs.</p>
				<h2>Coming soon.</h2>
			</div>
			<!-- <div class="col-md-4 tab-register sub-space">
					<div role="tabpanel" class="tab-sub">
						<h3>Request an invitation.</h3>
						  	{{ Form::open(['route' => 'post-subscribe']) }}
							@if($errors->has('email'))
							<span id="mail-error" class="input input--hoshi" data-toggle="tooltip" title="{{$errors->first('email')}}">
							@else
							<span id="mail" class="input input--hoshi" data-toggle="tooltip" title="It will be used for your authenticaion">
							@endif
						 	{{ Form::text('email', null , array('placeholder'=>'E-mail', 'id'=>'input-8', 'class'=>'input__field input__field--hoshi')) }}
						 								<label class="input__label input__label--hoshi" for="input-8">
								<span class="input__label-content input__label-content--hoshi">E-mail</span>
							</label>
						  	</span>
							<div class="input-group submit">
								 {{ Form::submit('Request', array('class'=>'form-control')) }}
							</div>

						  {{ Form::close() }}
					</div>
				</div>
			</div> -->
		</div>
	</section>
	<!--
	<section class="full-screen learn-screen">
		<div class="container centered">
			<h1>Why?</h1>
			<div class="col-sm-3">
				<h3>Consistency</h3>
				<p>Stay in touch with your friends and get to know people with similar interests as yours.</p>
			</div>

			<div class="col-sm-3">
				<h3>Security</h3>
				<p>Stay in touch with your friends and get to know people with similar interests as yours.</p>
			</div>

			<div class="col-sm-3">
				<h3>Security</h3>
				<p>Stay in touch with your friends and get to know people with similar interests as yours.</p>
			</div>

			<div class="col-sm-3">
				<h3>24/7 Security</h3>
				<p>Stay in touch with your friends and get to know people with similar interests as yours.</p>
			</div>
		</div>
	</section>

	<section class="full-screen plans">
		<div class="container">
			<h1>Plans.</h1>
			<div class="col-sm-3">
				<h3>Consistency</h3>
				<p>Stay in touch with your friends and get to know people with similar interests as yours.</p>
			</div>

			<div class="col-sm-3">
				<h3>Security</h3>
				<p>Stay in touch with your friends and get to know people with similar interests as yours.</p>
			</div>

			<div class="col-sm-3">
				<h3>Security</h3>
				<p>Stay in touch with your friends and get to know people with similar interests as yours.</p>
			</div>

			<div class="col-sm-3">
				<h3>24/7 Security</h3>
				<p>Stay in touch with your friends and get to know people with similar interests as yours.</p>
			</div>
		</div>
	</section> -->
@endsection
