<?php 

class MessagesController extends \BaseController {
	public function index()
	{
		if(Auth::check()){

			$users = User::all();

			return View::make('message.index', ['users' => $users]);
		}else{
			return Redirect::action('AuthController@index');
		}
	}


}