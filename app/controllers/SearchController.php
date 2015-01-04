<?php

class SearchController extends \BaseController {

	public function search(){

		return View::make('search.index');

	}

	public function postSearch(){

		$keyword = Input::get('keyword');
		$courses = Course::where('name', 'LIKE',  '%' .$keyword. '%' )->get();

		return View::make('search.index')
					->with('courses', $courses);

		/*foreach ($courses as $course) {
			var_dump($course->name);
		}*/
	}

}