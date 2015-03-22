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

}
