<?php

class DiscussionController extends \BaseController {

	public function courseQuestion( $id ) {
			$course = Course::find( $id );
			$user = User::find( $course->user_id );
			$studentCount = UserCourse::where( 'course_id', '=', $id )->count();
			$studentCount = $studentCount - 1;
			if ( $studentCount > 999 ) {
				$thousand = substr( $studentCount, 0, 1 );
				$hundred = substr( $studentCount, 1, 1 );
				$studentCount = $thousand . '.'. $hundred . 'k';
			}
			elseif ( $studentCount > 999999 ) {
				$million = substr( $studentCount, 0, 1 );
				$thousand = substr( $studentCount, 1, 1 );
				$studentCount = $million . '.'. $thousand . 'm';
			}
			$avgReview = DB::select( DB::raw( "SELECT AVG(reviews.rating) AS avgReview
			FROM reviews WHERE reviews.course_id = '$course->id'" ) );
			$avgReview = round( $avgReview[0]->avgReview );
			$students = UserCourse::where( 'course_id', '=', $id )->get();
			$avgArray = array();
			$rankingList = array();
			$m = 0;
			foreach ( $students as $student ) {
				$rankingList[] = User::find( $student->user_id );
				$avg = DB::select( DB::raw( "SELECT AVG(results.right/results.total * 100) AS avg
				FROM results
				JOIN lessons
				ON results.lesson_id = lessons.id
				JOIN courses
				ON lessons.course_id = courses.id
				WHERE results.user_id = '$student->user_id' AND courses.id =  '$id'" ) );
				$avg = $avg[0]->avg;
				$avg = intval( $avg );
				$avgArray[$m] = $avg;
				$rankingList[$m]->avg = $avg;
				$m++;
			}
			$rankingList = array_values( array_sort( $rankingList, function( $value ) {
						return $value['avg'];
					} ) );
			$rankingList = array_reverse( $rankingList );
			$rankingList = array_slice( $rankingList, 0, 10 );
			$questionList = CourseQuestion::where( 'course_id', '=', $id )->get();
			if(Auth::check()){
			$isJoined = UserCourse::where( function ( $query ) {
					$query->where( 'user_id', '=', Auth::user()->id );
				} )->where( function ( $query ) use ( $id ) {
					$query->where( 'course_id', '=', $id );
				} )->count();
				return View::make( 'courses.question' )
					->with( array( 'course' => $course, 'user' => $user, 'studentCount' => $studentCount, 'questionList' => $questionList, 'avgReview'=> $avgReview, 'rankingList'=>$rankingList, 'isJoined' => $isJoined ) );
			}
			if ( (( $course->approved == 1 || $course->user_id == Auth::user()->id ) ) || Auth::user()->admin = 1 ) {
				return View::make( 'courses.question' )
				->with( array( 'course' => $course, 'user' => $user, 'studentCount' => $studentCount, 'questionList' => $questionList, 'avgReview'=> $avgReview, 'rankingList'=>$rankingList ) );
			}else {
				return Redirect::route( 'course-page', array( 'id' => $id ) );
			}
	}

	public function postCourseQuestion( $id ) {
		if ( Auth::check() ) {
			$course = Course::find( $id );
			$studentCount = UserCourse::where( 'course_id', '=', $id )->count();
			$studentCount = $studentCount - 1;
			if ( $studentCount > 999 ) {
				$thousand = substr( $studentCount, 0, 1 );
				$hundred = substr( $studentCount, 1, 1 );
				$studentCount = $thousand . '.'. $hundred . 'k';
			}
			elseif ( $studentCount > 999999 ) {
				$million = substr( $studentCount, 0, 1 );
				$thousand = substr( $studentCount, 1, 1 );
				$studentCount = $million . '.'. $thousand . 'm';
			}

			$isJoined = UserCourse::where( function ( $query ) {
					$query->where( 'user_id', '=', Auth::user()->id );
				} )->where( function ( $query ) use ( $id ) {
					$query->where( 'course_id', '=', $id );
				} )->count();

			$user = User::find( $course->user_id );
			$questionList = CourseQuestion::where( 'course_id', '=', $id );

			$validator = Validator::make( Input::all(),
				array(
					'title'     => 'required|min:4|max:64',
					'question'   => 'required|min:10|max:1024',
				) );

			if ( $validator->fails() ) {
				return Redirect::route( 'course-question', array( 'id' => $id ) )
				->withErrors( $validator );
			}else {

				$title   = Input::get( 'title' );
				$question = Input::get( 'question' );

				$message = nl2br( $question );
				$question = trim( $message );

				$courseQuestion = CourseQuestion::create( array(
						'title' => $title,
						'question'  => $question,
						'course_id' => $id,
						'user_id' => Auth::user()->id,
					) );

				if ( $courseQuestion && $isJoined && ( $course->approved == 1 || $course->user_id == Auth::user()->id ) ) {

					return Redirect::route( 'course-answers', array( 'id' => $id, 'question' => $courseQuestion->id ) );

					//return View::make('courses.question')
					//  ->with(array('course' => $course, 'user' => $user, 'studentCount' => $studentCount, 'questionList' => $questionList ));
				}else {
					return Redirect::route( 'course-page', array( 'id' => $id ) );
				}
			}
		}else {
			return View::make( 'home.before' );
		}
	}



	public function courseAnswer( $id, $question ) {
		if ( Auth::check() ) {
			$course = Course::find( $id );
			$avgReview = DB::select( DB::raw( "SELECT AVG(reviews.rating) AS avgReview
			FROM reviews WHERE reviews.course_id = '$course->id'" ) );
			$avgReview = round( $avgReview[0]->avgReview );
			$isJoined = UserCourse::where( function ( $query ) {
					$query->where( 'user_id', '=', Auth::user()->id );
				} )->where( function ( $query ) use ( $id ) {
					$query->where( 'course_id', '=', $id );
				} )->count();
			$studentCount = UserCourse::where( 'course_id', '=', $id )->count();
			$studentCount = $studentCount - 1;
			if ( $studentCount > 999 ) {
				$thousand = substr( $studentCount, 0, 1 );
				$hundred = substr( $studentCount, 1, 1 );
				$studentCount = $thousand . '.'. $hundred . 'k';
			}
			elseif ( $studentCount > 999999 ) {
				$million = substr( $studentCount, 0, 1 );
				$thousand = substr( $studentCount, 1, 1 );
				$studentCount = $million . '.'. $thousand . 'm';
			}
			$students = UserCourse::where( 'course_id', '=', $id )->get();
			$avgArray = array();
			$rankingList = array();
			$m = 0;
			foreach ( $students as $student ) {
				$rankingList[] = User::find( $student->user_id );
				$avg = DB::select( DB::raw( "SELECT AVG(results.right/results.total * 100) AS avg
				FROM results
				JOIN lessons
				ON results.lesson_id = lessons.id
				JOIN courses
				ON lessons.course_id = courses.id
				WHERE results.user_id = '$student->user_id' AND courses.id =  '$id'" ) );
				$avg = $avg[0]->avg;
				$avg = intval( $avg );
				$avgArray[$m] = $avg;
				$rankingList[$m]->avg = $avg;
				$m++;
			}
			$rankingList = array_values( array_sort( $rankingList, function( $value ) {
						return $value['avg'];
					} ) );
			$rankingList = array_reverse( $rankingList );
			$rankingList = array_slice( $rankingList, 0, 10 );

			$isJoined = UserCourse::where( function ( $query ) {
					$query->where( 'user_id', '=', Auth::user()->id );
				} )->where( function ( $query ) use ( $id ) {
					$query->where( 'course_id', '=', $id );
				} )->count();

			$user = User::find( $course->user_id );
			$question = CourseQuestion::where( 'id', '=', $question )->first();
			$answerList = CourseAnswer::where( 'question_id', '=', $question->id )->get();


			if ( Auth::check() && ( $course->approved == 1 || $course->user_id == Auth::user()->id ) ) {
				return View::make( 'courses.answer' )
				->with( array( 'course' => $course, 'user' => $user, 'studentCount' => $studentCount, 'question' => $question, 'answerList' => $answerList, 'avgReview' => $avgReview, 'rankingList'=>$rankingList, 'isJoined' => $isJoined ) );
			}else {
				return Redirect::route( 'course-page', array( 'id' => $id ) );
			}

		}else {
			return View::make( 'home.before' );
		}
	}

	public function postCourseAnswer( $id, $question ) {
		if ( Auth::check() ) {
			$course = Course::find( $id );
			$studentCount = UserCourse::where( 'course_id', '=', $id )->count();
			$studentCount = $studentCount - 1;
			if ( $studentCount > 999 ) {
				$thousand = substr( $studentCount, 0, 1 );
				$hundred = substr( $studentCount, 1, 1 );
				$studentCount = $thousand . '.'. $hundred . 'k';
			}
			elseif ( $studentCount > 999999 ) {
				$million = substr( $studentCount, 0, 1 );
				$thousand = substr( $studentCount, 1, 1 );
				$studentCount = $million . '.'. $thousand . 'm';
			}

			$isJoined = UserCourse::where( function ( $query ) {
					$query->where( 'user_id', '=', Auth::user()->id );
				} )->where( function ( $query ) use ( $id ) {
					$query->where( 'course_id', '=', $id );
				} )->count();


			$user = User::find( $course->user_id );

			$validator = Validator::make( Input::all(),
				array(
					'answer'   => 'required|min:10|max:1024',
				) );

			if ( $validator->fails() ) {
				return Redirect::route( 'course-answers', array( 'id' => $id, 'question' => $question ) )
				->withErrors( $validator );
			}else {

				$answer = Input::get( 'answer' );

				$message = nl2br( $answer );
				$answer = trim( $message );

				$courseAnswer = CourseAnswer::create( array(
						'answer' => $answer,
						'question_id'  => $question,
						'course_id' => $id,
						'user_id' => Auth::user()->id,
					) );

				if ( $courseAnswer && $isJoined && ( $course->approved == 1 || $course->user_id == Auth::user()->id ) ) {
					return Redirect::route( 'course-answers', array( 'id' => $id, 'question' => $question ) );
				}else {
					return Redirect::route( 'course-page', array( 'id' => $id ) );
				}
			}
		}else {
			return View::make( 'home.before' );
		}
	}
}
