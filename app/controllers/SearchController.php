<?php

class SearchController extends \BaseController {

	public function search($keyword){
		$countCourse = Course::where('approved', '=', '1')
		->where('name', 'LIKE',  '%' .$keyword. '%' )->count();
		$countUser = User::where('name', 'LIKE',  '%' .$keyword. '%' )->count();
		$courses = Course::where('approved', '=', '1')
		->where('name', 'LIKE',  '%' .$keyword. '%' )->paginate(5);
		
			return View::make('search.index')
					->with(array('courses' => $courses, 'keyword' => $keyword, 'countCourse' => $countCourse,'countUser' => $countUser));
	}
	public function searchFront(){
		$keyword = null;
		$countCourse = Course::where('approved', '=', '1')
		->where('name', 'LIKE',  '%' .$keyword. '%' )->count();
		$countUser = User::where('name', 'LIKE',  '%' .$keyword. '%' )->count();
		$courses = Course::where('approved', '=', '1')
		->where('name', 'LIKE',  '%' .$keyword. '%' )->paginate(5);
		
			return View::make('search.index')
					->with(array('courses' => $courses, 'keyword' => $keyword, 'countCourse' => $countCourse,'countUser' => $countUser));
	}
	public function searchUser($keyword){
		$countCourse = Course::where('approved', '=', '1')
		->where('name', 'LIKE',  '%' .$keyword. '%' )->count();
		$countUser = User::where('name', 'LIKE',  '%' .$keyword. '%' )->count();
		$users = User::where('name', 'LIKE',  '%' .$keyword. '%' )->paginate(5);
			return View::make('search.user-search')
					->with(array('users' => $users, 'keyword' => $keyword, 'countCourse' => $countCourse,'countUser' => $countUser));
	}
	public function postSearch(){

		$keyword = Input::get('keyword');

		
				return Redirect::action('SearchController@search', array('keyword' => $keyword));
		
		

	}

	public function autoComplete(){

			$term = Input::get('term');

			$data = Course::where('approved', '=', '1')
						->where('name', 'LIKE',  '%' .$term. '%' )->take(5)->get();
			$data_users = User::where('name', 'LIKE',  '%' .$term. '%' )->take(5)->get();
 			$result = [];

 			foreach ($data as $course) {
 				if(strpos(Str::lower($course->name), Str::lower($course->name)) !== false)
 				{
 					$iconCourse = ' /courses/'. $course->id . '/img/' . $course->pic;
 					$result[] = ['icon' => $iconCourse, 'value' => $course->name, 'course_id' => $course->id, 'isUser' => false,'classa'=>'course-item'];
 				}
 			}

 			foreach ($data_users as $user) {
 				if(strpos(Str::lower($user->name), Str::lower($user->name)) !== false)
 				{
 					$iconUser = ' /img/'. $user->id . '/' . $user->pic;
 					$result[] = ['icon' => $iconUser,'value' => $user->name, 'user_id' => $user->id, 'isUser' => true, 'classa'=>'user-item'];
 				}
 			}

 			return Response::json($result);

		}
}