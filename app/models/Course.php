<?php

class Course extends Eloquent {

	 public function user() {
        return $this->belongsTo('User');
    }

     public function userCourse() {
        return $this->belongsTo('UserCourse');
    }
}
