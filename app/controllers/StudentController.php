<?php

class StudentController extends \BaseController {


	public function courseStudents( $id ) {

		$course = Course::find( $id );
		$avgReview = DB::select( DB::raw( "SELECT AVG(reviews.rating) AS avgReview
			FROM reviews WHERE reviews.course_id = '$course->id'" ) );
		$avgReview = round( $avgReview[0]->avgReview );
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
				$result = DB::select( DB::raw( "SELECT COUNT(results.id) AS result
				FROM results
				JOIN lessons
				ON results.lesson_id = lessons.id
				JOIN courses
				ON lessons.course_id = courses.id
				WHERE results.user_id = '$student->user_id' AND courses.id =   '$id' " ) );
				$lessonsCount = Lesson::where( 'course_id', '=', $id )->count();
				$done = $result[0]->result;
				if ( $done != 0 ) {
					$donePercent = intval( $done/$lessonsCount*100 );
				}else {
					$donePercent = 0;
				}
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
			$rankingList[$m]->done = $donePercent;
			$m++;
		}
		$rankingList = array_values( array_sort( $rankingList, function( $value ) {
					return $value['avg'];
				} ) );
		$rankingList = array_reverse( $rankingList );
		$rankingList = array_slice( $rankingList, 0, 10 );

		$user = User::find( $course->user_id );
		$studentId = DB::table( 'user_courses' )
		->join( 'users', function( $join )  use ( $id ) {
				$join->on( 'user_courses.user_id', '=', 'users.id' )
				->where( 'course_id', '=', $id );
			} )->orderBy( 'users.name' )->get();
		$studentList = $studentId;

		if ( Auth::check() ) {
			$isJoined = UserCourse::where( function ( $query ) {
					$query->where( 'user_id', '=', Auth::user()->id );
				} )->where( function ( $query ) use ( $id ) {
					$query->where( 'course_id', '=', $id );
				} )->count();

			if ( $course->approved == 1 || $course->user_id == Auth::user()->id ) {
				return View::make( 'courses.students' )
				->with( array( 'course' => $course, 'isJoined' => $isJoined, 'user' => $user, 'studentCount' => $studentCount, 'studentList' => $studentList, 'avgReview' => $avgReview,
						'rankingList' => $rankingList ) );
			}else {
				return Redirect::route( 'course-page', array( 'id' => $id ) );
			}

		}else {
			return View::make( 'courses.students' )
			->with( array( 'course' => $course, 'user' => $user, 'studentCount' => $studentCount, 'studentList' => $studentList, 'avgReview' => $avgReview, 'rankingList' => $rankingList ) );
		}
	}

	public function postComment( $lesson_id, $user_id ) {
		$lesson = Lesson::find( $lesson_id );
		$course = Course::find( $lesson->course_id );
		if ( Input::has( 'comment' ) ) {
			$comment = Input::get( 'comment' );
			$message = nl2br( $comment );
			$comment = trim( $message );
			$comment_save = new Comment;
			$comment_save->lesson_id = $lesson->id;
			$comment_save->user_id = $user_id;
			$comment_save->text = $comment;
			$comment_save->save();
			return Redirect::route( 'course-lesson', array( 'id' => $course->id, 'order'=>$lesson->order ) );
		}else {
			return Redirect::route( 'course-lesson', array( 'id' => $course->id, 'order'=>$lesson->order ) )
			->withErrors( array( 'comment' => 'You have to write at least one character in the input field.' ) );
		}
	}

	public function postReply( $lesson_id, $user_id, $comment_id ) {
		$lesson = Lesson::find( $lesson_id );
		$course = Course::find( $lesson->course_id );
		if ( Input::has( 'comment' ) ) {
			$comment = Input::get( 'comment' );
			$message = nl2br( $comment );
			$comment = trim( $message );
			$comment_save = new CommentReply;
			$comment_save->comment_id = $comment_id;
			$comment_save->user_id = $user_id;
			$comment_save->text = $comment;
			$comment_save->save();
			return Redirect::route( 'course-lesson', array( 'id' => $course->id, 'order'=>$lesson->order ) );
		}else {
			return Redirect::route( 'course-lesson', array( 'id' => $course->id, 'order'=>$lesson->order ) )
			->withErrors( array( 'comment' => 'You have to write at least one character in the input field.' ) );
		}
	}

	public function commentVote() {
		if ( Auth::check() ) {
			$id = intval( Input::get( 'commentId' ) );
			$isReply = intval( Input::get( 'isReply' ) );
			$vote = Input::get( 'vote' );
			$user_id = Input::get( 'userId' );

			if ( $isReply ) {
				$reply = CommentReply::find( $id );
				if ( $vote ) {
					$reply->liked = intval( $reply->liked ) -1;
				}else {
					$reply->liked = intval( $reply->liked ) +1;
				}

				$reply->save();
			}else {
				$comment = Comment::find( $id );
				if ( $vote ) {
					$comment->liked = intval( $comment->liked ) -1;
				}else {
					$comment->liked = intval( $comment->liked ) +1;
				}

				$comment->save();
			}

			$message = CommentVote::create( array(
					'comment_id' => $id,
					'user_id'  => $user_id,
					'isReply' => $isReply
				) );

		}
	}

	public function courseReviews( $id ) {
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
		$students = UserCourse::where( 'course_id', '=', $id )->get();
		$avgArray = array();
		$rankingList = array();
		$m = 0;
		$doneArray = array();
		foreach ( $students as $student ) {
			$rankingList[] = User::find( $student->user_id );
				$result = DB::select( DB::raw( "SELECT COUNT(results.id) AS result
				FROM results
				JOIN lessons
				ON results.lesson_id = lessons.id
				JOIN courses
				ON lessons.course_id = courses.id
				WHERE results.user_id = '$student->user_id' AND courses.id =   '$id' " ) );
				$lessonsCount = Lesson::where( 'course_id', '=', $id )->count();
				$done = $result[0]->result;
				if ( $done != 0 ) {
					$donePercent = intval( $done/$lessonsCount*100 );
				}else {
					$donePercent = 0;
				}
				$doneArray[$m] = $donePercent;
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
			$rankingList[$m]->done =  $donePercent;
		
			$m++;
		}
		$rankingList = array_values( array_sort( $rankingList, function( $value ) {
					return $value['avg'];
				} ) );
		$rankingList = array_reverse( $rankingList );
		$rankingList = array_slice( $rankingList, 0, 10 );
		$avgReview = DB::select( DB::raw( "SELECT AVG(reviews.rating) AS avgReview
		FROM reviews WHERE reviews.course_id = '$course->id'" ) );
		$avgReview = round( $avgReview[0]->avgReview );
		$reviews = Review::where( 'course_id', '=', $course->id )->get();
		if(Auth::check()){
		$isJoined = UserCourse::where( function ( $query ) {
				$query->where( 'user_id', '=', Auth::user()->id );
			} )->where( function ( $query ) use ( $id ) {
				$query->where( 'course_id', '=', $id );
			} )->count();
			return View::make( 'courses.reviews' )
				->with( array( 'course' => $course, 'user' => $user, 'studentCount' => $studentCount, 'reviews' => $reviews, 'avgReview' => $avgReview,  'isJoined' => $isJoined, 'rankingList' => $rankingList,'doneArray'=>$doneArray ) );	
		}
		return View::make( 'courses.reviews' )
		->with( array( 'course' => $course, 'user' => $user, 'studentCount' => $studentCount, 'reviews' => $reviews, 'avgReview' => $avgReview, 'rankingList' => $rankingList,'doneArray'=>$doneArray ) );

	}

	public function postCourseReview( $id ) {
		if ( Auth::check() ) {
			$course = Course::find( $id );
			$user = User::find( $id );

			$isJoined = UserCourse::where( function ( $query ) {
					$query->where( 'user_id', '=', Auth::user()->id );
				} )->where( function ( $query ) use ( $id ) {
					$query->where( 'course_id', '=', $id );
				} )->count();

			$reviews = Review::where( 'course_id', '=', $course->id )->get();
			$validator = Validator::make( Input::all(),
				array(
					'comment'   => 'required|min:10|max:2048',
				) );

			if ( $validator->fails() ) {
				return Redirect::route( 'course-page', array( 'id' => $id ) )
				->withErrors( array( 'comment' => 'You have to write at least one character in the input field.' ) );
			}

			if ( Input::has( 'comment' ) && Input::has( 'rating' ) ) {
				$comment = Input::get( 'comment' );
				$rating = Input::get( 'rating' );
				$courseReview = Review::create( array(
						'text' => $comment,
						'rating'  => $rating,
						'course_id' => $id,
						'user_id' => Auth::user()->id,
					) );

				if ( $courseReview && $isJoined && ( $course->approved == 1 || $course->user_id == Auth::user()->id ) ) {
					return Redirect::route( 'course-page', array( 'id' => $id, 'reviews' => $reviews ) );
				}
			}

		}else {
			return View::make( 'home.before' );
		}
	}
}
