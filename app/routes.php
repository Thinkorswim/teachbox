<?php

	//CSRF protection
	// POST METHODS ----------------------------------------------------------------

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

		Route::post('/course/{id}/lesson/{order}/settings', array(
			      'as' => 'post-edit-lesson',
			      'uses' => 'CourseController@postLessonEdit'
		));

		Route::post('/course/{id}/lesson/{order}/video-change',array(
				  'as' => 'post-change-video',
				  'uses' => 'CourseController@postChangeVideo'
			));	

		Route::post('/course/{id}/lesson/{order}/test', array(
			      'as' => 'post-lesson-test',
			      'uses' => 'CourseController@postLessonTest'
		));
  		//Comment
		Route::post('/course/{id}/lesson/{order}/comment', array(
     			'as'   => 'post-comment',
     			'uses' => 'CourseController@postComment'
  		));
		Route::post('/search', array(
			      'as' => 'post-search',
			      'uses' => 'SearchController@postSearch'
		));

		Route::post('/course/{id}/question',array(
				 'as' => 'post-course-question',
				 'uses' => 'CourseController@postCourseQuestion'
		));

		Route::post('/course/{id}/question/{question}',array(
				 'as' => 'post-course-answer',
				 'uses' => 'CourseController@postCourseAnswer'
		));

		Route::post('/user/{id}/follow', array(
					'as'   => 'post-follow',
					'uses' => 'ProfileController@postFollow'
		));

		
		Route::post('/admin/users/{id}/edit', array(
					'as'   => 'post-admin-user',
					'uses' => 'AdminController@updateUser'
		));

		Route::post('/admin/courses/{id}/edit', array(
					'as'   => 'post-admin-course',
					'uses' => 'AdminController@updateCourse'
		));

		//UNFOLLOWING
		Route::post('/user/{id}/unfollow', array(
     			'as'   => 'post-unfollow',
     			'uses' => 'ProfileController@postUnfollow'
  		));
		//Making admin
		Route::post('/admin/users/{id}/make-admin', array(
				'as'   => 'admin-make',
				'uses' => 'AdminController@makeAdmin'
		));

		//Approve course
		Route::post('/admin/courses/approve/{id}', array(
				'as'   => 'post-admin-course-approve',
				'uses' => 'AdminController@approveCourse'
		));		

		//Delete course
		Route::post('/admin/courses/delete/{id}', array(
				'as'   => 'post-admin-course-delete',
				'uses' => 'AdminController@deleteCourse'
		));	

		//Approve lesson
		Route::post('/admin/courses/lessons-approve/{id}', array(
				'as'   => 'post-admin-lesson-approve',
				'uses' => 'AdminController@approveLesson'
		));	

		//Delete lesson
		Route::post('/admin/courses/lessons-delete/{id}', array(
				'as'   => 'post-admin-lesson-delete',
				'uses' => 'AdminController@deleteLesson'
		));

		//Subscribe
		Route::post('/home/subscribe', array(
				'as'   => 'post-subscribe',
				'uses' => 'AuthController@postSubscribe'
		));	

		Route::post('/messages/send', array(
				'as'   => 'send-message',
				'uses' => 'MessagesController@sendMessage'
		));

		Route::post('/messages/get', array(
				'as'   => 'get-message',
				'uses' => 'MessagesController@getMessage'
		));

		Route::post('/messages/get-new', array(
				'as'   => 'get-new-message',
				'uses' => 'MessagesController@getNewMessage'
		));

		Route::post('/messages/get-notification', array(
				'as'   => 'get-notification',
				'uses' => 'MessagesController@getNotification'
		));

	});
	

	//Pofile ---------------------------------------------------------------------

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

		// COURSES

		Route::get('/user/{id}/courses', array(
				'as'   => 'user-courses',
				'uses' => 'ProfileController@userCourses'
		));

		// FOLLOWERS

		Route::get('/user/{id}/followers', array(
				'as'   => 'user-followers',
				'uses' => 'ProfileController@userFollowers'
		));

		// FOLLOWING

		Route::get('/user/{id}/following', array(
				'as'   => 'user-following',
				'uses' => 'ProfileController@userFollowing'
		));


	// Courses -------------------------------------------------------------------

		// CREATE COURSE
			Route::get('/create_course',array(
					 'as' => 'create_course',
					 'uses' => 'CourseController@create'
			));

		// EXPLORE COURSES
			Route::get('/explore',array(
					 'as' => 'explore',
					 'uses' => 'CourseController@explore'
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

		//Edit lesson 
			Route::get('/course/{id}/lesson/{order}/settings',array(
					 'as' => 'edit-lesson',
					 'uses' => 'CourseController@lessonEdit'
			));

		//Change lesson video 
			Route::get('/course/{id}/lesson/{order}/video-change',array(
					 'as' => 'change-lesson-video',
					 'uses' => 'CourseController@changeVideo'
			));		

		//Course Questions
			Route::get('/course/{id}/question',array(
					 'as' => 'course-question',
					 'uses' => 'CourseController@courseQuestion'
			));

		// Course Answers
			Route::get('/course/{id}/question/{question}',array(
					 'as' => 'course-answers',
					 'uses' => 'CourseController@courseAnswer'
			));

		// Course Students
			Route::get('/course/{id}/students',array(
					 'as' => 'course-students',
					 'uses' => 'CourseController@courseStudents'
			));

	//Search ----------------------------------------------------------------------------------
		Route::get('/search/{keyword}',array(
					 'as' => 'search',
					 'uses' => 'SearchController@search'
			));	
		Route::get('/search-user/{keyword}',array(
					 'as' => 'search-user',
					 'uses' => 'SearchController@searchUser'
			));	

		Route::get('/search',array(
					 'as' => 'search-front',
					 'uses' => 'SearchController@searchFront'
			));	

		Route::get('getdata', 'SearchController@autoComplete');


	//Facebook Login (GET) ----------------------------------------------------------------------
		Route::get('/fb-login', array(
				 'as' => 'fb-login',
				 'uses' => 'AuthController@fbLogin'
		));

	//Password Recovery (GET) --------------------------------------------------------------------
		Route::get('/password-recovery', array(
				 'as' => 'password-recovery',
				 'uses' => 'AuthController@recover'
		));

		Route::get('/password-recovery/{code}', array(
				 'as' => 'password-recovery-code',
				 'uses' => 'AuthController@recoverCode'
		));

	//Create Account (GET) ------------------------------------------------------------------------
		Route::get('/', array( 
				'as' => 'home',
				'uses' => 'AuthController@index'
		));

		Route::get('/activate/{code}', array(
				'as' => 'activate',
				'uses' => 'AuthController@activate'

		));

	//Sign out (GET) --------------------------------------------------------------------------------

		Route::get('/sign-out', array(
			'as' => 'sign-out',
			'uses' => 'AuthController@signout'

		));
	
	// Admin ---------------------------------------------------------------------------------------

		Route::get('/admin', array(
				'as' => 'admin-home-show',
				'uses' => 'AdminController@adminHome'

		));

		Route::get('/admin/users', array(
				'as' => 'admin-users-show',
				'uses' => 'AdminController@showUsers'

		));
		Route::get('/admin/courses/approve', array(
				'as' => 'admin-courses-approve',
				'uses' => 'AdminController@coursesApprove'

		));

		Route::get('/admin/courses/lessons-approve', array(
		'as' => 'admin-lessons-approve',
		'uses' => 'AdminController@lessonsApprove'
		));

		Route::get('/admin/users/{id}/edit', array(
				'as' => 'admin-user-edit',
				'uses' => 'AdminController@editUser'

		));
		

		Route::get('/admin/courses', array(
				'as' => 'admin-courses-show',
				'uses' => 'AdminController@showCourses'

		));

		Route::get('/admin/courses/{id}/edit', array(
				'as' => 'admin-course-edit',
				'uses' => 'AdminController@editCourse'

		));

	// MOBILE

		Route::get('/mobile/sign-in', array(
			'as' => 'mobile-sign-in',
			'uses' => 'MobileAuthController@postSign'

		));

	//Feedback

		Route::get('/feedback', array(
			'as' => 'feedback',
			'uses' => 'ProfileController@feedback'

		));

	//Privacy

		Route::get('/privacy', array(
			'as' => 'privacy',
			'uses' => 'ProfileController@privacy'

		));

	//Terms

		Route::get('/terms', array(
			'as' => 'terms',
			'uses' => 'ProfileController@terms'

		));

	//Adverise

		Route::get('/advertising', array(
			'as' => 'advertise',
			'uses' => 'ProfileController@advertising'

		));

	//Contacts

		Route::get('/contacts', array(
			'as' => 'contacts',
			'uses' => 'ProfileController@contacts'

		));

	// Messages

		Route::get('/messages', array(
			'as' => 'messages',
			'uses' => 'MessagesController@index'
		));


class Convert {

    public function fire($job, $data)
    {
    	$ffmpeg = $data["ffmpeg"];
    	$video = $data["video"];
    	$path = $data["path"];

		$cmd = "$ffmpeg -i $video -vcodec libvpx -cpu-used -5 -deadline good $path/video.webm";
		shell_exec($cmd);

        $job->delete();
    }

}

App::missing(function($exception)
{
    return Response::view('errors.missing', array('url' => Request::url()), 404);
});