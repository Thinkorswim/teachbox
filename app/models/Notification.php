<?php

class Notification extends Eloquent {

	protected $fillable = array('user_id', 'type', 'event_id', 'seen');

}