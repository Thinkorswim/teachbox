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

		Route::post('/user/{id}/settings/picture-change', array(
					'as'   => 'post-change-picture',
					'uses' => 'ProfileController@postChangePic'
		));

		Route::post('/user/{id}/settings/password-change', array(
					'as'   => 'post-change-password',
					'uses' => 'ProfileController@postChangePassword'
		));
		
		Route::post('/user/{id}/settings', array(
				'as'   => 'post-user-settings',
				'uses' => 'ProfileController@postUserSettings'
		));

		Route::post('/create_course',array(
				 'as' => 'create-course',
				 'uses' => 'CourseController@postCreate'
		));

		Route::post('/course/{id}',array(
				 'as' => 'join-course',
				 'uses' => 'CourseController@postJoin'
		));

		Route::post('/course/{id}/add',array(
					 'as' => 'course-post-add',
					 'uses' => 'CourseController@coursePostAdd'
		));

		Route::post('/course/{id}/edit', array(
			      'as' => 'post-edit-course',
			      'uses' => 'CourseController@postCourseEdit'
		));

		Route::post('/search', array(
			      'as' => 'post-search',
			      'uses' => 'SearchController@postSearch'
		));
	});


	//Pofile --------------------------------------------------

		Route::get('/user/{id}/settings', array(
				'as'   => 'user-settings',
				'uses' => 'ProfileController@userSettings'
		));

		// PICTURE CHANGE

			Route::get('/user/{id}/picture-change',array(
					 'as' => 'change-picture',
					 'uses' => 'ProfileController@changePic'
			));

		// PASSWORD CHANGE

			Route::get('/user/{id}/settings/password-change',array(
						 'as' => 'change-password',
						 'uses' => 'ProfileController@changePassword'
			));
			
		Route::get('/user/{id}',array(
				 'as' => 'user-profile',
				 'uses' => 'ProfileController@user'
		));

	// Courses ---------------------------------------------------------------

		// CREATE COURSE
			Route::get('/create_course',array(
					 'as' => 'create_course',
					 'uses' => 'CourseController@create'
			));

		// COURSE PAGE
			Route::get('/course/{id}',array(
					 'as' => 'course-page',
					 'uses' => 'CourseController@course'
			));

		//Edit Course
			Route::get('/course/{id}/edit',array(
					 'as' => 'course-edit',
					 'uses' => 'CourseController@courseEdit'
			));

		//Add lesson
			Route::get('/course/{id}/add',array(
					 'as' => 'course-add',
					 'uses' => 'CourseController@courseAdd'
			));

		//View lesson 
			Route::get('/course/{id}/lesson/{order}',array(
					 'as' => 'course-lesson',
					 'uses' => 'CourseController@courseLesson'
			));

	//Search
		Route::get('/search',array(
					 'as' => 'search',
					 'uses' => 'CourseController@courseLesson'
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