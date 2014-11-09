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

	public function changePic($id){
		$user = User::find($id);

		if($user){
			return View::make('profile.pic')
					->with('user', $user);
		}

		return App::abort(404);
	}

	public function userPic($id){
			$image = Input::file('image');

			$newImage = Image::make($image->getRealPath());
			$filename = $image->getClientOriginalName();
			$ratio = 4/3;
			$width = $newImage->width();
			$newImage->fit($width, intval($width / $ratio));

			if($newImage->save('public/img/' . $id . '/' . $filename)){


				$user = User::find($id);
				$user->pic    = $image->getClientOriginalName();

				if($user->save()){
					return Redirect::route('user-profile', array('id' => $user->id));
				}
			}
	}
}