<?php

class Lesson extends Eloquent {

protected $fillable = array('name', 'description', 'order', 'filepath', 'course_id', 'duration');

     public function course() {
        return $this->belongsTo('Course');
    }

     public function results() {
        return $this->hasMany('Result');
    }

    public function tests() {
        return $this->hasMany('Test');
    }
}
