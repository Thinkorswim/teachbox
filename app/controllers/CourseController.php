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
					$symbols = array("+", "!", "@",  "$",  "^", "&", "*");
					$replace = array("", "", "",  "",  "", "", "");
					$image = Input::file('image');
					$newImage = Image::make($image->getRealPath());
					$newImage1 = Image::make($image->getRealPath());
					$filename = $image->getClientOriginalName();
					$filename  =  str_replace($symbols, $replace, $filename);
					$ratio = 1;
					$ratio1 = 3/2;
					$width = $newImage->width();
					$newImage->fit($width, intval($width / $ratio));
					$newImage1->fit($width, intval($width / $ratio1));


					$name 	 = Input::get('name');
					$description = Input::get('description');

					$message = nl2br($description);
					$description = trim($message);

					$user_id = Auth::user()->id;
					$course = Course::create(array(
							'name' 		=> $name,
							'user_id'  => $user_id,
							'description' => $description,
						));

					if($course){
						    $resultMake  = File::makeDirectory(public_path() .'/courses/' . $course->id );
						    if($newImage->save('public/courses/' . $course->id . '/' . $filename) && $newImage1->save('public/courses/' . $course->id . '/3x2' . $filename)){
						    	$course->pic    = $filename;
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
		$studentCount = UserCourse::where('course_id', '=', $id)->count();	
		if ($studentCount > 999){
			$thousand = substr($studentCount, 0, 1);
			$hundred = substr($studentCount, 1, 1);
			$studentCount = $thousand . '.'. $hundred . 'k';
		}
		elseif ($studentCount > 999999) {
			$million = substr($studentCount, 0, 1);
			$thousand = substr($studentCount, 1, 1);
			$studentCount = $million . '.'. $thousand . 'm';
		}
		
		if(Auth::check() && ($course->approved == 1 || $course->user_id == Auth::user()->id)){

		$isJoined = UserCourse::where(function ($query) {
			    $query->where('user_id', '=', Auth::user()->id);
			})->where(function ($query) use ($id) {
			    $query->where('course_id', '=', $id);
			})->count();

			$lessonList = Lesson::where('course_id', '=', $id)->get();

			$user = User::find($course->user_id);

			if($isJoined){
				return View::make('courses.join')
							->with(array('course' => $course, 'lessonList' => $lessonList, 'user' => $user, 'studentCount' => $studentCount ));
			}else{
				return View::make('courses.not_join')
							->with(array('course' => $course, 'user' => $user, 'studentCount' => $studentCount ));
			}
		}else{
			$user = User::find($course->user_id);
			return View::make('courses.not_join')
							->with(array('course' => $course, 'user' => $user, 'studentCount' => $studentCount ));
		}
	}

	public function postJoin($id)
	{
		$course = Course::find($id);
		if(Auth::check() && $course->approved == 1){

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
		$course = Course::find($id);
		$studentCount = UserCourse::where('course_id', '=', $id)->count();	
		if ($studentCount > 999){
			$thousand = substr($studentCount, 0, 1);
			$hundred = substr($studentCount, 1, 1);
			$studentCount = $thousand . '.'. $hundred . 'k';
		}
		elseif ($studentCount > 999999) {
			$million = substr($studentCount, 0, 1);
			$thousand = substr($studentCount, 1, 1);
			$studentCount = $million . '.'. $thousand . 'm';
		}

		if(Auth::check() && ($course->approved == 1 || $course->user_id == Auth::user()->id)){
			if(Auth::user()->id==$course->user_id){
			
			$user = User::find($course->user_id);
			return View::make('courses.edit')
					->with(array('course' => $course, 'user' => $user, 'studentCount' => $studentCount ));
			}else{
				return Redirect::route('course-page', array('id' => $id));
			}

		}else{
			return View::make('home.before');
		}
	}

	public function postCourseEdit($id)
	{
		$course = Course::find($id);
		$studentCount = UserCourse::where('course_id', '=', $id)->count();	
		if ($studentCount > 999){
			$thousand = substr($studentCount, 0, 1);
			$hundred = substr($studentCount, 1, 1);
			$studentCount = $thousand . '.'. $hundred . 'k';
		}
		elseif ($studentCount > 999999) {
			$million = substr($studentCount, 0, 1);
			$thousand = substr($studentCount, 1, 1);
			$studentCount = $million . '.'. $thousand . 'm';
		}

		if(Auth::check() && ($course->approved == 1 || $course->user_id == Auth::user()->id) && $course->user_id == Auth::user()->id){
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
					$symbols = array("+", "!", "@",  "$",  "^", "&", "*");
					$replace = array("", "", "",  "",  "", "", "");
					$newImage = Image::make($image->getRealPath());
					$newImage1 = Image::make($image->getRealPath());
					$filename = $image->getClientOriginalName();
					$filename  =  str_replace($symbols, $replace, $filename);
					$ratio = 1;
					$ratio1 = 3/2;
					$width = $newImage->width();
					$newImage->fit($width, intval($width / $ratio));
					$newImage1->fit($width, intval($width / $ratio1));

					if($newImage->save('public/courses/' . $courseEdit->id . '/' . $filename)&& $newImage1->save('public/courses/' . $course->id . '/3x2' . $filename)){
						    	$courseEdit->pic    = $filename;
				    }
				}

				
				$message = nl2br($description);
				$description = trim($message);

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
		$course = Course::find($id);
		$studentCount = UserCourse::where('course_id', '=', $id)->count();	
			if ($studentCount > 999){
				$thousand = substr($studentCount, 0, 1);
				$hundred = substr($studentCount, 1, 1);
				$studentCount = $thousand . '.'. $hundred . 'k';
			}
			elseif ($studentCount > 999999) {
				$million = substr($studentCount, 0, 1);
				$thousand = substr($studentCount, 1, 1);
				$studentCount = $million . '.'. $thousand . 'm';
			}


		if(Auth::check() && ($course->approved == 1 || $course->user_id == Auth::user()->id) && $course->user_id == Auth::user()->id){
			$course = Course::find($id);

			if(Auth::user()->id==$course->user_id){

				$user = User::find($course->user_id);
				return View::make('courses.add')
						->with(array('course' => $course, 'user' => $user, 'studentCount' => $studentCount ));
			}else{
				return Redirect::route('course-page', array('id' => $id));
			}
		
		}else{
			return View::make('home.before');
		}
	}

	public function courseLesson($id,$lesson)
	{
		$studentCount = UserCourse::where('course_id', '=', $id)->count();	
		if(Auth::check()){
			$course = Course::find($id);

			$isJoined = UserCourse::where(function ($query) {
			    $query->where('user_id', '=', Auth::user()->id);
			})->where(function ($query) use ($id) {
			    $query->where('course_id', '=', $id);
			})->count();

			if($isJoined && ($course->approved == 1 || $course->user_id == Auth::user()->id)){
				$lesson = Lesson::where(function ($query) use ($lesson) {
				    $query->where('order', '=', $lesson);
				})->where(function ($query) use ($id) {
				    $query->where('course_id', '=', $id);
				})->first();

				$lessonList = Lesson::where('course_id', '=', $id)->get();
				$creator = User::where('id', '=', $course->user_id)->first();

				$previousLesson = Lesson::where(function ($query) use ($lesson) {
				    $query->where('order', '=', $lesson->order-1);
				})->where(function ($query) use ($id) {
				    $query->where('course_id', '=', $id);
				})->first();

				$nextLesson = Lesson::where(function ($query) use ($lesson) {
				    $query->where('order', '=', $lesson->order+1);
				})->where(function ($query) use ($id) {
				    $query->where('course_id', '=', $id);
				})->first();

				return View::make('courses.lesson')
						->with(array('course' => $course, 'currentLesson' => $lesson, 'nextLesson' => $nextLesson, 'previousLesson' => $previousLesson, 'lessonList' => $lessonList, 'creator' => $creator));
			}else{
					return View::make('courses.not_join')
							->with(array('course' => $course, 'studentCount' => $studentCount ));
			}
		}else{
			return View::make('home.before');
		}
	}

	public function coursePostAdd($id){
		$course = Course::find($id);
		if(Auth::check() && ($course->approved == 1 || $course->user_id == Auth::user()->id) && $course->user_id == Auth::user()->id){
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

				$message = nl2br($description);
				$description = trim($message);


				 $course = Course::find($id);
				 $order = Lesson::where('course_id', '=', $id)->count() + 1;
		   		 $resultMake  = File::makeDirectory(public_path() .'/courses/' . $course->id . '/' . $order);

	   			 $file = Input::file('video');
		   		 $filename = preg_replace('/\s+/', '', $file->getClientOriginalName());
		   		 $path = public_path().'/courses/'. $course->id . '/' . $order;
		   		 $file->move($path, $filename);

		   		 // Get Thumbnail
		   		 $ffmpeg = public_path().'/ffmpeg/ffmpeg';  
			 	 $video = $path.'/'.$filename;   
				 $image = $path.'/thumb.png';  
				 $interval = 1;  
			     $cmd = "$ffmpeg -i $video -deinterlace -an -ss $interval -f mjpeg -t 1 -r 1 -y $image 2>&1";
     		     shell_exec($cmd);

     		     if (File::exists($path.'/thumb.png')){
     		     	$image = Image::make($path.'/thumb.png');
					$image->fit(300, 200);
					$image->save($path.'/thumb300x200.png');

					$image2 = Image::make($path.'/thumb.png');
					$image2->fit(100, 100);
					$image2->save($path.'/thumb100x100.png');
     		     }
     		     

                 
		   		
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
			$studentCount = UserCourse::where('course_id', '=', $id)->count();	
			if ($studentCount > 999){
				$thousand = substr($studentCount, 0, 1);
				$hundred = substr($studentCount, 1, 1);
				$studentCount = $thousand . '.'. $hundred . 'k';
			}
			elseif ($studentCount > 999999) {
				$million = substr($studentCount, 0, 1);
				$thousand = substr($studentCount, 1, 1);
				$studentCount = $million . '.'. $thousand . 'm';
			}

			$isJoined = UserCourse::where(function ($query) {
			    $query->where('user_id', '=', Auth::user()->id);
			})->where(function ($query) use ($id) {
			    $query->where('course_id', '=', $id);
			})->count();

			$user = User::find($course->user_id);
			$questionList = CourseQuestion::where('course_id', '=', $id)->get();

			if($isJoined && ($course->approved == 1 || $course->user_id == Auth::user()->id)){
				return View::make('courses.question')
						->with(array('course' => $course, 'user' => $user, 'studentCount' => $studentCount, 'questionList' => $questionList ));
			}else{
				return Redirect::route('course-page', array('id' => $id));
			}
		
		}else{
			return View::make('home.before');
		}
	}

	public function postCourseQuestion($id)
	{
		if(Auth::check()){
			$course = Course::find($id);
			$studentCount = UserCourse::where('course_id', '=', $id)->count();	
			if ($studentCount > 999){
				$thousand = substr($studentCount, 0, 1);
				$hundred = substr($studentCount, 1, 1);
				$studentCount = $thousand . '.'. $hundred . 'k';
			}
			elseif ($studentCount > 999999) {
				$million = substr($studentCount, 0, 1);
				$thousand = substr($studentCount, 1, 1);
				$studentCount = $million . '.'. $thousand . 'm';
			}

			$isJoined = UserCourse::where(function ($query) {
			    $query->where('user_id', '=', Auth::user()->id);
			})->where(function ($query) use ($id) {
			    $query->where('course_id', '=', $id);
			})->count();

			$user = User::find($course->user_id);
			$questionList = CourseQuestion::where('course_id', '=', $id);

			$validator = Validator::make(Input::all(),
					array(
							'title' 			 => 'required|min:4|max:50',
							'question'		 => 'required|min:30|max:400',
					));

				if($validator->fails()){		
					return Redirect::route('course-question', array('id' => $id))
								->withErrors($validator);
				}else{

					$title 	 = Input::get('title');
					$question = Input::get('question');

					$message = nl2br($question);
					$question = trim($message);

					$courseQuestion = CourseQuestion::create(array(
						'title' => $title,
						'question'  => $question,
						'course_id' => $id,
						'user_id' => Auth::user()->id,
						));

					if($courseQuestion && $isJoined && ($course->approved == 1 || $course->user_id == Auth::user()->id)){
						return View::make('courses.question')
								->with(array('course' => $course, 'user' => $user, 'studentCount' => $studentCount, 'questionList' => $questionList ));
					}else{
						return Redirect::route('course-page', array('id' => $id));
					}
				}
		}else{
			return View::make('home.before');
		}
	}



	public function courseAnswer($id, $question)
	{
		if(Auth::check()){
			$course = Course::find($id);
			$studentCount = UserCourse::where('course_id', '=', $id)->count();	
			if ($studentCount > 999){
				$thousand = substr($studentCount, 0, 1);
				$hundred = substr($studentCount, 1, 1);
				$studentCount = $thousand . '.'. $hundred . 'k';
			}
			elseif ($studentCount > 999999) {
				$million = substr($studentCount, 0, 1);
				$thousand = substr($studentCount, 1, 1);
				$studentCount = $million . '.'. $thousand . 'm';
			}

			$isJoined = UserCourse::where(function ($query) {
			    $query->where('user_id', '=', Auth::user()->id);
			})->where(function ($query) use ($id) {
			    $query->where('course_id', '=', $id);
			})->count();

			$user = User::find($course->user_id);
			$question = CourseQuestion::where('id', '=', $question)->first();
			$answerList = CourseAnswer::where('question_id', '=', $question->id)->get();


			if($isJoined && ($course->approved == 1 || $course->user_id == Auth::user()->id)){
				return View::make('courses.answer')
						->with(array('course' => $course, 'user' => $user, 'studentCount' => $studentCount, 'question' => $question, 'answerList' => $answerList ));
			}else{
				return Redirect::route('course-page', array('id' => $id));
			}
		
		}else{
			return View::make('home.before');
		}
	}

	public function postCourseAnswer($id, $question)
	{
		if(Auth::check()){
			$course = Course::find($id);
			$studentCount = UserCourse::where('course_id', '=', $id)->count();	
			if ($studentCount > 999){
				$thousand = substr($studentCount, 0, 1);
				$hundred = substr($studentCount, 1, 1);
				$studentCount = $thousand . '.'. $hundred . 'k';
			}
			elseif ($studentCount > 999999) {
				$million = substr($studentCount, 0, 1);
				$thousand = substr($studentCount, 1, 1);
				$studentCount = $million . '.'. $thousand . 'm';
			}

			$isJoined = UserCourse::where(function ($query) {
			    $query->where('user_id', '=', Auth::user()->id);
			})->where(function ($query) use ($id) {
			    $query->where('course_id', '=', $id);
			})->count();

			$user = User::find($course->user_id);

			$validator = Validator::make(Input::all(),
					array(
							'answer'		 => 'required|min:30|max:400',
					));

				if($validator->fails()){		
					return Redirect::route('course-answers', array('id' => $id, 'question' => $question ))
								->withErrors($validator);
				}else{

					$answer = Input::get('answer');

					$message = nl2br($answer);
					$answer = trim($message);

					$courseAnswer = CourseAnswer::create(array(
						'answer' => $answer,
						'question_id'  => $question,
						'course_id' => $id,
						'user_id' => Auth::user()->id,
						));

					if($courseAnswer && $isJoined && ($course->approved == 1 || $course->user_id == Auth::user()->id)){
						return Redirect::route('course-answers', array('id' => $id, 'question' => $question ));
					}else{
						return Redirect::route('course-page', array('id' => $id));
					}
				}
		}else{
			return View::make('home.before');
		}
	}

	public function courseStudents($id)
	{
		if(Auth::check()){
			$course = Course::find($id);
			$studentCount = UserCourse::where('course_id', '=', $id)->count();	
			if ($studentCount > 999){
				$thousand = substr($studentCount, 0, 1);
				$hundred = substr($studentCount, 1, 1);
				$studentCount = $thousand . '.'. $hundred . 'k';
			}
			elseif ($studentCount > 999999) {
				$million = substr($studentCount, 0, 1);
				$thousand = substr($studentCount, 1, 1);
				$studentCount = $million . '.'. $thousand . 'm';
			}

			$isJoined = UserCourse::where(function ($query) {
			    $query->where('user_id', '=', Auth::user()->id);
			})->where(function ($query) use ($id) {
			    $query->where('course_id', '=', $id);
			})->count();

			$user = User::find($course->user_id);
			$studentId = UserCourse::where('course_id', '=', $id)->get();
			$studentList = array();

			foreach ($studentId as $key) {
				$studentList[] = User::find($key->user_id);
			}

			if($isJoined && ($course->approved == 1 || $course->user_id == Auth::user()->id)){
			return View::make('courses.students')
					->with(array('course' => $course, 'user' => $user, 'studentCount' => $studentCount,'studentList' => $studentList));
			}else{
				return Redirect::route('course-page', array('id' => $id));
			}
		
		}else{
			return View::make('home.before');
		}
	}


}

