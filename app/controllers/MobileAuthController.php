<?php 

class MobileAuthController extends \BaseController {
	public function postSign(){
		$validator = Validator::make(Input::all(),
			array(
				'email' => 'required|email',
				'password' => 'required'
				)
			);
		if($validator->fails()){
			
		}else{

			$remember = true;

			$auth = Auth::attempt(array(
					'email' => Input::get('email'),
					'password' => Input::get('password'),
					'active' => 1
				), $remember);

			if($auth){
				return Response::json(array('authentication' => '1'));
			}
		}

		return Response::json(array('authentication' => '0'));
	}



}