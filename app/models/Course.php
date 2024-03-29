<?php

class Course extends Eloquent {

protected $fillable = array('name', 'user_id', 'description', 'category');
	 public function user() {
        return $this->belongsTo('User');
    }

     public function userCourse() {
        return $this->belongsTo('UserCourse');
    }

    public function lesson() {
        return $this->hasMany('Lesson');
    }

     public function courseQuestion() {
        return $this->hasMany('CourseQuestion');
    }
}
