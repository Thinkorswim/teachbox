<?php

class UserCourse extends Eloquent {
	protected $fillable = array('course_id', 'user_id');

	public function user() {
        return $this->hasMany('User');
    }
    public function course() {
        return $this->hasMany('Course');
    }
}
