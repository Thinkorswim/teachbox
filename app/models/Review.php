<?php

class Review extends Eloquent {
	protected $fillable = array('course_id', 'user_id', 'rating', 'text');


	 public function user() {
        return $this->belongsTo('User');
    }

     public function course() {
        return $this->belongsTo('Course');
    }
}
