<?php

class Course extends Eloquent {

protected $fillable = array('name');
	 public function user() {
        return $this->belongsTo('User');
    }

     public function userCourse() {
        return $this->belongsTo('UserCourse');
    }
}
