<?php 

class AdminController extends \BaseController {

    public function adminHome()
    {
        if(Auth::check() && Auth::user()->admin){
            $users = User::all();
            $courses = Course::all();
            $admins = User::where('admin', '=',  '1')->get();
            $count_users = array();
            $count_courses = array();

            for ($i=1; $i <= 12; $i++) {
                $count_users[$i] = User::where( DB::raw('MONTH(created_at)'), '=', $i)->count();
                $count_courses[$i] =  Course::where( DB::raw('MONTH(created_at)'), '=', $i )->count();
            }

            return View::make('admin.home')->with(array(
                        'admins' => $admins, 'count_users' =>  $count_users,
                        'count_courses' => $count_courses ));
        }else{
            return Redirect::action('AuthController@index');
        }
    }


    public function showUsers()
	{
		if(Auth::check() && Auth::user()->admin){

			$users = User::orderBy('created_at', 'DESC')->paginate(10);

			return View::make('admin.users', ['users' => $users]);
		}else{
			return Redirect::action('AuthController@index');
		}
	}

    public function showCourses()
    {
        if(Auth::check() && Auth::user()->admin){

            $courses = Course::orderBy('created_at', 'DESC')->paginate(10);

            return View::make('admin.courses', ['courses' => $courses]);
        }else{
            return Redirect::action('AuthController@index');
        }

    }
    public function coursesApprove()
    {
        if(Auth::check() && Auth::user()->admin){

            $courses =  Course::where('approved', '=',  '0')->paginate(10);

            return View::make('admin.courses_approve')->with(array(
                        'courses' => $courses));
        }else{
            return Redirect::action('AuthController@index');
        }


        }


    public function lessonsApprove()
    {
        if(Auth::check() && Auth::user()->admin){
            $lessons =  Lesson::where('approved', '=',  '0')->paginate(10);
            $courses = array();
            if(count($lessons) > 0){
                foreach ($lessons as $lesson) {
                    $course = Course::find($lesson->course_id);
                    $user = User::find($course->user_id);
                }
            }
            else{
                $course = null;
                $user = null;
            }

            return View::make('admin.lessons_approve')->with(array(
                        'lessons' => $lessons, 'course'=> $course, 'user'=> $user));
        }else{
            return Redirect::action('AuthController@index');
        }


        }

    public function editUser($id)
    {
        if(Auth::check() && Auth::user()->admin){
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
            $user = User::find($id);

            return View::make('admin.edit_user')->with(array('user' => $user, 'country_array' => $country_array));
        }else{
            return Redirect::action('AuthController@index');
        }
    }


    public function editCourse($id)
    {
        if(Auth::check() && Auth::user()->admin){

             $course = Course::find($id);

              return View::make('admin.edit_course', [ 'course' => $course ]);
         }else{
              return Redirect::action('AuthController@index');
        }
    }


    public function updateUser($id)
    {

        $user = User::find($id);

        $user->name   	  = Input::get('name');
        $user->email      = Input::get('email');
        $user->country = Input::get('country');
        $user->city    = Input::get('city');
        $user->date    = Input::get('day') . '/' . Input::get('month') . '/' . Input::get('year');
        $user->decription     = Input::get('decription');
        $user->save();
        
        return Redirect::to('/admin/users');
    }

    public function updateCourse($id)

    {
        $course = Course::find($id);
        $name = Input::get('name');
        $description = Input::get('description');
        

        $course->name = $name;
        $course->description = $description;
        $course->save();
        
        if($course->save()){
            return Redirect::to('/admin/courses');
   
        }
    }

    public function makeAdmin($id){
        if(Auth::check()){
            $user = User::find($id);
            $user->admin = 1;
            $user->save();

            if($user){
                return Redirect::action('AdminController@showUsers')
                        ->with('user',$user);
            }

        }
        return App::abort(404);
    }

    public function approveCourse($id){
        if(Auth::check()){
            $course = Course::find($id);
            $course->approved = 1;
            $course->save();
            $user = User::find($course->user_id);
            if($course){
        Mail::send('emails.auth.course-approved', array('user' => $user, 'course' => $course), function($message) use ($user) {
            $message->to( $user->email , $user->name)->subject('Your course has been approved.');
            } );
                return Redirect::action('AdminController@showCourses');
            }
        }
        return App::abort(404);
    }

    public function approveLesson($id){
        if(Auth::check()){
            $lesson = Lesson::find($id);
            $lesson->approved = 1;
            $lesson->save();

            if($lesson){
                return Redirect::action('AdminController@lessonsApprove');
            }
        }
        return App::abort(404);
    }

    public function deleteCourse($id){
        if(Auth::check()){
            $course = Course::find($id);
            $isDB = Course::find($id)->delete();
            $isDBLessons = Lesson::where('course_id', '=', $id)->delete();
            $isDBUser = UserCourse::where('course_id', '=', $id)->delete();

            $isFile = File::deleteDirectory(public_path() .'/courses/' . $id);


            if($isDB && $isDBLessons && $isFile){
                $user = User::find($course->user_id);
                Mail::send('emails.auth.course-deleted', array('user' => $user, 'course' => $course), function($message) use ($user) {
                   $message->to( $user->email , $user->name)->subject('Unfortunately your course has not been approved.');
                } );
                 return Redirect::action('AdminController@showCourses');
            }
        }
        return App::abort(404);
    }

    public function deleteLesson($id){
        if(Auth::check()){
            $lesson = Lesson::find($id);
            $course = Course::find($lesson->course_id);
            $user = User::find($course->user_id);
            $isDB = Lesson::find($id)->delete();

            $isFile = File::deleteDirectory(public_path() .'/courses/' . $lesson->course_id . '/' . $lesson->order);

            if($isDB && $isFile){
                Mail::send('emails.auth.lesson-deleted', array('user' => $user, 'course' => $course, 'lesson' => $lesson), function($message) use ($user) {
                   $message->to( $user->email , $user->name)->subject('Unfortunately your lesson has not been approved.');
                } );
                return Redirect::action('AdminController@lessonsApprove');
            }
        }
        return App::abort(404);
    }

}
