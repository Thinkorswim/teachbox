<?php

class SearchController extends \BaseController {

	public function search( $keyword ) {
		$countCourse = Course::where( 'approved', '=', '1' )
		->where( 'name', 'LIKE',  '%' .$keyword. '%' )->count();
		$countUser = User::where( 'name', 'LIKE',  '%' .$keyword. '%' )->count();
		$countLesson = Lesson::where( 'approved', '=', '1' )->where( 'name', 'LIKE',  '%' .$keyword. '%' )->count();
		$courses = Course::where( 'approved', '=', '1' )
		->where( 'name', 'LIKE',  '%' .$keyword. '%' )->paginate( 5 );

		return View::make( 'search.index' )
		->with( array( 'courses' => $courses, 'keyword' => $keyword, 'countCourse' => $countCourse, 'countUser' => $countUser, 'countLesson'=>$countLesson ) );
	}
	public function searchFront() {
		$keyword = null;
		$countCourse = Course::where( 'approved', '=', '1' )
		->where( 'name', 'LIKE',  '%' .$keyword. '%' )->count();
		$countUser = User::where( 'name', 'LIKE',  '%' .$keyword. '%' )->count();
		$countLesson = Lesson::where( 'approved', '=', '1' )->where( 'name', 'LIKE',  '%' .$keyword. '%' )->count();
		$courses = Course::where( 'approved', '=', '1' )
		->where( 'name', 'LIKE',  '%' .$keyword. '%' )->paginate( 5 );

		return View::make( 'search.index' )
		->with( array( 'courses' => $courses, 'keyword' => $keyword, 'countCourse' => $countCourse, 'countUser' => $countUser , 'countLesson'=>$countLesson) );
	}
	public function searchUser( $keyword ) {
		$countCourse = Course::where( 'approved', '=', '1' )
		->where( 'name', 'LIKE',  '%' .$keyword. '%' )->count();
		$countUser = User::where( 'name', 'LIKE',  '%' .$keyword. '%' )->count();
		$countLesson = Lesson::where( 'approved', '=', '1' )->where( 'name', 'LIKE',  '%' .$keyword. '%' )->count();
		$users = User::where( 'name', 'LIKE',  '%' .$keyword. '%' )->paginate( 10 );
		return View::make( 'search.user-search' )
		->with( array( 'users' => $users, 'keyword' => $keyword, 'countCourse' => $countCourse, 'countUser' => $countUser, 'countLesson'=>$countLesson ) );
	}
	public function searchLesson( $keyword ) {
		$countCourse = Course::where( 'approved', '=', '1' )
		->where( 'name', 'LIKE',  '%' .$keyword. '%' )->count();
		$countUser = User::where( 'name', 'LIKE',  '%' .$keyword. '%' )->count();
		$countLesson = Lesson::where( 'approved', '=', '1' )->where( 'name', 'LIKE',  '%' .$keyword. '%' )->count();
		$lessons = Lesson::where( 'approved', '=', '1' )->where( 'name', 'LIKE',  '%' .$keyword. '%' )->paginate( 10 );
		return View::make( 'search.lesson-search' )
		->with( array( 'lessons' => $lessons, 'keyword' => $keyword, 'countCourse' => $countCourse, 'countUser' => $countUser, 'countLesson'=>$countLesson ) );
	}
	public function postSearch() {

		$keyword = Input::get( 'keyword' );


		return Redirect::action( 'SearchController@search', array( 'keyword' => $keyword ) );



	}

	public function autoComplete() {

		$term = Input::get( 'term' );

		$data = Course::where( 'approved', '=', '1' )
		->where( 'name', 'LIKE',  '%' .$term. '%' )->take( 3 )->get();
		$data_users = User::where( 'name', 'LIKE',  '%' .$term. '%' )->take( 3 )->get();
		$data_lesson = Lesson::where( 'approved', '=', '1' )
		->where( 'name', 'LIKE',  '%' .$term. '%' )->take( 3 )->get();
		$result = [];

		foreach ( $data_lesson as $lesson ) {
			if ( strpos( Str::lower( $lesson->name ), Str::lower( $lesson->name ) ) !== false ) {
				$iconCourse = 'courses/' . $lesson->course_id . '/' . $lesson->order . '/thumb100x100.png';
				$course = Course::find( $lesson->course_id );
				$result[] = ['icon' => $iconCourse, 'value' => $lesson->name, 'lesson_order' => $lesson->order, 'course_id' => $lesson->course_id,
				'isUser' => false, 'isLesson' => true, 'classa'=>'lesson-item'];

			}
		}

		foreach ( $data as $course ) {
			if ( strpos( Str::lower( $course->name ), Str::lower( $course->name ) ) !== false ) {
				$iconCourse = ' /courses/'. $course->id . '/img/' . $course->pic;
				$result[] = ['icon' => $iconCourse, 'value' => $course->name, 'course_id' => $course->id, 'isUser' => false, 'classa'=>'course-item', 'isLesson' => false];
			}
		}

		foreach ( $data_users as $user ) {
			if ( strpos( Str::lower( $user->name ), Str::lower( $user->name ) ) !== false ) {
				$iconUser = ' /img/'. $user->id . '/' . $user->pic;
				$result[] = ['icon' => $iconUser, 'value' => $user->name, 'user_id' => $user->id, 'isUser' => true, 'classa'=>'user-item', 'isLesson' => false];
			}
		}

		return Response::json( $result );

	}

	public function autoCompleteFrontPage() {

		$term = Input::get( 'term' );

		$data = Course::where( 'approved', '=', '1' )
		->where( 'name', 'LIKE',  '%' .$term. '%' )->take( 5 )->get();
		$result = [];

		foreach ( $data as $course ) {
			if ( strpos( Str::lower( $course->name ), Str::lower( $course->name ) ) !== false ) {
				$iconCourse = ' /courses/'. $course->id . '/img/' . $course->pic;
				$result[] = ['icon' => $iconCourse, 'value' => $course->name, 'course_id' => $course->id, 'isUser' => false, 'classa'=>'course-item'];
			}
		}
		return Response::json( $result );

	}
}
