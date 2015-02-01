@extends('layouts.master-after')

@section('content')

<div class="container" role="tabpanel">
	<div class="col-xs-12 col-sm-4">
		<div class="panel panel-default actions playlist-panel message-list">
		  <div class="panel-heading">
		    <h3 class="panel-title">Chat with</h3>
		  </div>
		  <ul class="list-group" role="tablist">
		    	<a href="#user-1" class="list-group-item" role="presentation" aria-controls="home" role="tab" data-toggle="tab">
			    	<img class="small-profile" src="http://edition2013.mama-event.com/wmedias/festival/artistes/JeremyLoopsJemSolo.jpg">
			    	<strong>Ivan Lebanov <span class="badge">4</span></strong>
		    	</a>
			    <a href="#user-2" class="list-group-item" role="presentation" aria-controls="profile" role="tab" data-toggle="tab">
			    	<img class="small-profile" src="http://edition2013.mama-event.com/wmedias/festival/artistes/JeremyLoopsJemSolo.jpg">
			    	<strong>Ivan Lebanov<span class="badge">23</span></strong>
			    </a>
			    <a href="#user-3" class="list-group-item" role="presentation" aria-controls="messages" role="tab" data-toggle="tab">
			    	<img class="small-profile" src="http://edition2013.mama-event.com/wmedias/festival/artistes/JeremyLoopsJemSolo.jpg">
			    	<strong>Ivan Lebanov<span class="badge"></span></strong>
			    </a>
		    <a href="#user-4" class="list-group-item" role="presentation" aria-controls="settings" role="tab" data-toggle="tab">
		    	<img class="small-profile" src="http://edition2013.mama-event.com/wmedias/festival/artistes/JeremyLoopsJemSolo.jpg">
		    	<strong>Ivan Lebanov<span class="badge">100</span></strong>		    
		    </a>
	    	<a href="#user-5" class="list-group-item active" role="presentation" aria-controls="home" role="tab" data-toggle="tab">
		    	<img class="small-profile" src="http://edition2013.mama-event.com/wmedias/festival/artistes/JeremyLoopsJemSolo.jpg">
		    	<strong>Ivan Lebanov <span class="badge">4</span></strong>
	    	</a>
		    <a href="#user-6" class="list-group-item" role="presentation" aria-controls="profile" role="tab" data-toggle="tab">
		    	<img class="small-profile" src="http://edition2013.mama-event.com/wmedias/festival/artistes/JeremyLoopsJemSolo.jpg">
		    	<strong>Ivan Lebanov<span class="badge">23</span></strong>
		    </a>
		    <a href="#user-7" class="list-group-item" role="presentation" aria-controls="messages" role="tab" data-toggle="tab">
		    	<img class="small-profile" src="http://edition2013.mama-event.com/wmedias/festival/artistes/JeremyLoopsJemSolo.jpg">
		    	<strong>Ivan Lebanov<span class="badge"></span></strong>
		    </a>
		    <a href="#user-8" class="list-group-item" role="presentation" aria-controls="settings" role="tab" data-toggle="tab">
		    	<img class="small-profile" src="http://edition2013.mama-event.com/wmedias/festival/artistes/JeremyLoopsJemSolo.jpg">
		    	<strong>Ivan Lebanov<span class="badge">100</span></strong>		    
		    </a>
		  </ul>
		</div>
	</div>
	<div class="col-xs-12 col-sm-8">
	  <div class="tab-content panel panel-default actions">
	    <div role="tabpanel" class="tab-pane active" id="user-1">1</div>
	    <div role="tabpanel" class="tab-pane" id="user-2">2</div>
	    <div role="tabpanel" class="tab-pane" id="user-3">3</div>
	    <div role="tabpanel" class="tab-pane" id="user-4">4</div>
	    <div role="tabpanel" class="tab-pane" id="user-5">5</div>
	    <div role="tabpanel" class="tab-pane" id="user-6">6</div>
	    <div role="tabpanel" class="tab-pane" id="user-7">7</div>
	    <div role="tabpanel" class="tab-pane" id="user-8">8</div>
	  </div>		
	</div>
</div>

@endsection