<?php

class Follow extends Eloquent {
	protected $fillable = array('follower_id', 'following_id');

	public function users() {
        return $this->belongsTo('User'); // this matches the Eloquent model
    }
}
