<?php

class Course extends Eloquent {

	 public function user() {
        return $this->hasOne('User'); // this matches the Eloquent model
    }
}
