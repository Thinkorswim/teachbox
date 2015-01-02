<?php

class Lesson extends Eloquent {

protected $fillable = array('name', 'description', 'order');

     public function course() {
        return $this->belongsTo('Course');
    }
}
