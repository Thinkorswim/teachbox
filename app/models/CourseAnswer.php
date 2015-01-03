<?php

class CourseAnswer extends Eloquent {

protected $fillable = array('question', 'user_id', 'title', 'course_id');

	 public function user() {
        return $this->belongsTo('User');
    }

     public function courseQuestion() {
        return $this->belongsTo('CourseQuestion');
    }

}
