<?php 

class AdminController extends \BaseController {

    public function adminHome()
    {
        if(Auth::check() && Auth::user()->admin){
            $users = User::all();
            $courses = Course::all();
            $admins = User::where('admin', '=',  '1')->get();
            $users_this_month = array();
            $users_last_month = array();
            $courses_this_month = array();
            $courses_last_month = array();

            foreach ($users as $user) {
                if (strpos($user->created_at,'2015-02') !== false) {
                    $users_this_month[] = $user;
                }
                else{
                    $users_last_month[] = $user;
                }
            }

            foreach ($courses as $course) {
                if (strpos($course->created_at,'2015-02') !== false) {
                    $courses_this_month[] = $course;
                }
                else{
                    $courses_last_month[] = $course;
                }
            }

            $users_this_month = count($users_this_month); 
            $users_last_month = count($users_last_month);
            $courses_last_month = count($courses_last_month);
            $courses_this_month = count($courses_this_month);
            return View::make('admin.home')->with(array(
                        'admins' => $admins, 'users_this_month' => $users_this_month,
                        'users_last_month' => $users_last_month, 'courses_last_month'=>$courses_last_month,
                        'courses_this_month'=>$courses_this_month ));
        }else{
            return Redirect::action('AuthController@index');
        }
    }


    public function showUsers()
	{
		if(Auth::check() && Auth::user()->admin){

			$users = User::all();

			return View::make('admin.users', ['users' => $users]);
		}else{
			return Redirect::action('AuthController@index');
		}
	}

    public function showCourses()
    {
        if(Auth::check() && Auth::user()->admin){

            $courses = Course::all();

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

            $user = User::find($id);

            return View::make('admin.edit_user', [ 'user' => $user ]);
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
        $user->admin      = Input::get('admin');
 
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

            if($course){
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

}
