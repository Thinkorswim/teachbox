@extends('layouts.master-after')

@section('title')
  Chat -
@stop

@section('description')
  Chat with  your classmates or teachers.
@stop

@section('content')
	<div class="modal fade settings-panel actions" id="list-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
	        <h4 class="modal-title" id="exampleModalLabel">Choose a user </h4>
	      </div>
	      <div class="modal-body">
				<ul class="list-group" role="tablist">
					<button class="list-group-item choose-user">
				    	<img class="small-profile" src="http://www.villard.biz/assets/Uploads/projects/portrait-o.jpg">
				    	<strong> Ivan Lebanov<span class="badge"></span></strong>
			    	</button>
					<button class="list-group-item choose-user">
				    	<img class="small-profile" src="http://www.villard.biz/assets/Uploads/projects/portrait-o.jpg">
				    	<strong> Ivan Lebanov<span class="badge"></span></strong>
			    	</button>
					<button class="list-group-item choose-user">
				    	<img class="small-profile" src="http://www.villard.biz/assets/Uploads/projects/portrait-o.jpg">
				    	<strong> Ivan Lebanov<span class="badge"></span></strong>
			    	</button>
					<button class="list-group-item choose-user">
				    	<img class="small-profile" src="http://www.villard.biz/assets/Uploads/projects/portrait-o.jpg">
				    	<strong> Ivan Lebanov<span class="badge"></span></strong>
			    	</button>
				</ul>
	      </div>
	    </div>
	  </div>
	</div>
	<div class="modal fade settings-panel actions" id="chat-with" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
	        <h4 class="modal-title" id="exampleModalLabel">Choose a user </h4>
	      </div>
	      <div class="modal-body">
	      <form>
				{{ Form::textarea('', null, array('placeholder' => 'Say hi!',
				'rows' => '5', 'class'=>'form-control', 'id' => 'text-new')) }}
				{{ Form::button('Send', array(
				'data-toggle'=>'modal', 'data-target'=>'#chat-with', 'class'=>'btn btn-default form-control',
				'id' => 'send-message')) }}
			</form>
	      </div>
	    </div>
	  </div>
	</div>
	@if(count($users) > 0)
<div class="container" role="tabpanel">
	<div class="col-xs-12 col-sm-4">
		<div class="panel panel-default actions playlist-panel message-list">
		  <div class="panel-heading">
		    <h3 class="panel-title">Chat with<button type="button" data-toggle="modal" data-target="#list-modal" class="btn btn-default"><i class="fa fa-plus"></i></button></h3>
		  </div>
		  <ul class="list-group" role="tablist">
		  		<?php $active = true;
		  			  $i = 1;
		  		 ?>
		  		@foreach ($users as $user)
			  			@if ($active)
					    	<a id="{{ $user->id }}" onclick="setUsername({{ $user->id }})" class="list-group-item active" role="presentation" aria-controls="home" role="tab" data-toggle="tab">
						    	<img class="small-profile" src="{{ URL::asset('img/'.$user->id . '/' . getThumbName($user->pic)) }}">
						    	<strong> {{ $user->name }}<span id="badge-{{ $user->id }}" class="badge"></span></strong>
					    	</a>
							<?php $active = false; ?>
				    	@else
				    		<a id="{{ $user->id }}" onclick="setUsername({{ $user->id }})" class="list-group-item" role="presentation" aria-controls="home" role="tab" data-toggle="tab">
						    	<img class="small-profile" src="{{ URL::asset('img/'.$user->id . '/' . getThumbName($user->pic)) }}">
						    	<strong> {{ $user->name }} 
						    	@if ($count[$i] > 0 )
						    		<span id="badge-{{ $user->id }}" class="badge">{{ $count[$i] }}</span>
						    	@endif
						    	</strong>
					    	</a>
				    	@endif
				    	<?php $i++; ?>	
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
@else
	<div class="container centered no-messages">
		<button type="button" data-toggle="modal" data-target="#list-modal" class="btn btn-default big-plus"><i class="fa fa-3x fa-plus"></i></button>
		<h2><strong>Click on the plus and start your first chat.</strong></h2>
	</div>
@endif
@endsection