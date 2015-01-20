<?php

class CourseController extends \BaseController {

	public function create ()
	{
		if(Auth::check()){
			return View::make('courses.create');
		}else{
			return View::make('home.before');
		}
	}

	public function postCreate()
	{
		if (Auth::check()){
			if(Input::hasFile('image') && (Input::file('image')->getClientOriginalExtension() == "jpg" || Input::file('image')->getClientOriginalExtension() == "png")){

				$validator = Validator::make(Input::all(),
					array(
							'name' 				 => 'required|min:4|max:40',
							'description'		 => 'required|min:30|max:400',
					));

				if($validator->fails()){		
					return Redirect::action('CourseController@create')
							->withErrors($validator);
				}else{

					$image = Input::file('image');
					$newImage = Image::make($image->getRealPath());
					$filename = $image->getClientOriginalName();
					$ratio = 1;
					$width = $newImage->width();
					$newImage->fit($width, intval($width / $ratio));


					$name 	 = Input::get('name');
					$description = Input::get('description');

					$user_id = Auth::user()->id;
					$course = Course::create(array(
							'name' 		=> $name,
							'user_id'  => $user_id,
							'description' => $description,
						));

					if($course){
						    $resultMake  = File::makeDirectory(public_path() .'/courses/' . $course->id );
						    if($newImage->save('public/courses/' . $course->id . '/' . $filename)){
						    	$course->pic    = $image->getClientOriginalName();
						    	$course->save();
						    }
							$user_id = Auth::user()->id;
							$userCourse = UserCourse::create(array(
								'course_id' => $course->id,
								'user_id'  => $user_id,
							));
			    	if($userCourse){
						return Redirect::route('course-page', array('id' => $course->id));
					
					}else{
						return Redirect::route('course-page', array('id' => $course->id))
												->with('global-negative', 'You could not join this course.');
						 }

						return View::make('courses.join')
								->with('course', $course);		

					}

						return Redirect::action('CourseController@create')
								->with('global-negative', 'Your profile settings could not be created.');
				}
			
			}else{
					return Redirect::action('CourseController@create')
							->with('global-negative', 'Your profile settings could not be created.');
			}
			
	    }
	}

	public function course($id)
	{
		$course = Course::find($id);
		if(Auth::check()){

		$isJoined = UserCourse::where(function ($query) {
			    $query->where('user_id', '=', Auth::user()->id);
			})->where(function ($query) use ($id) {
			    $query->where('course_id', '=', $id);
			})->count();

			$lessonList = Lesson::where('course_id', '=', $id)->get();

			$user = User::find($course->user_id);

			if($isJoined){
				return View::make('courses.join')
							->with(array('course' => $course, 'lessonList' => $lessonList, 'user' => $user ));
			}else{
				return View::make('courses.not_join')
							->with(array('course' => $course, 'user' => $user ));
			}
		}else{
			$user = User::find($course->user_id);
			return View::make('courses.not_join')
							->with(array('course' => $course, 'user' => $user ));
		}
	}

	public function postJoin($id)
	{
		if(Auth::check()){

			$user_id = Auth::user()->id;
			$userCourse = UserCourse::create(array(
					'course_id' => $id,
					'user_id'  => $user_id,
			));
		    if($userCourse){
				return Redirect::route('course-page', array('id' => $id));
			}else{
				return Redirect::route('course-page', array('id' => $id))
											->with('global-negative', 'You could not join this course.');
			}
		}else{
			return View::make('home.before');
		}
	}

	public function courseEdit($id)
	{
		if(Auth::check()){
			$course = Course::find($id);
			if(Auth::user()->id==$course->user_id){
			return View::make('courses.edit')
					->with('course', $course);
			}else{
				return Redirect::route('course-page', array('id' => $id));
			}

		}else{
			return View::make('home.before');
		}
	}

	public function postCourseEdit($id)
	{
		if(Auth::check()){
			$validator = Validator::make(Input::all(),
				array(
						'description' 			 => 'min:30|max:400',
				));

			if($validator->fails()){		
				return Redirect::action('CourseController@courseEdit',[$id])
						->withErrors($validator);

			}else{
				$courseEdit = Course::find($id);

				$description = Input::get('description');
				if(Input::hasFile('image') && (Input::file('image')->getClientOriginalExtension() == "jpg" || Input::file('image')->getClientOriginalExtension() == "png")){
					

					$image = Input::file('image');

					$newImage = Image::make($image->getRealPath());
					$filename = $image->getClientOriginalName();
					$ratio = 1;
					$width = $newImage->width();
					$newImage->fit($width, intval($width / $ratio));

					if($newImage->save('public/courses/' . $courseEdit->id . '/' . $filename)){
						    	$courseEdit->pic    = $image->getClientOriginalName();
				    }
				}

				

				$courseEdit->description = $description;

					if($courseEdit->save()){
						return Redirect::route('course-page', array('id' => $id));
					}
			}

			return Redirect::action('CourseController@courseEdit',[$id])
					->with('global-negative', 'Your course settings could not be changed.');
		}
	}


	public function courseAdd($id)
	{
		if(Auth::check()){
			$course = Course::find($id);

			if(Auth::user()->id==$course->user_id){
			return View::make('courses.add')
					->with('course', $course);
			}else{
				return Redirect::route('course-page', array('id' => $id));
			}
		
		}else{
			return View::make('home.before');
		}
	}

	public function courseLesson($id,$lesson)
	{
		if(Auth::check()){
			$course = Course::find($id);
			$lesson = Lesson::where(function ($query) use ($lesson) {
			    $query->where('order', '=', $lesson);
			})->where(function ($query) use ($id) {
			    $query->where('course_id', '=', $id);
			})->first();

			return View::make('courses.lesson')
					->with(array('course' => $course, 'lesson' => $lesson));
		}else{
			return View::make('home.before');
		}
	}

	public function coursePostAdd($id){
	
		if(Auth::check()){
		 	if(Input::hasFile('video') && (Input::file('video')->getClientOriginalExtension() == "mp4")){

				$validator = Validator::make(Input::all(),
					array(
							'name' 				 => 'required|min:4|max:50',
							'description'		 => 'required|min:30|max:400',
					));

				if($validator->fails()){		
				return Redirect::route('course-add', array('id' => $id))
							->withErrors($validator);
				}else{

					$name 	 = Input::get('name');
					$description = Input::get('description');

				 $course = Course::find($id);
				 $order = Lesson::where('course_id', '=', $id)->count() + 1;
		   		 $resultMake  = File::makeDirectory(public_path() .'/courses/' . $course->id . '/' . $order);

	   			 $file = Input::file('video');
		   		 $filename = $file->getClientOriginalName();
		   		 $path = public_path().'/courses/'. $course->id . '/' . $order;
		   		 $file->move($path, $filename);

		   		 $lesson = Lesson::create(array(
						'filepath' => $filename,
						'course_id'  => $id,
						'name'       => $name,
						'description' => $description,
						'order'       => $order,
						));

		   		  if($lesson){
					return Redirect::route('course-page', array('id' => $id));
				}else{
					return Redirect::route('course-page', array('id' => $id))
												->with('global-negative', 'You could not join this course.');
				}
			}

			}else{
					return Redirect::route('course-add', array('id' => $id));
			}
		}else{

					return View::make('home.before');
		}
	}

	public function courseQuestion($id)
	{
		if(Auth::check()){
			$course = Course::find($id);

			if(Auth::user()->id==$course->user_id){
			return View::make('courses.question')
					->with('course', $course);
			}else{
				return Redirect::route('course-page', array('id' => $id));
			}
		
		}else{
			return View::make('home.before');
		}
	}

	public function courseAnswer($id)
	{
		if(Auth::check()){
			$course = Course::find($id);

			if(Auth::user()->id==$course->user_id){
			return View::make('courses.answer')
					->with('course', $course);
			}else{
				return Redirect::route('course-page', array('id' => $id));
			}
		
		}else{
			return View::make('home.before');
		}
	}

}

