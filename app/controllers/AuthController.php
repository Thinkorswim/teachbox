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

		$user = Auth::user();


		$timeline = DB::select( DB::raw("SELECT users.id, users.email, follows.follower_id, follows.created_at FROM users, follows 
										 WHERE (follows.follower_id IN (SELECT following_id FROM follows WHERE follows.follower_id = '$user->id') OR follows.follower_id = '$user->id') AND follows.following_id = users.id
	        							 UNION 
										 SELECT courses.id, user_courses.user_id ,courses.user_id, user_courses.created_at FROM user_courses, courses 
										 WHERE (user_courses.user_id IN (SELECT following_id FROM follows WHERE follows.follower_id = '$user->id') OR user_courses.user_id = '$user->id') AND user_courses.course_id = courses.id  AND courses.approved = 1
	        							 UNION 
										 SELECT courses.id, courses.user_id, courses.name, courses.created_at FROM courses 
										 WHERE (courses.user_id IN (SELECT following_id FROM follows WHERE follows.follower_id = '$user->id') OR courses.user_id = '$user->id') AND courses.approved = 1

										 ORDER BY created_at DESC
									 ") );
	

		if(!(count($timeline) < 5)){
			$perPage = 5;
			$currentPage = Input::get('page', 1) - 1;
			$pagedData = array_slice($timeline, $currentPage * $perPage, $perPage);
			$timeline = Paginator::make($pagedData, count($timeline), $perPage);
		}

			return View::make('home.after')->with(array('timeline' => $timeline));
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

	    $code = Input::get( 'code' );

	    $fb = OAuth::consumer( 'Facebook' );

	    if ( !empty( $code ) ) {

	        $token = $fb->requestAccessToken( $code );

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
					'active'	=> 0,
				));

			if($user){
				$user->pic = 'user.png';
				$user->save();
				$resultMake  = File::makeDirectory(public_path() .'/img/' . $user->id );
				$resultCopy  = File::copy(public_path() .'/img/user.png' , public_path() .'/img/' . $user->id . '/user.png');
				$resultCopyThumb  = File::copy(public_path() .'/img/user-100x100.png' , public_path() .'/img/' . $user->id . '/user-100x100.png');

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
		        $url = $fb->getAuthorizationUri();

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
			$user->pic    ='user.png';

			if($user->save()){
				$resultMake  = File::makeDirectory(public_path() .'/img/' . $user->id );
				$resultCopy  = File::copy(public_path() .'/img/user.png' , public_path() .'/img/' . $user->id . '/user.png');
				$resultCopyThumb  = File::copy(public_path() .'/img/user-100x100.png' , public_path() .'/img/' . $user->id . '/user-100x100.png');

				if($resultMake && $resultCopy && $resultCopyThumb){
					return Redirect::route('home')
							->with('global-positive', 'Your account was activated.');
				}else{
					return Redirect::route('home')
							->with('global-negative', 'Something terrible happen. We are sorry for the inconvenience. You may need to create a new account or contact our support.');
				}
			}
		} 

		return Redirect::route('home')
						->with('global-negative', 'We could not activate your account. It may');
	}
}
