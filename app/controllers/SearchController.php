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

	public function autoComplete(){

			$term = Input::get('term');

			$data = Course::where('name', 'LIKE',  '%' .$term. '%' )->take(10)->get();
 			$result = [];

 			foreach ($data as $course) {
 				if(strpos(Str::lower($course->name), $term) !== false)
 				{
 					$result[] = ['value' => $course->name];
 				}
 			}

 			return Response::json($result);

		}
}