<?php

class Course extends Eloquent {

protected $fillable = array('name', 'user_id', 'description');
	 public function user() {
        return $this->belongsTo('User');
    }

     public function userCourse() {
        return $this->belongsTo('UserCourse');
    }

    public function lesson() {
        return $this->hasMany('Lesson'); // this matches the Eloquent model
    }

     public function courseQuestion() {
        return $this->hasMany('CourseQuestion');
    }
}
