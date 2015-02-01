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
			$key = Input::get('key');

			$auth = Auth::attempt(array(
					'email' => Input::get('email'),
					'password' => Input::get('password'),
					'active' => 1
				), $remember);

			if($auth && $key == "T74uvE0ILWsS1SvdUZem"){
				$token = generateRandomString(20);

				$user = User::find(Auth::id());
				$user->android_token = $token;

				if($user->save()){
					return Response::json(array('authentication' => '1', 'id' => $user->id, 'token' => $token));
				}
			}
		}

		return Response::json(array('authentication' => '0'));
	}


	public function fbLogin(){
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

	}



}