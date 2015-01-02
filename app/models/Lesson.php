<?php

class Lesson extends Eloquent {

protected $fillable = array('name', 'description', 'order');
	 public function user() {
        return $this->belongsTo('User');
    }

     public function userCourse() {
        return $this->belongsTo('UserCourse');
    }
}
