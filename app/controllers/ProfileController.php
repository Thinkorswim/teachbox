<?php

class ProfileController extends \BaseController {

	public function user($id){
		$user = User::find($id);

		if($user){
			return View::make('profile.user')
					->with('user', $user);
		}

		return App::abort(404);
	}

}