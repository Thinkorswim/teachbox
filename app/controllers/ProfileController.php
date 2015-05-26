<?php

class ProfileController extends \BaseController {
	public function user($id) {
		$user = User::find($id);
		$followersCount = Follow::where('following_id', '=', $id)->count();
		$followingCount = Follow::where('follower_id', '=', $id)->count();
		if (Auth::check()) {
			$isFollowing = Follow::where(function ($query) {
				$query->where('follower_id', '=', Auth::user()->id);
			})->where(function ($query) use ($id) {
				$query->where('following_id', '=', $id);
			})->count();
		}
		$timeline = DB::select(DB::raw("SELECT users.id, users.email, follows.created_at FROM users, follows WHERE follows.follower_id = '$user->id' AND follows.following_id = users.id
										 UNION
										 SELECT courses.id, courses.user_id, user_courses.created_at FROM user_courses, courses WHERE user_courses.user_id = '$user->id' AND user_courses.course_id = courses.id  AND courses.approved = 1 AND courses.user_id <> '$user->id'
										 UNION
										 SELECT courses.id, courses.user_id, courses.created_at FROM courses WHERE courses.user_id = '$user->id' AND courses.approved = 1

										 ORDER BY created_at DESC
									 "));
		$timelineCount = count($timeline);
		if (count($timeline) < 5) {

		} else {
			$perPage = 5;
			$currentPage = Input::get('page', 1) - 1;
			$pagedData = array_slice($timeline, $currentPage * $perPage, $perPage);
			$timeline = Paginator::make($pagedData, count($timeline), $perPage);
		}
		if (Auth::check() && $user) {
			return View::make('profile.user')
				->with(array('user' => $user, 'isFollowing' => $isFollowing, 'followersCount' => $followersCount,
					'followingCount' => $followingCount, 'timeline' => $timeline, 'timelineCount' => $timelineCount));
		} else {
			return View::make('profile.user')
				->with(array('user' => $user, 'followersCount' => $followersCount,
					'followingCount' => $followingCount, 'timeline' => $timeline, 'timelineCount' => $timelineCount));
		}
		if (!Auth::check() && !$user) {
			return App::abort(404);
		}
	}

	public function changePic($id) {
		if (Auth::check() && ($id == Auth::user()->id)) {
			$user = User::find($id);

			if ($user) {
				return View::make('profile.pic')
					->with('user', $user);
			}

		}

		return App::abort(404);
	}

	public function postChangePic($id) {
		if (Auth::check()) {
			$user = User::find($id);
			if (Input::hasFile('image') && (Input::file('image')->getClientOriginalExtension() == "jpg" || Input::file('image')->getClientOriginalExtension() == "png")) {

				$symbols = array("+", "!", "@", "$", "^", "&", "*");
				$replace = array("", "", "", "", "", "", "");
				$image = Input::file('image');

				$file_max = 4000000;
				$size = $image->getSize();

				if ($size >= $file_max) {
					return Redirect::route('change-picture', array('id' => $user->id))
						->wfuserithErrors(array('pic' => 'The file size is larger than 4mb.'));

				}

				$newImage = Image::make($image->getRealPath());
				$newThumb = Image::make($image->getRealPath());

				$filename = $image->getClientOriginalName();
				$filename = str_replace($symbols, $replace, $filename);
				$ratio = 1;
				$width = $newImage->width();
				$newImage->fit($width, intval($width / $ratio));

				$newThumb->fit($width, intval($width / $ratio))->resize('100', '100');
				$newThumbName = getThumbName($filename);

				$pathImg = public_path() . '/img/' . $id . '/';
				$success = File::cleanDirectory($pathImg);

				if (($newImage->save(public_path('/img/' . $id . '/' . $filename))) && ($newThumb->save(public_path('/img/' . $id . '/' . $newThumbName)))) {
					$user->pic = $filename;

					if ($user->save()) {
						return Redirect::route('user-profile', array('id' => $user->id));
					}
				}

			} else {
				return Redirect::route('user-profile', array('id' => $user->id));
			}
		}
	}

	public function changePassword($id) {
		if (Auth::check()) {
			$user = User::find($id);

			if ($user && ($user->active == 1) && ($id == Auth::user()->id)) {
				return View::make('profile.password')
					->with('user', $user);
			}
		}
		return App::abort(404);
	}

	public function postChangePassword($id) {
		if (Auth::check()) {
			$validator = Validator::make(Input::all(),
				array(
					'password' => 'required',
					'new_password' => 'required|min:6|max:20',
					'new_password_again' => 'required|same:new_password',
				));

			if ($validator->fails()) {
				return Redirect::action('ProfileController@changePassword', [$id])
					->withErrors($validator);
			} else {
				$user = User::find($id);

				$password = Input::get('password');
				$new_password = Input::get('new_password');

				if (Hash::check($password, $user->password)) {
					$user->password = Hash::make($new_password);

					if ($user->save()) {
						return Redirect::action('ProfileController@changePassword', [$id])
							->with('global-positive', 'Your password has been changed.');
					}
				}

			}

			return Redirect::action('ProfileController@changePassword', [$id])
				->with('global-negative', 'Your password could not be changed. Did you typed your old password correctly?');
		}
	}

	public function userSettings($id) {
		if (Auth::check()) {
			$user = User::find($id);

			if ($user && ($id == Auth::user()->id)) {

				$country_list = array(
					"Afghanistan",
					"Albania",
					"Algeria",
					"Andorra",
					"Angola",
					"Antigua and Barbuda",
					"Argentina",
					"Armenia",
					"Australia",
					"Austria",
					"Azerbaijan",
					"Bahamas",
					"Bahrain",
					"Bangladesh",
					"Barbados",
					"Belarus",
					"Belgium",
					"Belize",
					"Benin",
					"Bhutan",
					"Bolivia",
					"Bosnia and Herzegovina",
					"Botswana",
					"Brazil",
					"Brunei",
					"Bulgaria",
					"Burkina Faso",
					"Burundi",
					"Cambodia",
					"Cameroon",
					"Canada",
					"Cape Verde",
					"Central African Republic",
					"Chad",
					"Chile",
					"China",
					"Colombi",
					"Comoros",
					"Congo",
					"Costa Rica",
					"Cote d'Ivoire",
					"Croatia",
					"Cuba",
					"Cyprus",
					"Czech Republic",
					"Denmark",
					"Djibouti",
					"Dominica",
					"Dominican Republic",
					"Ecuador",
					"Egypt",
					"El Salvador",
					"Equatorial Guinea",
					"Eritrea",
					"Estonia",
					"Ethiopia",
					"Fiji",
					"Finland",
					"France",
					"Gabon",
					"Gambia, The",
					"Georgia",
					"Germany",
					"Ghana",
					"Greece",
					"Grenada",
					"Guatemala",
					"Guinea",
					"Guinea-Bissau",
					"Guyana",
					"Haiti",
					"Honduras",
					"Hungary",
					"Iceland",
					"India",
					"Indonesia",
					"Iran",
					"Iraq",
					"Ireland",
					"Israel",
					"Italy",
					"Jamaica",
					"Japan",
					"Jordan",
					"Kazakhstan",
					"Kenya",
					"Kiribati",
					"Korea, North",
					"Korea, South",
					"Kuwait",
					"Kyrgyzstan",
					"Laos",
					"Latvia",
					"Lebanon",
					"Lesotho",
					"Liberia",
					"Libya",
					"Liechtenstein",
					"Lithuania",
					"Luxembourg",
					"Macedonia",
					"Madagascar",
					"Malawi",
					"Malaysia",
					"Maldives",
					"Mali",
					"Malta",
					"Marshall Islands",
					"Mauritania",
					"Mauritius",
					"Mexico",
					"Micronesia",
					"Moldova",
					"Monaco",
					"Mongolia",
					"Montenegro",
					"Morocco",
					"Mozambique",
					"Myanmar",
					"Namibia",
					"Nauru",
					"Nepal",
					"Netherlands",
					"New Zealand",
					"Nicaragua",
					"Niger",
					"Nigeria",
					"Norway",
					"Oman",
					"Pakistan",
					"Palau",
					"Panama",
					"Papua New Guinea",
					"Paraguay",
					"Peru",
					"Philippines",
					"Poland",
					"Portugal",
					"Qatar",
					"Romania",
					"Russia",
					"Rwanda",
					"Saint Kitts and Nevis",
					"Saint Lucia",
					"Saint Vincent",
					"Samoa",
					"San Marino",
					"Sao Tome and Principe",
					"Saudi Arabia",
					"Senegal",
					"Serbia",
					"Seychelles",
					"Sierra Leone",
					"Singapore",
					"Slovakia",
					"Slovenia",
					"Solomon Islands",
					"Somalia",
					"South Africa",
					"Spain",
					"Sri Lanka",
					"Sudan",
					"Suriname",
					"Swaziland",
					"Sweden",
					"Switzerland",
					"Syria",
					"Taiwan",
					"Tajikistan",
					"Tanzania",
					"Thailand",
					"Togo",
					"Tonga",
					"Trinidad and Tobago",
					"Tunisia",
					"Turkey",
					"Turkmenistan",
					"Tuvalu",
					"Uganda",
					"Ukraine",
					"United Arab Emirates",
					"United Kingdom",
					"United States",
					"Uruguay",
					"Uzbekistan",
					"Vanuatu",
					"Vatican City",
					"Venezuela",
					"Vietnam",
					"Yemen",
					"Zambia",
					"Zimbabwe");
				$country_array = array_combine($country_list, $country_list);

				return View::make('profile.settings')
					->with(array('user' => $user, 'country_array' => $country_array));
			}
		}

		return App::abort(404);
	}

	public function postUserSettings($id) {
		if (Auth::check()) {
			$validator = Validator::make(Input::all(),
				array(
					'name' => 'required|min:3|max:128',
					'country' => 'max:64',
					'city' => 'min:3|max:128',
					'decription' => 'min:4|max:512',
				));

			if ($validator->fails()) {
				return Redirect::action('ProfileController@userSettings', [$id])
					->withErrors($validator);
			} else {
				$name = Input::get('name');
				$country = Input::get('country');
				$city = Input::get('city');
				$date = Input::get('day') . '/' . Input::get('month') . '/' . Input::get('year');
				$description = Input::get('decription');
				$mail = Input::get('hideMail');
				$user = User::find($id);

				$user->name = $name;
				$user->country = $country;
				$user->city = $city;
				$user->date = $date;
				$user->decription = $description;
				$user->hide_email = $mail;
				if ($user->save()) {
					return Redirect::action('ProfileController@user', [$id]);
				}

			}

			return Redirect::action('ProfileController@userSettings', [$id])
				->with('global-negative', 'Your profile settings could not be changed.');
		}
	}

	public function userCourses($id) {
		$user = User::find($id);

		$createdList = Course::where('user_id', '=', $id)->where('approved', '=', 1)->get();
		$createdAll = Course::where('user_id', '=', $id)->count();
		$courseListId = UserCourse::where('user_id', '=', $id)->get();
		$joinedList = array();
		$createdAvgReviews = array();
		$createdReviewCounts = array();
		$l = 0;
		foreach ($createdList as $created) {
			$createdAvgReview = DB::select(DB::raw("SELECT AVG(reviews.rating) AS avgReview
			FROM reviews WHERE reviews.course_id = '$created->id'"));
			$createdAvgReview = round($createdAvgReview[0]->avgReview);
			$createdAvgReviews[$l] = $createdAvgReview;
			$reviewCount = DB::select(DB::raw("SELECT COUNT(reviews.rating) AS reviewCount
		FROM reviews WHERE reviews.course_id = '$created->id'"));
			$reviewCount = $reviewCount[0]->reviewCount;
			$createdReviewCounts[$l] = $reviewCount;
			$l++;
		}
		$followersCount = Follow::where('following_id', '=', $id)->count();
		$followingCount = Follow::where('follower_id', '=', $id)->count();
		if (Auth::check()) {
			$isFollowing = Follow::where(function ($query) {
				$query->where('follower_id', '=', Auth::user()->id);
			})->where(function ($query) use ($id) {
				$query->where('following_id', '=', $id);
			})->count();
		} else {
			$isFollowing = 0;
		}
		$i = 0;
		$m = 0;
		$avgArray = array();
		$doneArray = array();
		$avgReviews = array();
		$joinedReviewCounts = array();
		foreach ($courseListId as $userCourse) {
			$joinedList[] = Course::find($userCourse->course_id);
			$joinUser = $joinedList[$i]->user_id;
			$jReviewCount = DB::select(DB::raw("SELECT COUNT(reviews.rating) AS reviewCount
				FROM reviews WHERE reviews.course_id = '$userCourse->course_id'"));
			$jReviewCount = $jReviewCount[0]->reviewCount;
			$joinedReviewCounts[$m] = $jReviewCount;
			if ($user->id != $joinedList[$i]->user_id && $joinedList[$i]->approved) {
				$avgReview = DB::select(DB::raw("SELECT AVG(reviews.rating) AS avgReview
				FROM reviews WHERE reviews.course_id = '$userCourse->course_id'"));
				$avgReview = round($avgReview[0]->avgReview);
				$avgReviews[] = $avgReview;
				$myId = $user->id;
				$result = DB::select(DB::raw("SELECT COUNT(results.id) AS result
				FROM results
				JOIN lessons
				ON results.lesson_id = lessons.id
				JOIN courses
				ON lessons.course_id = courses.id
				WHERE results.user_id = '$myId' AND courses.id =   '$userCourse->course_id' "));
				$lessonsCount = Lesson::where('course_id', '=', $userCourse->course_id)->count();
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
				WHERE results.user_id = '$myId' AND courses.id =  '$userCourse->course_id'"));
				$avg = $avg[0]->avg;
				$avg = intval($avg);
				$avgArray[$m] = $avg;
				$doneArray[$m] = $donePercent;
				$m++;
			}
			$i++;
		}
		//dd($joinedReviewCounts);
		return View::make('profile.courses')
			->with(array('joinedList' => $joinedList, 'user' => $user, 'isFollowing' => $isFollowing,
				'createdList' => $createdList, 'followersCount' => $followersCount, 'followingCount' => $followingCount, 'avgArray' => $avgArray, 'doneArray' => $doneArray, 'createdAll' => $createdAll, 'avgReviews' => $avgReviews, 'createdAvgReviews' => $createdAvgReviews, 'createdReviewCounts' => $createdReviewCounts, 'joinedReviewCounts' => $joinedReviewCounts));
	}

	public function userFollowers($id) {

		$user = User::find($id);
		$followerListId = Follow::where('following_id', '=', $id)->get();
		$followerList = array();
		$followersCount = Follow::where('following_id', '=', $id)->count();
		$followingCount = Follow::where('follower_id', '=', $id)->count();
		if (Auth::check()) {
			$isFollowing = Follow::where(function ($query) {
				$query->where('follower_id', '=', Auth::user()->id);
			})->where(function ($query) use ($id) {
				$query->where('following_id', '=', $id);
			})->count();
		} else {
			$isFollowing = 0;
		}
		foreach ($followerListId as $follower) {
			$followerList[] = User::find($follower->follower_id);
		}

		return View::make('profile.followers')
			->with(array('user' => $user, 'followerList' => $followerList, 'isFollowing' => $isFollowing,
				'followersCount' => $followersCount, 'followingCount' => $followingCount));

	}

	public function userFollowing($id) {
		$user = User::find($id);
		$followingListId = Follow::where('follower_id', '=', $id)->get();
		$followingList = array();
		$followersCount = Follow::where('following_id', '=', $id)->count();
		if (Auth::check()) {
			$isFollowing = Follow::where(function ($query) {
				$query->where('follower_id', '=', Auth::user()->id);
			})->where(function ($query) use ($id) {
				$query->where('following_id', '=', $id);
			})->count();
		} else {
			$isFollowing = 0;
		}

		foreach ($followingListId as $following) {
			$followingList[] = User::find($following->following_id);
		}

		return View::make('profile.following')
			->with(array('user' => $user, 'followingList' => $followingList, 'isFollowing' => $isFollowing,
				'followersCount' => $followersCount));

	}

	public function postFollow($id) {
		if (Auth::check()) {
			$user = User::find($id);

			$follow = Follow::create(array(
				'follower_id' => Auth::user()->id,
				'following_id' => $id,
			));

			$notification = Notification::create(array(
				'user_id' => $id,
				'type' => 2,
				'event_id' => Auth::user()->id,
			));

			if ($follow) {
				return Redirect::action('ProfileController@user', [$id])
					->with('user', $user);
			}

		}
		return App::abort(404);
	}
	public function postUnfollow($id) {
		if (Auth::check()) {
			$user = User::find($id);

			$follow = Follow::where(array(
				'follower_id' => Auth::user()->id,
				'following_id' => $id,
			))->delete();

			$notification = Notification::where('user_id', '=', $id)->where('event_id', '=', Auth::user()->id)->where('type', '=', 2);
			$notification->delete();

			if ($user) {
				return Redirect::action('ProfileController@user', [$id])
					->with('user', $user);
			}

		}
		return App::abort(404);
	}

	public function feedback() {

		return View::make('feedback.send_feedback');

	}

	public function privacy() {

		return View::make('company.privacy');

	}

	public function terms() {

		return View::make('company.terms');

	}

	public function contacts() {

		return View::make('company.contacts');

	}

	public function advertising() {

		return View::make('company.advertising');

	}
}
