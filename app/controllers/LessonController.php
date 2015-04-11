<?php

class LessonController extends \BaseController {

	public function courseLesson($id, $lesson) {
		$studentCount = UserCourse::where('course_id', '=', $id)->count();
		$studentCount = $studentCount - 1;
		$course = Course::find($id);

		if (Auth::check()) {
			$isJoined = UserCourse::where(function ($query) {
				$query->where('user_id', '=', Auth::user()->id);
			})->where(function ($query) use ($id) {
				$query->where('course_id', '=', $id);
			})->count();
		}
		if ($course->approved == 1 || $course->user_id == Auth::user()->id || Auth::user()->admin) {
			$lesson = Lesson::where(function ($query) use ($lesson) {
				$query->where('order', '=', $lesson);
			})->where(function ($query) use ($id) {
				$query->where('course_id', '=', $id);
			})->first();

			if ($lesson->approved == 1 || $course->user_id == Auth::user()->id || Auth::user()->admin) {
				$lessonList = Lesson::where('course_id', '=', $id)->get();
				$creator = User::where('id', '=', $course->user_id)->first();

				$previousLesson = Lesson::where(function ($query) use ($lesson) {
					$query->where('order', '=', $lesson->order - 1);
				})->where(function ($query) use ($id) {
					$query->where('course_id', '=', $id);
				})->first();

				$nextLesson = Lesson::where(function ($query) use ($lesson) {
					$query->where('order', '=', $lesson->order + 1);
				})->where(function ($query) use ($id) {
					$query->where('course_id', '=', $id);
				})->first();

				$comments = Comment::where('lesson_id', '=', $lesson->id)->orderBy('created_at', 'DESC')->paginate(15);
				$test = Test::find($id);
				$questions = Test::where('lesson_id', '=', $lesson->id)->get();
				if (Auth::check()) {
					return View::make('courses.lesson')
						->with(array('course' => $course, 'isJoined' => $isJoined, 'lesson' => $lesson, 'nextLesson' => $nextLesson, 'previousLesson' => $previousLesson, 'lessonList' => $lessonList, 'creator' => $creator, 'questions' => $questions, 'comments' => $comments));
				} else {
					return View::make('courses.lesson')
						->with(array('course' => $course, 'lesson' => $lesson, 'nextLesson' => $nextLesson, 'previousLesson' => $previousLesson, 'lessonList' => $lessonList, 'creator' => $creator, 'questions' => $questions, 'comments' => $comments));
				}

			}
		}
	}
	public function lessons($id) {
		$course = Course::find($id);
		$user = User::find($course->user_id);
		$studentCount = UserCourse::where('course_id', '=', $id)->count();
		$studentCount = $studentCount - 1;
		$avgReview = DB::select(DB::raw("SELECT AVG(reviews.rating) AS avgReview
			FROM reviews WHERE reviews.course_id = '$course->id'"));
		$avgReview = round($avgReview[0]->avgReview);
		if ($studentCount > 999) {
			$thousand = substr($studentCount, 0, 1);
			$hundred = substr($studentCount, 1, 1);
			$studentCount = $thousand . '.' . $hundred . 'k';
		} elseif ($studentCount > 999999) {
			$million = substr($studentCount, 0, 1);
			$thousand = substr($studentCount, 1, 1);
			$studentCount = $million . '.' . $thousand . 'm';
		}
		$students = UserCourse::where('course_id', '=', $id)->get();
		$avgArray = array();
		$rankingList = array();
		$reviewCount = DB::select(DB::raw("SELECT COUNT(reviews.rating) AS reviewCount
		FROM reviews WHERE reviews.course_id = '$course->id'"));
		$reviewCount = $reviewCount[0]->reviewCount;
		$reviews = Review::where('course_id', '=', $course->id)->orderBy('created_at', 'DESC')->take(3)->get();
		$m = 0;
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
		if (Auth::check()) {
			$isJoined = UserCourse::where(function ($query) {
				$query->where('user_id', '=', Auth::user()->id);
			})->where(function ($query) use ($id) {
				$query->where('course_id', '=', $id);
			})->count();
			if ($course->approved == 1 || $course->user_id == Auth::user()->id || Auth::user()->admin == 1) {

				if ((Auth::check() && $course->user_id == Auth::user()->id) || (Auth::check() && Auth::user()->admin == 1)) {
					$lessonList = Lesson::where('course_id', '=', $id)->get();
				} else {
					$lessonList = Lesson::where('course_id', '=', $id)->where('approved', '=', 1)->get();
				}
				return View::make('courses.lessons')
					->with(array('course' => $course, 'lessonList' => $lessonList, 'user' => $user, 'isJoined' => $isJoined, 'studentCount' => $studentCount, 'avgReview' => $avgReview,
						'rankingList' => $rankingList, 'reviews' => $reviews, 'reviewCount' => $reviewCount));
			} else {
				return View::make('courses.lessons')
					->with(array('course' => $course, 'user' => $user, 'lessonList' => $lessonList, 'studentCount' => $studentCount, 'avgReview' => $avgReview,
						'rankingList' => $rankingList, 'reviews' => $reviews, 'reviewCount' => $reviewCount));
			}
		} else {
			return Redirect::route('home');
		}
	}

	public function courseAdd($id) {
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

		$avgReview = DB::select(DB::raw("SELECT AVG(reviews.rating) AS avgReview
		FROM reviews WHERE reviews.course_id = '$course->id'"));
		$avgReview = round($avgReview[0]->avgReview);

		if (Auth::check() && ($course->approved == 1 || $course->user_id == Auth::user()->id) && $course->user_id == Auth::user()->id) {
			$course = Course::find($id);

			if (Auth::user()->id == $course->user_id) {

				$user = User::find($course->user_id);
				return View::make('courses.add')
					->with(array('course' => $course, 'user' => $user, 'studentCount' => $studentCount, 'avgReview' => $avgReview));
			} else {
				return Redirect::route('course-page', array('id' => $id));
			}

		} else {
			return View::make('home.before');
		}
	}

	public function coursePostAdd($id) {
		$course = Course::find($id);
		$user = User::find($course->user_id);

		if (Auth::check() && ($course->approved == 1 || $course->user_id == Auth::user()->id) && $course->user_id == Auth::user()->id) {
			if (Input::hasFile('video') && (Input::file('video')->getClientOriginalExtension() == "mp4")) {

				$file = Input::file('video');

				$validator = Validator::make(Input::all(),
					array(
						'name' => 'required|min:4|max:64',
						'description' => 'required|min:10|max:1024',
					));

				if ($validator->fails()) {
					return Redirect::route('course-add', array('id' => $id))
						->withErrors($validator);
				} else {

					$name = Input::get('name');
					$description = Input::get('description');

					$course = Course::find($id);
					$order = Lesson::where('course_id', '=', $id)->count() + 1;

					$path = public_path() . '/courses/' . $course->id . '/' . $order;
					$filename = "video.mp4";
					$resultMake = File::makeDirectory(public_path() . '/courses/' . $course->id . '/' . $order);
					$file->move($path, $filename);

					$message = nl2br($description);
					$description = trim($message);

					$ffmpeg = public_path() . '/ffmpeg/ffmpeg';
					$video = $path . '/' . $filename;

					$full_duration = exec("$ffmpeg -i $video 2>&1 |
				grep Duration | cut -d ' ' -f 4 | sed s/,//");

					$hour = substr($full_duration, 0, 2);
					$minute = substr($full_duration, 3, 2);
					$second = substr($full_duration, 6, 2);

					$duration = $minute . ':' . $second;

					$hour_i = (int) $hour;
					$minute_i = (int) $minute;
					$second_i = (int) $second;

					if ($hour_i != 0) {
						$deleteMake = File::deleteDirectory(public_path() . '/courses/' . $course->id . '/' . $order);
						return Redirect::route('course-add', array('id' => $id, 'user' => $user))
							->withErrors(array('video' => 'The video is bigger than 5 minutes.'));
					} else {
						if ($minute_i <= 4 || ($minute_i == 5 && $second_i == 0)) {

						} else {
							$deleteMake = File::deleteDirectory(public_path() . '/courses/' . $course->id . '/' . $order);
							return Redirect::route('course-add', array('id' => $id, 'user' => $user))
								->withErrors(array('video' => 'The video is bigger than 5 minutes.'));
						}
					}

					// Get Thumbnail
					$image = $path . '/thumb.png';
					$interval = 1;
					$cmd = "$ffmpeg -i $video -deinterlace -an -ss $interval -f mjpeg -t 1 -r 1 -y $image 2>&1";
					shell_exec($cmd);

					//Queue::push('Convert', array('video' => $video, 'path' => $path, 'ffmpeg' => $ffmpeg));

					if (File::exists($path . '/thumb.png')) {
						$image = Image::make($path . '/thumb.png');
						$image->fit(300, 200);
						$image->save($path . '/thumb300x200.png');

						$image2 = Image::make($path . '/thumb.png');
						$image2->fit(100, 100);
						$image2->save($path . '/thumb100x100.png');
					}

					$lesson = Lesson::create(array(
						'filepath' => $filename,
						'course_id' => $id,
						'name' => $name,
						'description' => $description,
						'order' => $order,
						'duration' => $duration,
					));

					if ($lesson) {

						if (!Input::has("q1") || !Input::has("11") || !Input::has("12")) {
							return Redirect::route('course-add', array('id' => $id, 'user' => $user))
								->withErrors(array('test' => 'You have to create at least 1 question with 2 options.'));
						}

						$continue = true;
						for ($i = 1; $i <= 5; $i++) {
							if (Input::has("q" . $i) && $continue) {
								$answers = array();
								for ($j = 1; $j <= 4; $j++) {
									if ($j <= 2) {
										if (!Input::has((string) ($i . $j))) {
											break;
											$continue = false;
										} else {
											$answers[$j] = Input::get((string) ($i . $j));
										}
									} else {
										if (!Input::has((string) ($i . $j))) {
											break;
										} else {
											$answers[$j] = Input::get((string) ($i . $j));
										}
									}
								}
								if ($continue) {
									$test = new Test;
									$test->lesson_id = $lesson->id;
									$test->question = Input::get("q" . $i);
									$test->choice_1 = $answers[1];
									$test->choice_2 = $answers[2];
									if (array_key_exists(3, $answers)) {
										$test->choice_3 = $answers[3];
									}
									if (array_key_exists(4, $answers)) {
										$test->choice_4 = $answers[4];
									}
									$test->answer = Input::get("r" . $i) % 10;
									$test->save();
								}
							}
						}
						return Redirect::route('course-page', array('id' => $id, 'user' => $user));
					} else {
						return Redirect::route('course-page', array('id' => $id, 'user' => $user))
							->with('global-negative', 'You could not join this course.');
					}
				}

			} else {
				return Redirect::route('course-add', array('id' => $id, 'user' => $user))
					->withErrors(array('video' => 'You have not selected a video file or it has a wrong extension.'));
			}
		} else {

			return View::make('home.before');
		}
	}

	public function postLessonTest($id, $lesson) {
		$course = Course::find($id);
		if (Auth::check()) {
			$user = Auth::user();
			$lesson = Lesson::find($lesson);
			$questions = Test::where('lesson_id', '=', $lesson->id)->get();
			$scored = 0;
			$total = count($questions);
			$choices = array();
			$i = 0;
			foreach ($questions as $question) {
				$answer = $question->answer;
				do {
					$i++;
					if (Input::has("r" . $i)) {
						$choices[$i] = Input::get("r" . $i) % 10;
						//Log::info("Choice:    " . print_r($choices[$i],true));
						if ($choices[$i] == $answer) {
							$scored++;
						}
					}
				} while ($i > 5);

				//Log::info("Answer:    " . $answer);
				//Log::info("Scored:    " . $scored);
			}

			$result = new Result;
			$result->lesson_id = $lesson->id;
			$result->user_id = $user->id;
			$result->total = $total;
			$result->right = $scored;
			$result->save();

			$returner = array();
			$returner['percentage'] = (intval($scored) / intval($total)) * 100;
			$returner['total'] = intval($total);
			$returner['right'] = intval($scored);

			return $returner;
		} else {
			return View::make('home.before');
		}
	}

	public function lessonEdit($id, $lesson) {
		$course = Course::find($id);
		if (Auth::check() && ($course->approved == 1 || $course->user_id == Auth::user()->id) && $course->user_id == Auth::user()->id) {
			$course = Course::find($id);
			$lesson = Lesson::where(function ($query) use ($lesson) {
				$query->where('order', '=', $lesson);
			})->where(function ($query) use ($id) {
				$query->where('course_id', '=', $id);
			})->first();

			return View::make('courses.edit_lesson')->with(array('course' => $course, 'lesson' => $lesson));
		} else {
			return View::make('home.before');
		}
	}

	public function deleteLesson($id, $lesson) {
		$course = Course::find($id);
		if (Auth::check() && ($course->approved == 1 || $course->user_id == Auth::user()->id) && $course->user_id == Auth::user()->id) {
			$course = Course::find($id);
			$lesson = Lesson::where(function ($query) use ($lesson) {
				$query->where('order', '=', $lesson);
			})->where(function ($query) use ($id) {
				$query->where('course_id', '=', $id);
			})->first();

			return View::make('courses.delete_lesson')->with(array('course' => $course, 'lesson' => $lesson));
		} else {
			return View::make('home.before');
		}
	}

	public function postLessonEdit($id, $lesson) {

		$course = Course::find($id);

		if (Auth::check() && ($course->approved == 1 || $course->user_id == Auth::user()->id) && $course->user_id == Auth::user()->id) {
			$validator = Validator::make(Input::all(),
				array(
					'name' => 'required|min:4|max:64',
					'description' => 'min:10|max:1024',
				));

			if ($validator->fails()) {
				return Redirect::route('edit-lesson', array('id' => $id))
					->withErrors($validator);

			} else {

				$name = Input::get('name');
				$description = Input::get('description');

				$message = nl2br($description);
				$description = trim($message);

				$course = Course::find($id);

				$order = Lesson::where('course_id', '=', $id)->count();

				$lesson = Lesson::where(function ($query) use ($lesson) {
					$query->where('order', '=', $lesson);
				})->where(function ($query) use ($id) {
					$query->where('course_id', '=', $id);
				})->first();

				$lesson->name = $name;
				$lesson->description = $description;

				if ($lesson->save()) {
					return Redirect::route('course-page', array('id' => $id));
				} else {
					return Redirect::route('edit-lesson', array('id' => $id))
						->with('global-negative', 'You could not edit this lesson.');
				}
			}

		} else {

			return View::make('home.before');
		}
	}

	public function postDeleteLesson($id, $lesson) {
		if (Auth::check()) {
			$course = Course::find($id);

			$order = Lesson::where('course_id', '=', $id)->count();

			$lesson = Lesson::where(function ($query) use ($lesson) {
				$query->where('order', '=', $lesson);
			})->where(function ($query) use ($id) {
				$query->where('course_id', '=', $id);
			})->first();

			$isDB = $lesson->delete();

			$isFile = File::deleteDirectory(public_path() . '/courses/' . $lesson->course_id . '/' . $lesson->order);

			if ($isDB && $isFile) {
				$lessons = Lesson::where('course_id', '=', $id)->get();
				$newOrder = 1;
				foreach ($lessons as $lesson)
				{
						$lesson->order = $newOrder;
						$lesson->save();
						$newOrder++;
				}
		
				return Redirect::route('course-page', array('id' => $id));
			}
		}
	}

}
