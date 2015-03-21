<?php

class Comment extends Eloquent {

protected $fillable = array('lesson_id', 'user_id', 'text');

}