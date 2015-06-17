<?php

class BusinessController extends \BaseController {

	public function subscribe() {
		if (Auth::check()) {

			
			return View::make('business.subscribe');
		} else {
			return Redirect::action('AuthController@index');
		}
	}

	public function choose() {
		if (Auth::check()) {

			
			return View::make('business.subscribe');
		} else {
			return Redirect::action('AuthController@index');
		}
	}


}
