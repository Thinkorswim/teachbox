<?php

class CourseController extends \BaseController {

	public function create() {
		if ( Auth::check() ) {
			$categories = array( "Business", "IT & Software", "Personal Development", "Art",  "Marketing",  "Design", "Lifestyle",
				"Health & Fitness", "Languages", "Teacher Training", "Music", "Academics", "Photography" );
			return View::make( 'courses.create' )->with( array( 'categories' => $categories ) );
		}else {
			return View::make( 'home.before' );
		}
	}

	public function explore() {

		$countCourse = Course::where( 'approved', '=', '1' )->count();
		$courses = Course::where( 'approved', '=', '1' )->paginate( 5 );

		return View::make( 'courses.explore' )
		->with( array( 'courses' => $courses, 'countCourse' => $countCourse ) );

	}

	public function postCreate() {

		if ( Auth::check() ) {
			$categories = array( "Business", "IT & Software", "Personal Development", "Art",  "Marketing",  "Design", "Lifestyle",
				"Health & Fitness", "Languages", "Teacher Training", "Music", "Academics", "Photography" );
			if ( Input::hasFile( 'image' ) && ( Input::file( 'image' )->getClientOriginalExtension() == "jpg" || Input::file( 'image' )->getClientOriginalExtension() == "png" ) ) {

				$file_max = 4000000;
				$image = Input::file( 'image' );
				$size = $image->getSize();

				if ( $size >= $file_max ) {
					return Redirect::action( 'CourseController@create' )
					->withErrors( array( 'pic' => 'The file size is larger than 4mb.' ) );

				}

				$validator = Validator::make( Input::all(),
					array(
						'name'      => 'required|min:4|max:128',
						'description'   => 'required|min:30|max:4096',
					) );

				if ( $validator->fails() ) {
					return Redirect::action( 'CourseController@create' )
					->withErrors( $validator );
				}else {
					$symbols = array( "+", "!", "@",  "$",  "^", "&", "*" );
					$replace = array( "", "", "",  "",  "", "", "" );
					$newImage = Image::make( $image->getRealPath() );
					$newImage1 = Image::make( $image->getRealPath() );
					$filename = $image->getClientOriginalName();
					$filename  =  str_replace( $symbols, $replace, $filename );
					$ratio = 1;
					$ratio1 = 3/2;
					$width = $newImage->width();
					$newImage->fit( $width, intval( $width / $ratio ) );
					$newImage1->fit( $width, intval( $width / $ratio1 ) );


					$name   = Input::get( 'name' );
					$description = Input::get( 'description' );

					$message = nl2br( $description );
					$description = trim( $message );

					$category_id =  Input::get( 'category' );
					$category = $categories[$category_id];
					$user_id = Auth::user()->id;
					$course = Course::create( array(
							'name'   => $name,
							'user_id'  => $user_id,
							'description' => $description,
							'category' => $category
						) );

					if ( $course ) {
						$resultMake  = File::makeDirectory( public_path() .'/courses/' . $course->id );
						$resultMake  = File::makeDirectory( public_path() .'/courses/' . $course->id . '/img/' );
						if ( $newImage->save( public_path( '/courses/' . $course->id . '/img/' . $filename ) ) && $newImage1->save( public_path( '/courses/' . $course->id . '/img/'. '/3x2' . $filename ) ) ) {
							$course->pic    = $filename;
							$course->save();
						}
						$user_id = Auth::user()->id;
						$user = User::find( $user_id );
						$userCourse = UserCourse::create( array(
								'course_id' => $course->id,
								'user_id'  => $user_id,
							) );
						if ( $userCourse ) {
							Mail::send( 'emails.auth.course-new', array( 'course' => $course, 'user' => $user ), function( $message_new ) use ( $user ) {
									$message_new->to( $user->email , $user->name )->subject( 'Your new course in Teachbox' );
								} );
							return Redirect::route( 'course-page', array( 'id' => $course->id ) );

						}else {
							return Redirect::route( 'course-page', array( 'id' => $course->id ) )
							->with( 'global-negative', 'You could not create this course.' );
						}

						return View::make( 'courses.join' )
						->with( 'course', $course );

					}

					return Redirect::action( 'CourseController@create' )
					->with( 'global-negative', 'Your course could not be created.' );
				}


			}else {
				return Redirect::action( 'CourseController@create' )
				->withErrors( array( 'pic' => 'You have not selected a picture or it has a wrong extension.' ) );
			}

		}
	}

	public function course( $id ) {
		function orderBy( $data, $field ) {
			$code = "return strnatcmp(\$a['$field'], \$b['$field']);";
			usort( $data, create_function( '$a,$b', $code ) );
			return $data;
		}
		$course = Course::find( $id );
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
		$reviews = Review::where( 'course_id', '=', $course->id )->orderBy( 'created_at', 'DESC' )->take( 3 )->get();
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
		if ( Auth::check() ) {
			$isJoined = UserCourse::where( function ( $query ) {
					$query->where( 'user_id', '=', Auth::user()->id );
				} )->where( function ( $query ) use ( $id ) {
					$query->where( 'course_id', '=', $id );
				} )->count();
		}
		if ( $course->approved == 1 || $course->user_id == Auth::user()->id || Auth::user()->admin == 1 ) {


			if ( ( Auth::check() && $course->user_id == Auth::user()->id ) || ( Auth::check() && Auth::user()->admin == 1 ) ) {
				$lessonList = Lesson::where( 'course_id', '=', $id )->get();
			}else {
				$lessonList = Lesson::where( 'course_id', '=', $id )->where( 'approved', '=', 1 )->get();
			}

			$user = User::find( $course->user_id );

			if ( Auth::check() ) {
				if ( Auth::user()->admin == 1 ) {
					return View::make( 'courses.join' )
					->with( array( 'course' => $course, 'reviews' => $reviews, 'lessonList' => $lessonList, 'user' => $user, 'studentCount' => $studentCount, 'avgReview'=>$avgReview, 'isJoined'=>$isJoined, 'rankingList'=>$rankingList ) );

				}else {
					return View::make( 'courses.join' )
					->with( array( 'course' => $course, 'reviews' => $reviews, 'lessonList' => $lessonList, 'user' => $user, 'studentCount' => $studentCount, 'avgReview'=>$avgReview, 'isJoined'=>$isJoined, 'rankingList'=>$rankingList  ) );
				}
			}else {
				return View::make( 'courses.not_join' )
				->with( array( 'course' => $course, 'reviews' => $reviews, 'lessonList' => $lessonList, 'user' => $user, 'studentCount' => $studentCount, 'avgReview'=>$avgReview, 'rankingList'=>$rankingList  ) );
			}
		}else {
			return Redirect::route( 'home' );
		}
	}

	public function postJoin( $id ) {
		$course = Course::find( $id );
		if ( Auth::check() && $course->approved == 1 ) {

			$user_id = Auth::user()->id;
			$userCourse = UserCourse::create( array(
					'course_id' => $id,
					'user_id'  => $user_id,
				) );
			if ( $userCourse ) {
				return Redirect::route( 'course-page', array( 'id' => $id ) );
			}else {
				return Redirect::route( 'course-page', array( 'id' => $id ) )
				->with( 'global-negative', 'You could not join this course.' );
			}
		}else {
			return View::make( 'home.before' );
		}
	}

	public function courseEdit( $id ) {
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
		
		$avgReview = DB::select( DB::raw( "SELECT AVG(reviews.rating) AS avgReview
		FROM reviews WHERE reviews.course_id = '$course->id'" ) );
		$avgReview = round( $avgReview[0]->avgReview );

		if ( Auth::check() && ( $course->approved == 1 || $course->user_id == Auth::user()->id ) ) {
			if ( Auth::user()->id==$course->user_id ) {

				$user = User::find( $course->user_id );
				return View::make( 'courses.edit' )
				->with( array( 'course' => $course, 'user' => $user, 'studentCount' => $studentCount, 'avgReview' => $avgReview ) );
			}else {
				return Redirect::route( 'course-page', array( 'id' => $id ) );
			}

		}else {
			return View::make( 'home.before' );
		}
	}

	public function postCourseEdit( $id ) {
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

		if ( Auth::check() && ( $course->approved == 1 || $course->user_id == Auth::user()->id ) && $course->user_id == Auth::user()->id ) {
			$validator = Validator::make( Input::all(),
				array(
					'description'     => 'min:30|max:4096',
				) );

			if ( $validator->fails() ) {
				return Redirect::action( 'CourseController@courseEdit', [$id] )
				->withErrors( $validator );

			}else {
				$courseEdit = Course::find( $id );

				$description = Input::get( 'description' );
				if ( Input::hasFile( 'image' ) && ( Input::file( 'image' )->getClientOriginalExtension() == "jpg" || Input::file( 'image' )->getClientOriginalExtension() == "png" ) ) {


					$file_max = 4000000;

					$image = Input::file( 'image' );
					$size = $image->getSize();

					if ( $size >= $file_max ) {
						return Redirect::action( 'CourseController@courseEdit', [$id] )
						->withErrors( array( 'pic' => 'The file size is larger than 4mb.' ) );

					}

					$symbols = array( "+", "!", "@",  "$",  "^", "&", "*" );
					$replace = array( "", "", "",  "",  "", "", "" );
					$newImage = Image::make( $image->getRealPath() );
					$newImage1 = Image::make( $image->getRealPath() );
					$filename = $image->getClientOriginalName();
					$filename  =  str_replace( $symbols, $replace, $filename );
					$ratio = 1;
					$ratio1 = 3/2;
					$width = $newImage->width();
					$newImage->fit( $width, intval( $width / $ratio ) );
					$newImage1->fit( $width, intval( $width / $ratio1 ) );

					$pathImg = public_path().'/courses/'. $course->id . '/img/';

					$success = File::cleanDirectory( $pathImg );

					if ( $newImage->save( public_path( '/courses/' . $courseEdit->id . '/img/' . $filename ) ) && $newImage1->save( public_path( '/courses/' . $course->id . '/img/'. '/3x2' . $filename ) ) ) {
						$courseEdit->pic    = $filename;
					}
				}

				$message = nl2br( $description );
				$description = trim( $message );

				$courseEdit->description = $description;

				if ( $courseEdit->save() ) {
					return Redirect::route( 'course-page', array( 'id' => $id ) );
				}
			}

			return Redirect::action( 'CourseController@courseEdit', [$id] )
			->with( 'global-negative', 'Your course settings could not be changed.' );
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
		$isJoined = UserCourse::where( function ( $query ) {
				$query->where( 'user_id', '=', Auth::user()->id );
			} )->where( function ( $query ) use ( $id ) {
				$query->where( 'course_id', '=', $id );
			} )->count();
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
		$avgReview = DB::select( DB::raw( "SELECT AVG(reviews.rating) AS avgReview
		FROM reviews WHERE reviews.course_id = '$course->id'" ) );
		$avgReview = round( $avgReview[0]->avgReview );
		$reviews = Review::where( 'course_id', '=', $course->id )->get();

		return View::make( 'courses.reviews' )
		->with( array( 'course' => $course, 'user' => $user, 'studentCount' => $studentCount, 'reviews' => $reviews, 'avgReview' => $avgReview,  'isJoined' => $isJoined, 'rankingList' => $rankingList ) );

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
