<?php

class ProfileController extends \BaseController {
	public function user($id){
		$user = User::find($id);

		
		if($user){
			return View::make('profile.user')
					->with(array('user' => $user));
		}

		return App::abort(404);
	}

	public function changePic($id){
		if(Auth::check() && ($id == Auth::user()->id)){
			$user = User::find($id);
	
			if($user){
				return View::make('profile.pic')
						->with('user', $user);
			}

		
		}

		return App::abort(404);
	}

	public function postChangePic($id){
		if(Auth::check()){
			$user = User::find($id);
			if(Input::hasFile('image') && (Input::file('image')->getClientOriginalExtension() == "jpg" || Input::file('image')->getClientOriginalExtension() == "png")){


				$image = Input::file('image');

				$newImage = Image::make($image->getRealPath());
				$newThumb = Image::make($image->getRealPath());

				$filename = $image->getClientOriginalName();
				$ratio = 1;
				$width = $newImage->width();
				$newImage->fit($width, intval($width / $ratio));

				$newThumb->fit($width, intval($width / $ratio))->resize('100','100');
				$newThumbName = getThumbName($filename);
			


				if(($newImage->save('public/img/' . $id . '/' . $filename)) && ($newThumb->save('public/img/' . $id . '/' . $newThumbName))  ){
					$user->pic    = $image->getClientOriginalName();

					if($user->save()){
						return Redirect::route('user-profile', array('id' => $user->id));
					}
				}

			}else{
					return Redirect::route('change-picture', array('id' => $user->id));
			}
		}
	}

	public function changePassword($id){
		if(Auth::check()){
			$user = User::find($id);

			if($user && ($user->active  == 1) && ($id == Auth::user()->id)){
				return View::make('profile.password')
						->with('user', $user);
			}
		}
		return App::abort(404);
	}

	public function postChangePassword($id){
		if(Auth::check()){
			$validator = Validator::make(Input::all(),
				array(
						'password' 			 => 'required',
						'new_password' 		 => 'required|min:6|max:20',
						'new_password_again' => 'required|same:new_password'
					));

			if($validator->fails()){		
				return Redirect::action('ProfileController@changePassword',[$id])
						->withErrors($validator);
			}else{
				$user = User::find($id);

				$password = Input::get('password');
				$new_password = Input::get('new_password');

				if(Hash::check($password, $user->password )){
					$user->password = Hash::make($new_password);

					if($user->save()){
						return Redirect::action('ProfileController@changePassword',[$id])
							->with('global-positive', 'Your password has been changed.');
					}
				}

			}

				return Redirect::action('ProfileController@changePassword',[$id])
					->with('global-negative', 'Your password could not be changed. Did you typed your old password correctly?');
		}
	}

	public function userSettings($id){
		if(Auth::check()){
			$user = User::find($id);

			if($user && ($id == Auth::user()->id)){

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
					"Serbia and Montenegro",
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

	public function postUserSettings($id){
		if(Auth::check()){
			$validator = Validator::make(Input::all(),
				array(
						'name' 				 => 'required|min:4|max:40',
						'country' 			 => 'min:4|max:35',
						'city'				 => 'min:4|max:30',
				));

			if($validator->fails()){		
				return Redirect::action('ProfileController@userSettings',[$id])
						->withErrors($validator);
			}else{
				$name 	 = Input::get('name');
				$country = Input::get('country');
				$city 	 = Input::get('city');
				$date 	 = Input::get('day') . '/' . Input::get('month') . '/' . Input::get('year');

				$user = User::find($id);

				$user->name    = $name;
				$user->country = $country;
				$user->city    = $city;
				$user->date    = $date;

					if($user->save()){
						return Redirect::action('ProfileController@user',[$id]);
					}


			}

				return Redirect::action('ProfileController@userSettings',[$id])
					->with('global-negative', 'Your profile settings could not be changed.');
		}
	}

	public function userCourses($id){
		if(Auth::check()){
			$user = User::find($id);
			$courseListId = UserCourse::where('user_id', '=', $id)->get();
			$courseList = array();


			foreach ($courseListId as $tree)
				$courseList[] = Course::where('id', '=', $tree->course_id)->first();
			
				return View::make('profile.courses')
						->with(array('courseList' => $courseList,'user' => $user));
		}
		return App::abort(404);
	}

	public function userFollowers($id){
		if(Auth::check()){
			$user = User::find($id);

				return View::make('profile.followers')
						->with('user', $user);
		}
		return App::abort(404);
	}

	public function userFollowing($id){
		if(Auth::check()){
			$user = User::find($id);

				return View::make('profile.following')
						->with('user', $user);
		}
		return App::abort(404);
	}
}