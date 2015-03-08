<?php

class SearchController extends \BaseController {

	public function search($keyword){

		$courses = Course::where('approved', '=', '1')
		->where('name', 'LIKE',  '%' .$keyword. '%' )->paginate(5);
		$timelineCount = count($timeline);
			return View::make('search.index')
					->with('courses' => $courses, 'keyword' => $keyword, 'timelineCount' => $timelineCount);
	}

	public function searchFront(){
		$keyword = ' ';
		$courses = Course::paginate(5);
		$timelineCount = count($timeline);
			return View::make('search.index')
					->with('courses' => $courses, 'keyword' => $keyword,'timelineCount' => $timelineCount);
	}


	public function postSearch(){

		$keyword = Input::get('keyword');

		if($keyword){
				return Redirect::action('SearchController@search', array('keyword' => $keyword));
		}else{
			return Redirect::action('SearchController@searchFront');
		}

	}

	public function autoComplete(){

			$term = Input::get('term');

			$data = Course::where('approved', '=', '1')
						->where('name', 'LIKE',  '%' .$term. '%' )->take(10)->get();
 			$result = [];

 			foreach ($data as $course) {
 				if(strpos(Str::lower($course->name), Str::lower($course->name)) !== false)
 				{
 					$result[] = ['value' => $course->name, 'course_id' => $course->id];
 				}
 			}

 			return Response::json($result);

		}
}