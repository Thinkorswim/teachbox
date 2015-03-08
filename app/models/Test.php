<?php

class Test extends Eloquent {
	protected $fillable = array('lesson_id', 'question', 'choice_1', 'choice_2', 'choice_3', 'choice_4', 'answer');


	public function lessons() {
        return $this->belongsTo('Lesson');
    }

}
