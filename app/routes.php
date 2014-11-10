<?php

	//CSRF protection
	Route::group(array('before' => 'csrf'), function(){
		Route::post('/', array( 
			'as' => 'create-account',
			'uses' => 'AuthController@postCreate'
		));
		Route::post('/sign-in', array( 
			'as' => 'sign-in',
			'uses' => 'AuthController@postSign'
		));

		Route::post('/password-recovery', array(
			 'as' => 'password-send',
			 'uses' => 'AuthController@postRecover'
			));
	});


	//Pofile
		Route::get('/user/{id}/settings', array(
				'as'   => 'user-settings',
				'uses' => 'ProfileController@userSettings'
		));

		Route::post('/user/{id}/settings/picture-change', array(
				'as'   => 'user-picture',
				'uses' => 'ProfileController@userPic'
		));


		Route::get('/user/{id}/picture-change',array(
				 'as' => 'change-picture',
				 'uses' => 'ProfileController@changePic'
		));
		
		Route::get('/user/{id}',array(
				 'as' => 'user-profile',
				 'uses' => 'ProfileController@user'
		));



	//Facebook Login (GET)
		Route::get('/fb-login', array(
				 'as' => 'fb-login',
				 'uses' => 'AuthController@fbLogin'
		));

	//Password Recovery (GET)
		Route::get('/password-recovery', array(
				 'as' => 'password-recovery',
				 'uses' => 'AuthController@recover'
		));

		Route::get('/password-recovery/{code}', array(
				 'as' => 'password-recovery-code',
				 'uses' => 'AuthController@recoverCode'
		));

	//Create Account (GET)
		Route::get('/', array( 
				'as' => 'home',
				'uses' => 'AuthController@index'
		));

		Route::get('/activate/{code}', array(
				'as' => 'activate',
				'uses' => 'AuthController@activate'

		));

	//Sign out (GET)

		Route::get('/sign-out', array(
			'as' => 'sign-out',
			'uses' => 'AuthController@signout'

		));