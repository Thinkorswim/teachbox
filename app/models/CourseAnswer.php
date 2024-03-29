<?php

class CourseAnswer extends Eloquent {

protected $fillable = array('question_id', 'user_id', 'answer', 'course_id');

	 public function user() {
        return $this->belongsTo('User');
    }

     public function courseQuestion() {
        return $this->belongsTo('CourseQuestion');
    }

}
