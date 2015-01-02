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

	public function postCreate()
	{
		if (Auth::check()){
			$validator = Validator::make(Input::all(),
				array(
						'name' 				 => 'required|min:4|max:40',
				));

			if($validator->fails()){		
				return Redirect::action('CourseController@create')
						->withErrors($validator);
			}else{

				$name 	 = Input::get('name');

				$user_id = Auth::user()->id;
				$course = Course::create(array(
						'name' 		=> $name,
						'user_id'  => $user_id,
					));

				if($course){
					return Redirect::route('home')
							->with('global-positive', 'Your course is created.');

				}

					return Redirect::action('CourseController@create')
							->with('global-negative', 'Your profile settings could not be created.');
			}
	    }
	}
}

