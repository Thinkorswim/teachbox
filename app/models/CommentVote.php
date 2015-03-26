<?php

class CommentVote extends Eloquent {

protected $fillable = array('comment_id', 'user_id', 'isReply');

}