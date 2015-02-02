<?php

class Message extends Eloquent {
	protected $fillable = array('sender_id', 'recipient_id', 'message', 'seen_sender', 'seen_recipient');

}
