<?php

use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\UserTrait;

class User extends Eloquent implements UserInterface, RemindableInterface {

	protected $fillable = array('email', 'name', 'password', 'password_temp', 'code', 'active', 'hide_email', 'pic');

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function getName() {
		return $this->name;
	}

	public function course() {
		return $this->hasMany('Course'); // this matches the Eloquent model
	}

	public function follow() {
		return $this->hasMany('Follow'); // this matches the Eloquent model
	}

	public function userCourse() {
		return $this->belongsTo('UserCourse');
	}

	public function courseQuestion() {
		return $this->hasMany('CourseQuestion');
	}

	public function courseAnswer() {
		return $this->hasMany('CourseAnswer');
	}

	public function results() {
		return $this->hasMany('Result');
	}
}
