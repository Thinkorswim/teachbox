@extends('layouts.master-after')

@section('content')
	<a href="{{ URL::action('ProfileController@userSettings', [$user->id]) }}"> Edit Profile </a>
	<br> <br>

	<a href="#" data-toggle="modal" data-target="#myModal"> Change picture </a>
	<br> <br>
	@if($user->active == 1)
		<a href="{{ URL::action('ProfileController@changePassword', [$user->id]) }}"> Change password </a>
	@endif
	<script src="http://yui.yahooapis.com/3.17.2/build/yui/yui-min.js"></script>
	<script src="{{ URL::asset('js/cropbox.js') }}"></script>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class=" fa-2x pe-7s-close"></i></button>
        <h4 class="modal-title">Change picture</h4>
      </div>
      <div class="modal-body">
        	{{ Form::open(array('action' => array('ProfileController@postChangePic', $user->id), 'files' => true  )) }}
		<div class="imageBox">
	        <div class="thumbBox"></div>
	        <div class="spinner" style="display: none">Loading...</div>
			<div class="fileUpload btn btn-primary">
			    <span>Select Picture</span>
			    {{ Form::file('image', array('placeholder'=>'Password','id'=>'file','class' => 'upload')) }}
			</div>
		    <div class="actions">
		       	<input type="button" id="btnZoomIn" class="btn btn-primary" value="+" style="float: right">
		        <input type="button" id="btnZoomOut" class="btn btn-primary" value="-" style="float: right">
		    </div>
	    </div>

	    <div class="cropped">

	    </div>
		<script type="text/javascript">
		    YUI().use('node', 'crop-box', function(Y){
		        var options =
		        {
		            imageBox: '.imageBox',
		            thumbBox: '.thumbBox',
		            spinner: '.spinner',
		            imgSrc: 'avatar.png'
		        }
		        var cropper = new Y.cropbox(options);
		        Y.one('#file').on('change', function(){
		            var reader = new FileReader();
		            reader.onload = function(e) {
		                options.imgSrc = e.target.result;
		                cropper = new Y.cropbox(options);
		            }
		            reader.readAsDataURL(this.get('files')._nodes[0]);
		            this.get('files')._nodes = [];
		        })
		        Y.one('#btnZoomIn').on('click', function(){
		            cropper.zoomIn();
		        })
		        Y.one('#btnZoomOut').on('click', function(){
		            cropper.zoomOut();
		        })
		    })
		</script>
      	{{ Form::submit('upload', array('placeholder'=>'Password','class'=>'form-control')) }}
        	{{ Form::token() }}
	{{ Form::close() }}
      </div>
    </div>
  </div>
</div>

</div>
@endsection