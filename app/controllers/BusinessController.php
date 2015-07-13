<?php

class BusinessController extends \BaseController {

	public function subscribe() {
		if (Auth::check()) {

			
			return View::make('business.subscribe');
		} 
	}

	public function choose() {
		if (Auth::check()) {

			
			return View::make('business.subscribe');
		} else {
			return Redirect::action('AuthController@index');
		}
	}

	public function businessinfo() {
			return View::make('business.business-info');
	}
}
