<?php

class CourseQuestion extends Eloquent {

protected $fillable = array('question', 'user_id', 'title', 'course_id');

	 public function user() {
        return $this->belongsTo('User');
    }

     public function course() {
        return $this->belongsTo('Course');
    }

}
