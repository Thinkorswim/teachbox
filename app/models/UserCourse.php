<?php

class UserCourse extends Eloquent {

	public function user() {
        return $this->hasMany('User');
    }
    public function course() {
        return $this->hasMany('Course');
    }
}
}
