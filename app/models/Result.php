<?php

class Test extends Eloquent {
	protected $fillable = array('lesson_id', 'user_id', 'total', 'right');


	public function users() {
        return $this->belongsTo('User');
    }

    public function lessons() {
        return $this->belongsTo('Lesson');
    }
}
