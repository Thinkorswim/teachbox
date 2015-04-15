<?php

class CourseController extends \BaseController {

	public function create() {
		if (Auth::check()) {
			$categories = array("Business", "IT & Software", "Personal Development", "Art", "Marketing", "Design", "Lifestyle",
				"Health & Fitness", "Languages", "Teacher Training", "Music", "Academics", "Photography");
			return View::make('courses.create')->with(array('categories' => $categories));
		} else {
			return View::make('home.before');
		}
	}

	public function explore() {
		$all = DB::select(DB::raw("SELECT DISTINCT `category` FROM `courses`  AS category"));
		$avgReviews = array();
		$countCourse = Course::where('approved', '=', '1')->count();
		$courses = Course::where('approved', '=', '1')->get();
		$reviewCounts = array();
		foreach ($courses as $course) {
			$avgReview = DB::select(DB::raw("SELECT AVG(reviews.rating) AS avgReview
			FROM reviews WHERE reviews.course_id = '$course->id'"));
			$avgReview = round($avgReview[0]->avgReview);
			$avgReviews[] = $avgReview;
			$reviewCount = DB::select(DB::raw("SELECT COUNT(reviews.rating) AS reviewCount
			FROM reviews WHERE reviews.course_id = '$course->id'"));
			$reviewCount = $reviewCount[0]->reviewCount;
			$reviewCounts[] = $reviewCount;
		}

		return View::make('courses.explore')
			->with(array('courses' => $courses, 'all' => $all, 'countCourse' => $countCourse, 'avgReviews' => $avgReviews, 'reviewCounts' => $reviewCounts));

	}
	public function category($category) {
		$all = DB::select(DB::raw("SELECT DISTINCT `category` FROM `courses` AS category"));
		$courses = Course::where('approved', '=', '1')->where('category', '=', $category)->get();
		$countCourse = Course::where('approved', '=', '1')->where('category', '=', $category)->count();
		$avgReviews = array();
		$reviewCounts = array();
		foreach ($courses as $course) {
			$avgReview = DB::select(DB::raw("SELECT AVG(reviews.rating) AS avgReview
			FROM reviews WHERE reviews.course_id = '$course->id'"));
			$reviewCount = DB::select(DB::raw("SELECT COUNT(reviews.rating) AS reviewCount
			FROM reviews WHERE reviews.course_id = '$course->id'"));
			$avgReview = round($avgReview[0]->avgReview);
			$reviewCount = $reviewCount[0]->reviewCount;
			$avgReviews[] = $avgReview;
			$reviewCounts[] = $reviewCount;
		}

		return View::make('courses.category')
			->with(array('courses' => $courses, 'category' => $category, 'all' => $all, 'countCourse' => $countCourse, 'avgReviews' => $avgReviews, 'reviewCounts' => $reviewCounts));
	}
	public function postCreate() {

		if (Auth::check()) {
			$categories = array("Business", "IT & Software", "Personal Development", "Art", "Marketing", "Design", "Lifestyle",
				"Health & Fitness", "Languages", "Teacher Training", "Music", "Academics", "Photography");
			if (Input::hasFile('image') && (Input::file('image')->getClientOriginalExtension() == "jpg" || Input::file('image')->getClientOriginalExtension() == "png")) {

				$file_max = 4000000;
				$image = Input::file('image');
				$size = $image->getSize();

				if ($size >= $file_max) {
					return Redirect::action('CourseController@create')
						->withErrors(array('pic' => 'The file size is larger than 4mb.'));

				}

				$validator = Validator::make(Input::all(),
					array(
						'name' => 'required|min:4|max:128',
						'description' => 'required|min:30|max:4096',
					));

				if ($validator->fails()) {
					return Redirect::action('CourseController@create')
						->withErrors($validator);
				} else {
					$symbols = array("+", "!", "@", "$", "^", "&", "*");
					$replace = array("", "", "", "", "", "", "");
					$newImage = Image::make($image->getRealPath());
					$newImage1 = Image::make($image->getRealPath());
					$filename = $image->getClientOriginalName();
					$filename = str_replace($symbols, $replace, $filename);
					$ratio = 1;
					$ratio1 = 3 / 2;
					$width = $newImage->width();
					$newImage->fit($width, intval($width / $ratio));
					$newImage1->fit($width, intval($width / $ratio1));

					$name = Input::get('name');
					$description = Input::get('description');

					$message = nl2br($description);
					$description = trim($message);

					$category_id = Input::get('category');
					$category = $categories[$category_id];
					$user_id = Auth::user()->id;
					$course = Course::create(array(
						'name' => $name,
						'user_id' => $user_id,
						'description' => $description,
						'category' => $category,
					));

					if ($course) {
						$resultMake = File::makeDirectory(public_path() . '/courses/' . $course->id);
						$resultMake = File::makeDirectory(public_path() . '/courses/' . $course->id . '/img/');
						if ($newImage->save(public_path('/courses/' . $course->id . '/img/' . $filename)) && $newImage1->save(public_path('/courses/' . $course->id . '/img/' . '/3x2' . $filename))) {
							$course->pic = $filename;
							$course->save();
						}
						$user_id = Auth::user()->id;
						$user = User::find($user_id);
						$userCourse = UserCourse::create(array(
							'course_id' => $course->id,
							'user_id' => $user_id,
						));
						if ($userCourse) {
							Mail::send('emails.auth.course-new', array('course' => $course, 'user' => $user), function ($message_new) use ($user) {
								$message_new->to($user->email, $user->name)->subject('Your new course in Teachbox');
							});
							return Redirect::route('course-page', array('id' => $course->id));

						} else {
							return Redirect::route('course-page', array('id' => $course->id))
							                                                                                                                      ->with('global-negative', 'You could not create this course.');
						                                                           }

						                                                           return View::make('courses.join')
						                                                           	->with('course', $course);

					                                                           }

					                                                           return Redirect::action('CourseController@create')
					                                                           	->with('global-negative', 'Your course could not be created.');
				                                                           }

			                                                           } else {
				                                                           return Redirect::action('CourseController@create')
				                                                           	->withErrors(array('pic' => 'You have not selected a picture or it has a wrong extension.'));
			}

		}
	}

	public function course($id) {
		function orderBy($data, $field) {
			$code = "return strnatcmp(\$a['$field'], \$b['$field']);";
			usort($data, create_function('$a,$b', $code));
			return $data;
		}
		$course = Course::find($id);
		$students = UserCourse::where('course_id', '=', $id)->get();
		$avgArray = array();
		$rankingList = array();
		$doneArray = array();
		$m = 0;
		$reviewCount = DB::select(DB::raw("SELECT COUNT(reviews.rating) AS reviewCount
		FROM reviews WHERE reviews.course_id = '$course->id'"));
		$reviewCount = $reviewCount[0]->reviewCount;
		foreach ($students as $student) {
			$rankingList[] = User::find($student->user_id);
			$result = DB::select(DB::raw("SELECT COUNT(results.id) AS result
			FROM results
			JOIN lessons
			ON results.lesson_id = lessons.id
			JOIN courses
			ON lessons.course_id = courses.id
			WHERE results.user_id = '$student->user_id' AND courses.id =   '$id' "));
			$lessonsCount = Lesson::where('course_id', '=', $id)->count();
			$done = $result[0]->result;
			if ($done != 0) {
				$donePercent = intval($done / $lessonsCount * 100);
			} else {
				$donePercent = 0;
			}
			$doneArray[$m] = $donePercent;
			$avg = DB::select(DB::raw("SELECT AVG(results.right/results.total * 100) AS avg
				FROM results
				JOIN lessons
				ON results.lesson_id = lessons.id
				JOIN courses
				ON lessons.course_id = courses.id
				WHERE results.user_id = '$student->user_id' AND courses.id =  '$id'"));
			$avg = $avg[0]->avg;
			$avg = intval($avg);
			$avgArray[$m] = $avg;
			$rankingList[$m]->avg = $avg;
			$rankingList[$m]->done = $donePercent;
			$m++;

		}
		$rankingList = array_values(array_sort($rankingList, function ($value) {
			return $value['avg'];
		}));
		$rankingList = array_reverse($rankingList);
		$rankingList = array_slice($rankingList, 0, 10);
		$reviews = Review::where('course_id', '=', $course->id)->orderBy('created_at', 'DESC')->take(3)->get();
		$avgReview = DB::select(DB::raw("SELECT AVG(reviews.rating) AS avgReview
		FROM reviews WHERE reviews.course_id = '$course->id'"));
		$avgReview = round($avgReview[0]->avgReview);
		$studentCount = UserCourse::where('course_id', '=', $id)->count();
		$studentCount = $studentCount - 1;
		if ($studentCount > 999) {
			$thousand = substr($studentCount, 0, 1);
			$hundred = substr($studentCount, 1, 1);
			$studentCount = $thousand . '.' . $hundred . 'k';
		} elseif ($studentCount > 999999) {
			$million = substr($studentCount, 0, 1);
			$thousand = substr($studentCount, 1, 1);
			$studentCount = $million . '.' . $thousand . 'm';
		}
		if (Auth::check()) {
			$isJoined = UserCourse::where(function ($query) {
				$query->where('user_id', '=', Auth::user()->id);
			})->where(function ($query) use ($id) {
				$query->where('course_id', '=', $id);
			})->count();
		}
		if ($course->approved == 1 || $course->user_id == Auth::user()->id || Auth::user()->admin == 1) {

			if ((Auth::check() && $course->user_id == Auth::user()->id) || (Auth::check() && Auth::user()->admin == 1)) {
				$lessonList = Lesson::where('course_id', '=', $id)->get();
			} else {
				$lessonList = Lesson::where('course_id', '=', $id)->where('approved', '=', 1)->get();
			}

			$user = User::find($course->user_id);

			if (Auth::check()) {
				if (Auth::user()->admin == 1) {
					return View::make('courses.join')
						->with(array('course' => $course, 'reviews' => $reviews, 'lessonList' => $lessonList, 'user' => $user, 'studentCount' => $studentCount, 'avgReview' => $avgReview, 'doneArray' => $doneArray, 'isJoined' => $isJoined, 'rankingList' => $rankingList, 'reviewCount' => $reviewCount));

				} else {
					return View::make('courses.join')
						->with(array('course' => $course, 'reviews' => $reviews, 'lessonList' => $lessonList, 'user' => $user, 'studentCount' => $studentCount, 'doneArray' => $doneArray, 'avgReview' => $avgReview, 'isJoined' => $isJoined, 'rankingList' => $rankingList, 'reviewCount' => $reviewCount));
				}
			} else {
				return View::make('courses.join')
					->with(array('course' => $course, 'reviews' => $reviews, 'lessonList' => $lessonList, 'user' => $user, 'studentCount' => $studentCount, 'doneArray' => $doneArray, 'avgReview' => $avgReview, 'rankingList' => $rankingList, 'reviewCount' => $reviewCount));
			}
		} else {
			return Redirect::route('home');
		}
	}

	public function postJoin($id) {
		$course = Course::find($id);
		if (Auth::check() && $course->approved == 1) {

			$user_id = Auth::user()->id;
			$userCourse = UserCourse::create(array(
				'course_id' => $id,
				'user_id' => $user_id,
			));
			if ($userCourse) {

				$notification = Notification::create(array(
					'user_id' => $course->user_id,
					'type' => 3,
					'event_id' => $userCourse,
				));

				return Redirect::route('course-page', array('id' => $id));
			} else {
				return Redirect::route('course-page', array('id' => $id))
					->with('global-negative', 'You could not join this course.');
			}
		} else {
			return View::make('home.before');
		}
	}

	public function courseEdit($id) {
		$course = Course::find($id);
		$studentCount = UserCourse::where('course_id', '=', $id)->count();
		$studentCount = $studentCount - 1;
		if ($studentCount > 999) {
			$thousand = substr($studentCount, 0, 1);
			$hundred = substr($studentCount, 1, 1);
			$studentCount = $thousand . '.' . $hundred . 'k';
		} elseif ($studentCount > 999999) {
			$million = substr($studentCount, 0, 1);
			$thousand = substr($studentCount, 1, 1);
			$studentCount = $million . '.' . $thousand . 'm';
		}
		$reviewCount = DB::select(DB::raw("SELECT COUNT(reviews.rating) AS reviewCount
		FROM reviews WHERE reviews.course_id = '$course->id'"));
		$reviewCount = $reviewCount[0]->reviewCount;
		$avgReview = DB::select(DB::raw("SELECT AVG(reviews.rating) AS avgReview
		FROM reviews WHERE reviews.course_id = '$course->id'"));
		$avgReview = round($avgReview[0]->avgReview);

		if (Auth::check() && ($course->approved == 1 || $course->user_id == Auth::user()->id)) {
			if (Auth::user()->id == $course->user_id) {

				$user = User::find($course->user_id);
				return View::make('courses.edit')
					->with(array('course' => $course, 'user' => $user, 'studentCount' => $studentCount, 'avgReview' => $avgReview, 'reviewCount' => $reviewCount));
			} else {
				return Redirect::route('course-page', array('id' => $id));
			}

		} else {
			return View::make('home.before');
		}
	}

	public function postCourseEdit($id) {
		$course = Course::find($id);
		$studentCount = UserCourse::where('course_id', '=', $id)->count();
		$studentCount = $studentCount - 1;
		if ($studentCount > 999) {
			$thousand = substr($studentCount, 0, 1);
			$hundred = substr($studentCount, 1, 1);
			$studentCount = $thousand . '.' . $hundred . 'k';
		} elseif ($studentCount > 999999) {
			$million = substr($studentCount, 0, 1);
			$thousand = substr($studentCount, 1, 1);
			$studentCount = $million . '.' . $thousand . 'm';
		}

		if (Auth::check() && ($course->approved == 1 || $course->user_id == Auth::user()->id) && $course->user_id == Auth::user()->id) {
			$validator = Validator::make(Input::all(),
				array(
					'description' => 'min:30|max:4096',
				));

			if ($validator->fails()) {
				return Redirect::action('CourseController@courseEdit', [$id])
					->withErrors($validator);

			} else {
				$courseEdit = Course::find($id);

				$description = Input::get('description');
				if (Input::hasFile('image') && (Input::file('image')->getClientOriginalExtension() == "jpg" || Input::file('image')->getClientOriginalExtension() == "png")) {

					$file_max = 4000000;

					$image = Input::file('image');
					$size = $image->getSize();

					if ($size >= $file_max) {
						return Redirect::action('CourseController@courseEdit', [$id])
							->withErrors(array('pic' => 'The file size is larger than 4mb.'));

					}

					$symbols = array("+", "!", "@", "$", "^", "&", "*");
					$replace = array("", "", "", "", "", "", "");
					$newImage = Image::make($image->getRealPath());
					$newImage1 = Image::make($image->getRealPath());
					$filename = $image->getClientOriginalName();
					$filename = str_replace($symbols, $replace, $filename);
					$ratio = 1;
					$ratio1 = 3 / 2;
					$width = $newImage->width();
					$newImage->fit($width, intval($width / $ratio));
					$newImage1->fit($width, intval($width / $ratio1));

					$pathImg = public_path() . '/courses/' . $course->id . '/img/';

					$success = File::cleanDirectory($pathImg);

					if ($newImage->save(public_path('/courses/' . $courseEdit->id . '/img/' . $filename)) && $newImage1->save(public_path('/courses/' . $course->id . '/img/' . '/3x2' . $filename))) {
						$courseEdit->pic = $filename;
					}
				}

				$message = nl2br($description);
				$description = trim($message);

				$courseEdit->description = $description;

				if ($courseEdit->save()) {
					return Redirect::route('course-page', array('id' => $id));
				}
			}

			return Redirect::action('CourseController@courseEdit', [$id])
				->with('global-negative', 'Your course settings could not be changed.');
		}
	}
}
