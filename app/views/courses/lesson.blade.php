@extends('layouts.master-after')

@section('title')
	{{$lesson->name}} -
@stop

@section('description')
	{{ excerpt($lesson->description) }}
@stop

@section('fb-image')
	{{ URL::asset('courses/' . $course->id . '/' . $lesson->order . '/thumb.png') }}
@stop

@section('content')
<div class="modal fade" id="testModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Test</h4>
      </div>
      <div class="modal-body">
		<ul class="nav nav-tabs hidden">
		<?php $isActive = true; $id= 1; $user=Auth::User();?> 
		@foreach ($questions as $questionTab)
		@if($isActive)
			<li class="active"><a href="#tab{{$id}}" data-toggle="tab">Question</a></li>
			<?php $isActive= false; ?>
		@endif
			<?php $id++; ?>
			<li><a href="#tab{{$id}}" data-toggle="tab">Question</a></li>
		@endforeach
		</ul>
			  {{ Form::open(array('action' => array('CourseController@postLessonTest', $course->id, $lesson->id), 'id'=>'results-form' ,'class'=>'ac-custom ac-radio ac-circle') ) }} 
		<div class="tab-content">
		<?php $isActiveTab = True;?>
		@foreach ($questions as $question)
		@if($isActiveTab)
			<?php $answer = 1; ?>
			<?php $id_question = 1; ?>
		    <div role="tabpanel" class="tab-pane  active" id="tab{{$id_question}}">
		        <h4>{{$question->question}}</h4>
					<section>
							<ul>
							@if($question->choice_1 != NULL)
								<li>
								{{Form::radio('r'.$id_question, $id_question.$answer ,false, array('class'=>'answer', 'id'=>'r1'.$answer))}}
								<label for="r{{$id_question.$answer}}">
									{{$question->choice_1 }}
								</label></li>
								<?php $answer++; ?>
							@endif
							@if($question->choice_2 != NULL)
								<li>
								{{Form::radio('r'.$id_question, $id_question.$answer,false, array('class'=>'answer', 'id'=>'r1'.$answer))}}
								<label for="r{{$id_question.$answer}}">
									{{$question->choice_2}}
								</label></li>
								<?php $answer++; ?>
							@endif
							@if($question->choice_3 != NULL)
								<li>
								{{Form::radio('r'.$id_question,  $id_question.$answer,false, array('class'=>'answer', 'id'=>'r1'.$answer))}}
								<label for="r{{$id_question.$answer}}">
									{{$question->choice_3}}
								</label></li>
								<?php $answer++; ?>
							@endif
							@if($question->choice_4 != NULL)
								<li>
								{{Form::radio('r'.$id_question, $id_question.$answer,false, array('class'=>'answer', 'id'=>'r1'.$answer))}}
								<label for="r{{$id_question.$answer}}">
								{{$question->choice_4}}
								</label></li>
							@endif
							</ul>
					</section>
					<div class="row">
					@if(count($questions) == 1)
					 <button type="button" id="results" class="btn btn-primary btnNext pull-right" > Submit </button>
					@else
					 	<a class="btn btn-primary btnNext pull-right">Next</a>
					 @endif
					 </div>
      		</div>
      		<?php $id_question++; ?>
      		<?php $isActiveTab = false; ?>
        @else
        <?php $answer = 1; ?>
		    <div role="tabpanel" class="tab-pane" id="tab{{$id_question}}">
		        <h4>{{$question->question}}</h4>
					<section>
							<ul>
							@if($question->choice_1 != NULL)
								<li>
								{{Form::radio('r'.$id_question, $id_question.$answer,false, array('class'=>'answer', 'id'=>'r'.$id_question.$answer))}}
								<label for="r{{$id_question.$answer}}">
									{{$question->choice_1 }}
								</label></li>
								<?php $answer++; ?>
							@endif
							@if($question->choice_2 != NULL)
								<li>
								{{Form::radio('r'.$id_question, $id_question.$answer,false, array('class'=>'answer', 'id'=>'r'.$id_question.$answer))}}
								<label for="r{{$id_question.$answer}}">
								{{$question->choice_2}}
								</label></li>
								<?php $answer++; ?>
							@endif
							@if($question->choice_3 != NULL)
								<li>
								{{Form::radio('r'.$id_question, $id_question.$answer,false, array('class'=>'answer', 'id'=>'r'.$id_question.$answer))}}
								<label for="r{{$id_question.$answer}}">
									{{$question->choice_3}}
								</label></li>
								<?php $answer++; ?>
							@endif
							@if($question->choice_4 != NULL)
								<li>
								{{Form::radio('r'.$id_question, $id_question.$answer,false, array('class'=>'answer', 'id'=>'r'.$id_question.$answer))}}
								<label for="r{{$id_question.$answer}}">
								{{$question->choice_4}}
								</label></li>

							@endif
							</ul>
					</section>
					<div class="row">
						@if($id_question  == count($questions))
							<a class="btn btn-primary btnPrevious" >Previous</a>
					    	<button type="button" id="results" class="btn btn-primary btnNext pull-right" > Submit </button>
						@else
							<a class="btn btn-primary btnPrevious" >Previous</a>
						 	<a class="btn btn-primary btnNext pull-right" >Next</a>
					 	@endif
					 </div>
      		</div>
      		<?php $id_question++; ?>
      	@endif
      	@endforeach

			{{ Form::close() }}
      		</div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<section class="video-section">
	<div class="container">
		<nav class="nav-reveal">
			@if ($lesson->order != 1)
			<a class="prev" href="{{ URL::action('CourseController@courseLesson', [$course->id,($previousLesson->order)]) }}">
				<span class="icon-wrap">
					<i class="fa fa-2x fa-chevron-left"></i>
				</span>
				<div>
					<h3> {{ $previousLesson->name }} <span>by {{ $creator->name; }}</span></h3>
					<img src="{{ URL::asset('courses/' . $course->id . '/' . $previousLesson->order . '/thumb100x100.png') }}" alt="Previous thumb">
				</div>
			</a>
			@endif
			@if ($lesson->order != $lessonList->count())
			<a class="next" href="{{ URL::action('CourseController@courseLesson', [$course->id,($nextLesson->order)]) }}">
				<span class="icon-wrap">
					<i class="fa fa-2x fa-chevron-right"></i>
				</span>
				<div>
					<h3> {{ $nextLesson->name }}<span>by {{ $creator->name; }}</span></h3>
					<img src="{{ URL::asset('courses/' . $course->id . '/' . $nextLesson->order . '/thumb100x100.png') }}" alt="Next thumb">
				</div>
			</a>
			@endif
		</nav>
		<div class="col-xs-1"></div>
		<div class="col-xs-10">
			<video id="video_main" class="video-js vjs-default-skin vjs-big-play-centered" controls
			 preload="auto" width="100%" height="500"   poster="{{ URL::asset('courses/' . $course->id . '/' . $lesson->order . '/thumb.png') }}"
			 data-setup="{}">
				<source src="{{ URL::asset('courses/' . $course->id . '/' . $lesson->order . '/' . $lesson->filepath) }}" type="video/mp4" />
				<source src="{{ URL::asset('courses/' . $course->id . '/' . $lesson->order . '/video.webm') }}" type="video/webm" />
			    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
			</video>
			<div id="on-end">
				<button id="repeat" type="button" onclick="playVid()"><i class="fa fa-repeat fa-4x" ></i></button>
				<?php $idLesson = $lesson->id; $isDone = Result::where(function ($query) {
				    $query->where('user_id', '=', Auth::user()->id);
				})->where(function ($query) use ( $idLesson) {
				    $query->where('lesson_id', '=', $idLesson);
				})->first(); ?>
				@if(count($isDone) == 0 && Auth::user()->id != $course->user_id && $isJoined)
				<p>or</p>
				<button class="btn btn-default btn-primary btn-lg" type="button" data-target="#testModal" data-toggle="modal" data-backdrop="static">Take the test</button>
				@endif
			</div>
		</div>
		<div class="col-xs-1"></div>
	</div>
</section>
<div class="container">
	<div class="col-xs-12 col-sm-8">
		<div class="panel panel-default place">
		  <div class="panel-body">
			<h1>{{ $lesson->name }}</h1>
	        <p>{{ $lesson->description }}</p>
	        @if (Auth::user()->id == $course->user_id)
				<a class="edit-lesson" href ="{{ URL::action('CourseController@lessonEdit', [$course->id,$lesson->order]) }}" >
						<i class="fa fa-edit"></i>
				</a>
			@endif
		 </div>
		</div>
		{{ Form::open(array('action' => array('CourseController@postComment', $lesson->id, Auth::user()->id), 'id'=>'results-form' ,'class'=>'ac-custom ac-radio ac-circle') ) }} 
			{{ Form::textarea('comment', null, array('class'=>'form-control comment-post', 'rows'=>'3','placeholder'=>'Add your comment')) }}
			{{ Form::token() }}
				@if($errors->has('comment'))
								<div class="alert alert-danger" role="alert"> {{ $errors->first('comment') }} </div>
				@endif
		<div class="row"> 
			{{ Form::button('Submit', array('type' => 'submit','id'=>  'comment-post-button', 'class'=>'btn btn-primary hidden pull-right')) }}
		</div>
		{{ Form::close() }}
		<div class="scroll status comments">
		@foreach ($comments as $comment)
		 <?php $userT = User::find($comment->user_id);
		 		$replies = CommentReply::where('comment_id', '=', $comment->id)->get(); 
		 		$shownComment = (CommentVote::where('comment_id', '=', $comment->id)->where('isReply', '=', '0')->count() > 0)?>
				<div class="panel panel-default settings-panel actions">
					<div class="panel-body">
					  	<p class="heading"><a href="{{ URL::action('ProfileController@user', $userT->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $userT->id . '/' . $userT->pic) }}"></a>
						<strong>
						<a href="{{ URL::action('ProfileController@user', $userT->id) }}"> {{  $userT->name }} </a></strong> 
						   commented
						   <strong>{{dateTimeline($comment->created_at)}}</strong>
						</p>
						<hr>
						<div class="content-status">
							<p class="comment-text">{{$comment->text}}</p>
						</div>
					</div>
					<div class="panel-footer {{$comment->id}}">
							<a id="{{$comment->id}}" class="reply" href="javascript:void(0)">Reply</a>
							<span id="lc{{$comment->id}}"> {{ $comment->liked }} </span>
							@if(!$shownComment)

								<span id="thumbs-comment-{{$comment->id}}">
									<a href="javascript:void(0)" ><i class="fa fa-thumbs-up vote upvote no" id="cu{{ $comment->id }}"></i></a>
									<a href="javascript:void(0)" ><i class="fa fa-thumbs-down vote downvote no" id="cd{{ $comment->id }}"></i></a>
								</span>
							@endif
					</div>
					@foreach ($replies as $reply)
		 <?php $userR = User::find($reply->user_id);
		 	   $shownReply = (CommentVote::where('comment_id', '=', $reply->id)->where('isReply', '=', '1')->count() > 0)?>
				<div class="panel panel-default settings-panel actions replied">
					<div class="panel-body">
					  	<p class="heading"><a href="{{ URL::action('ProfileController@user', $userT->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $userT->id . '/' . $userT->pic) }}"></a>
						<strong>
						<a href="{{ URL::action('ProfileController@user', $userT->id) }}"> {{  $userR->name }} </a></strong> 
						   replied
						   <strong>{{dateTimeline($reply->created_at)}}</strong>
						</p>
						<hr>
						<div class="content-status">
							<p class="comment-text">{{$reply->text}}</p>
						</div>
					</div>
					<div class="panel-footer">
							<a href="" class="hidden"></a>
							<span id="lr{{$comment->id}}"> {{ $reply->liked }} </span>
							@if(!$shownReply)
							<span id="thumbs-reply-{{$reply->id}}">
								<a href="javascript:void(0)" ><i class="fa fa-thumbs-up vote upvote yes"  id="cu{{ $reply->id }}"></i></a>
								<a href="javascript:void(0)" ><i class="fa fa-thumbs-down vote downvote yes" id="cd{{ $reply->id }}"></i></a>
							</span>
							@endif
					</div>	
			</div>			
						@endforeach
			</div>
		@endforeach
		{{$comments->links()}}
	
	</div>
	</div>
	<div class="col-xs-12 col-sm-4">
	 @if(count($isDone) > 0)
		<div class="panel panel-default settings-panel actions place result">
		  <div class="panel-body padding-panel">
		    <?php 
		    $result = $isDone->right;
		    $maximum = $isDone->total;
		    $overall = (intval($result)/intval($maximum)) * 100; ?>
		  		<h2>You scored {{$overall}}%!</h2>
		  </div>
		</div>
			@endif
			@if(count($isDone) == 0 && Auth::user()->id != $course->user_id && $isJoined)
				<button class="btn btn-default  join place btn-primary" type="button" data-target="#testModal" data-toggle="modal" data-backdrop="static">Take the test</button>
			@endif
		<div class="panel panel-default actions playlist-panel place">
		  <div class="panel-heading">
		  	<h3 class="panel-title">
		  		<a href="{{ URL::action('CourseController@course', [$course->id]) }}"> {{ $course->name; }} </a>
		  	</h3>
		  	<small> by <strong><a href="{{ URL::action('ProfileController@user', $creator->id) }}"> {{ $creator->name; }} </a></strong></small>
		  </div>
		  <div class="panel-body">
			  <div class="list-group" id="list-lessons">
			  <?php $i = 1; ?>
				@foreach ($lessonList as $lesson_temp)
				@if(Auth::user()->admin || $lesson_temp->approved || Auth::user()->id == $course->user_id)
					@if ($lesson_temp->order == $lesson->order)
			 		 	<a class="list-group-item active" id="active"  href="{{ URL::action('CourseController@courseLesson', [$course->id,$lesson_temp->order]) }}">
							<div class="col-xs-9">
				 				<strong><?php echo $i; $i++; ?>. </strong> {{' '. $lesson_temp->name; }}
				 			</div>
				 			<div class="col-xs-3">
				 			 	<div class="pull-right">{{ $lesson_temp->duration; }}</div> 
				 			</div>
			 		 	 </a>
			 		@else
				 		<a class="list-group-item" href="{{ URL::action('CourseController@courseLesson', [$course->id,$lesson_temp->order]) }}">
							<div class="col-xs-9">
				 				<strong><?php echo $i; $i++; ?>. </strong> {{' '. $lesson_temp->name; }}
				 			</div>
				 			<div class="col-xs-3">
				 			 	 <div class="pull-right">{{ $lesson_temp->duration; }}</div> 
				 			</div>
				 		</a>
			 		@endif
			 	@endif
			    @endforeach
			   </div>
		  </div>
		</div>
	</div>
</div>


@endsection