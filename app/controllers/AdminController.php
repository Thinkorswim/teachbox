<?php 

class AdminController extends \BaseController {

	public function index()
	{
		if(Auth::check() && Auth::user()->admin){

			$users = User::all();

			return View::make('admin.index', ['users' => $users]);
		}else{
			return Redirect::action('AuthController@index');
		}
	}


 
    public function store()
    {
        $user = new User;
 
        $user->name       = Input::get('name');
        $user->email      = Input::get('email');
 
        $user->save();
 
        return Redirect::to('/admin');
    }
 


    public function edit($id)
    {
        $user = User::find($id);
 
        return View::make('admin.edit', [ 'user' => $user ]);
    }

    public function update($id)
    {
        $user = User::find($id);

        $user->name   	  = Input::get('name');
        $user->email      = Input::get('email');
 
        $user->save();
 
        return Redirect::to('/admin');
    }
 
    public function destroy($id)
    {
        User::destroy($id);
 
        return Redirect::to('/admin');
    }
 
}
