<?php

class CourseController extends \BaseController {

	public function create ()
	{
		if(Auth::check()){
			return View::make('courses.create');
		}else{
			return View::make('home.before');
		}
	}

	public function postCreate ()
	{
		/*if (Auth::check()){
			$validator = Validator.
		}*/
	}


}
