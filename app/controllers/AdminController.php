<?php 

class AdminController extends \BaseController {

	public function index()
	{
		if(Auth::check() && Auth::user()->admin){
			return View::make('admin.index');
		}else{
			return Redirect::action('AuthController@index');
		}
	}




}