<?php

class CommentReply extends Eloquent {

protected $fillable = array('comment_id', 'user_id', 'text');

}