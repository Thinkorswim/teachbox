<?php

class AuthController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Auth::check()){
			return View::make('home.after');
		}else{
			return View::make('home.before');
		}
	}

	public function recover()
	{
		if(Auth::check()){
			return Redirect::route('home');
		}else{
			return View::make('home.recover');
		}
	}

	public function postRecover()
	{
		$validator = Validator::make(Input::all(), array(
			'email' => 'required|email'
		));

		if($validator->fails()){
			return Redirect::route('password-recovery')
					->withErrors($validator)
					->withInput();
		}else{

			$user = User::where('email', '=', Input::get('email'))
							  ->where('active','=', '1');

			if($user->count()){
				$user = $user->first();

				$code 				 = str_random(60);
				$password  			 = str_random(10);

				$user->code 		 = $code;
				$user->password_temp = Hash::make($password);

				if($user->save()){
					Mail::send('emails.auth.recover', array(
						'link' => URL::route('password-recovery-code', $code),
						'username' => $user->username,
						'password' => $password
					), function($message) use ($user){
						$message->to($user->email,$user->username)->subject('Your new Teachbox password!');
					});	

					return Redirect::route('home')
							->with('global-positive', 'We have send you an email with new password.');
				}
			}else{
					return Redirect::route('password-recovery')
							->with('global-negative', 'This email could not be found.');
			}



		}

		return Redirect::route('password-recovery')
				->with('global-negative', 'Could not request password.');
	}

	public function recoverCode($code){
		$user = User::where('code','=',$code)
		 	  ->where('password_temp','!=', '');

		if($user->count()){
			$user = $user->first();

			$user->password 	 = $user->password_temp;
			$user->password_temp = '';
			$user->code          = '';

			if($user->save()){
				return Redirect::route('home')
				   ->with('global-positive', 'You account has been recoverd. You may now login with your new password.');
			}

			return Redirect::route('home')
				   ->with('global-negative', 'Could not recover your account.');
		}
	}

	public function signout(){
		if(Auth::check()){
			Auth::logout();
			return Redirect::route('home');
		}else{
			return Redirect::route('home');
		}
	}

	/**
	 * Login user with facebook
	 *
	 * @return void
	 */

	public function fbLogin() {

	    // get data from input
	    $code = Input::get( 'code' );

	    // get fb service
	    $fb = OAuth::consumer( 'Facebook' );

	    // check if code is valid

	    // if code is provided get user data and sign in
	    if ( !empty( $code ) ) {

	        // This was a callback request from facebook, get the token
	        $token = $fb->requestAccessToken( $code );

	        // Send a request with it
	        $result = json_decode( $fb->request( '/me' ), true );
	
		$signed = User::where('email','=',$result['email']);

		if($signed->count()){
				$auth = Auth::attempt(array(
					'email' => $result['email'],
					'password' => $result['id'],
				), true);

				if($auth){
					return Redirect::route('home');		 		
				}else{
					return Redirect::route('home')
							->with('global-negative', 'Email/password combination wrong or account not activated.');
				}	
		}else{
				$user = User::create(array(
					'email' 	=> $result['email'] ,
					'name' 		=> $result['name'] ,
					'password'  => Hash::make($result['id']),
					'active'	=> 0
				));

			if($user){
	        	$auth = Auth::attempt(array(
					'email' => $result['email'],
					'password' => $result['id'],
				), true);

				if($auth){
					return Redirect::route('home');		 		
				}else{
					return Redirect::route('home')
							->with('global-negative', 'Email/password combination wrong or account not activated.');
				}	
	  		}
	  	}

	  	}else {
		        // get fb authorization
		        $url = $fb->getAuthorizationUri();

		        // return to facebook login url
		         return Redirect::to( (string)$url );
	    	
	    }
	}

	public function postSign(){
		$validator = Validator::make(Input::all(),
			array(
				'email_s' => 'required|email',
				'password_s' => 'required'
				)
			);
		if($validator->fails()){
			return Redirect::route('home')
					->withErrors($validator)
					->withInput();
		}else{

			$remember = (Input::has('remember')) ? true : false;

			$auth = Auth::attempt(array(
					'email' => Input::get('email_s'),
					'password' => Input::get('password_s'),
					'active' => 1
				), $remember);

			if($auth){
				return Redirect::intended('/');		 		
			}else{
				return Redirect::route('home')
						->with('global-negative', 'Email/password combination wrong or account not activated.');
			}	
		}

		return Redirect::route('home')
						->with('global-negative', 'There was a problem signing you in.');

	}

	public function postCreate(){
		print_r(Input::all());
		$validator = Validator::make(Input::all(), 
			array(
				'email' => 'required|max:50|email|unique:users',
				'name' => 'required|max:40|min:4',
				'password' => 'required|max:20|min:6',
				'password_again' =>'required|same:password'
				)
			);	

		if($validator->fails()){
			return Redirect::route('create-account')
						->withErrors($validator)
						->withInput();
		}else{
			$email     = Input::get('email');
			$name      = Input::get('name');
			$password  = Input::get('password');

			//Activation code
			$code  = str_random(60);

			$user = User::create(array(
					'email' 	=> $email,
					'name' 		=> $name,
					'password'  => Hash::make($password),
					'code' 		=> $code,
					'active'	=> 0
				));

			if($user){

		Mail::send('emails.auth.activate', array('link' => URL::route('activate', $code), 'name' => $name), function($message) use ($user) {
			$message->to( $user->email , $user->name)->subject('Teachbox activation');
		} );

				return Redirect::route('home')
							->with('global-positive', 'You account has been created. We have sent you and email to activate your account');
			}
		}
	}

	public function activate($code){
		$user = User::where('code', '=', $code)->where('active', '=', 0);

		if($user->count()){
			$user = $user->first();

			$user->active =1;
			$user->code   ='';

			if($user->save()){
				return Redirect::route('home')
						->with('global-positive', 'Your account was activated');
			}
		} 

		return Redirect::route('home')
						->with('global-negative', 'We could not activate your account');
	}
}
