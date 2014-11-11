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


				$user = User::find($id);
				$user->pic    = $image->getClientOriginalName();

				if($user->save()){
					return Redirect::route('user-profile', array('id' => $user->id));
				}
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
				return View::make('profile.settings')
						->with('user', $user);
			}
		}

		return App::abort(404);
	}
}