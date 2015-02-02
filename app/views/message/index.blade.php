@extends('layouts.master-after')

@section('content')

<div class="container" role="tabpanel">
	<div class="col-xs-12 col-sm-4">
		<div class="panel panel-default actions playlist-panel message-list">
		  <div class="panel-heading">
		    <h3 class="panel-title">Chat with</h3>
		  </div>
		  <ul class="list-group" role="tablist">
		  		<?php $active = true; ?>
		  		@foreach ($users as $user)
			  			@if ($active)
					    	<a id="{{ $user->id }}" onclick="setUsername({{ $user->id }})" class="list-group-item active" role="presentation" aria-controls="home" role="tab" data-toggle="tab">
						    	<img class="small-profile" src="{{ URL::asset('img/'.$user->id . '/' . getThumbName($user->pic)) }}">
						    	<strong> {{ $user->name }}<span class="badge">4</span></strong>
					    	</a>
							<?php $active = false; ?>				    	
				    	@else
				    		<a id="{{ $user->id }}" onclick="setUsername({{ $user->id }})" class="list-group-item" role="presentation" aria-controls="home" role="tab" data-toggle="tab">
						    	<img class="small-profile" src="{{ URL::asset('img/'.$user->id . '/' . getThumbName($user->pic)) }}">
						    	<strong> {{ $user->name }} <span class="badge">4</span></strong>
					    	</a>
				    	@endif
			    @endforeach
		  </ul>
		</div>
	</div>
	<div class="col-xs-12 col-sm-8">
		<div class="tab-content">
		  <div id="chat" class="panel panel-default actions">
				  	<div id="chat-window" role="tabpanel" class="tab-pane active">
				  	  		
				  	</div>
		  </div>		
			<div class="panel panel-default settings-panel actions">
				<div class="panel-body padding-panel send-message">
					<input type="text" id="text" class="form-control col-lg-12" autofocus="" placeholder="Compose and press enter">
				</div>
			</div>
		</div>
	</div>
</div>
@endsection