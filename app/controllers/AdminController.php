<?php 

class AdminController extends \BaseController {


    public function showUsers()
	{
		if(Auth::check() && Auth::user()->admin){

			$users = User::all();

			return View::make('admin.index', ['users' => $users]);
		}else{
			return Redirect::action('AuthController@index');
		}
	}

    public function showCourses()
    {
        if(Auth::check() && Auth::user()->admin){

            $courses = Course::all();

            return View::make('admin.index', ['courses' => $courses]);
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
        $name      = Input::get('name');
        $approved  = Input::get('approved');

        $course = Course::find($id);

        $course->name = $name;
        $course->approved = $approved;
        
        $course->save();
        
        if($course->save()){
            return Redirect::to('/admin/courses');
   
        }
    }
 
}
