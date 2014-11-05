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
	});

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
