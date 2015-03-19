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
			
				$file_max = 4000000;
				$image = Input::file('image');
				$size = $image->getSize();

				if($size >= $file_max){
					return Redirect::action('CourseController@create')
						 ->withErrors(array('pic' => 'The file size is larger than 4mb.'));

				}

				$validator = Validator::make(Input::all(),
					array(
							'name' 				 => 'required|min:4|max:128',
							'description'		 => 'required|min:30|max:4096',
					));

				if($validator->fails()){		
					return Redirect::action('CourseController@create')
							->withErrors($validator);
				}else{
						
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
						    $resultMake  = File::makeDirectory(public_path() .'/courses/' . $course->id . '/img/');
						    if($newImage->save(public_path('/courses/' . $course->id . '/img/' . $filename)) && $newImage1->save(public_path('/courses/' . $course->id . '/img/'. '/3x2' . $filename))){
						    	$course->pic    = $filename;
						    	$course->save();
						    }
							$user_id = Auth::user()->id;
							$user = User::find($user_id);
							$userCourse = UserCourse::create(array(
								'course_id' => $course->id,
								'user_id'  => $user_id,
							));
			    	if($userCourse){
			Mail::send('emails.auth.course-new', array('course' => $course, 'user' => $user), function($message_new) use ($user) {
			$message_new->to( $user->email , $user->name)->subject('Your new course in Teachbox');
			} );
						return Redirect::route('course-page', array('id' => $course->id));

					}else{
						return Redirect::route('course-page', array('id' => $course->id))
												->with('global-negative', 'You could not create this course.');
						 }

						return View::make('courses.join')
								->with('course', $course);		

					}

						return Redirect::action('CourseController@create')
								->with('global-negative', 'Your course could not be created.');
				}

			
			}else{
					return Redirect::action('CourseController@create')
							 ->withErrors(array('pic' => 'You have not selected a picture or it has a wrong extension.'));
			}

	    }
	}

	public function course($id)
	{
		$course = Course::find($id);
		$studentCount = UserCourse::where('course_id', '=', $id)->count();	
		$studentCount = $studentCount - 1;
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
		if(Auth::check()){
			$isJoined = UserCourse::where(function ($query) {
				    $query->where('user_id', '=', Auth::user()->id);
				})->where(function ($query) use ($id) {
				    $query->where('course_id', '=', $id);
				})->count();
		}
		if($course->approved == 1 || $course->user_id == Auth::user()->id || Auth::user()->admin == 1){

			
			if((Auth::check() && $course->user_id == Auth::user()->id) || (Auth::check() && Auth::user()->admin == 1)){
				$lessonList = Lesson::where('course_id', '=', $id)->get();
			}else{
				$lessonList = Lesson::where('course_id', '=', $id)->where('approved', '=', 1)->get();
			}


			$user = User::find($course->user_id);
			if(Auth::check()){
			if($isJoined || Auth::user()->admin == 1){
				return View::make('courses.join')
							->with(array('course' => $course, 'lessonList' => $lessonList, 'user' => $user, 'studentCount' => $studentCount, 'isJoined'=>$isJoined ));
			
			}else{
    			return View::make('courses.not_join')
       						->with(array('course' => $course, 'user' => $user, 'studentCount' => $studentCount,'lessonList' => $lessonList ));   
   					}
			}else{
				return View::make('courses.not_join')
							->with(array('course' => $course, 'user' => $user, 'studentCount' => $studentCount,'lessonList' => $lessonList ));
			}
		}else{
			return Redirect::route('home');
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
		$studentCount = $studentCount - 1;	
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
		$studentCount = $studentCount - 1;	
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
						'description' 			 => 'min:30|max:4096',
				));

			if($validator->fails()){		
				return Redirect::action('CourseController@courseEdit',[$id])
						->withErrors($validator);

			}else{
				$courseEdit = Course::find($id);

				$description = Input::get('description');
					if(Input::hasFile('image') && (Input::file('image')->getClientOriginalExtension() == "jpg" || Input::file('image')->getClientOriginalExtension() == "png")){	

						
						$file_max = 4000000;

						$image = Input::file('image');
						$size = $image->getSize();

						if($size >= $file_max){
							return Redirect::action('CourseController@courseEdit',[$id])
								 ->withErrors(array('pic' => 'The file size is larger than 4mb.'));

						}

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
						
						$pathImg = public_path().'/courses/'. $course->id . '/img/';
						
						$success = File::cleanDirectory($pathImg);

						if($newImage->save(public_path('/courses/' . $courseEdit->id . '/img/' . $filename)) && $newImage1->save(public_path('/courses/' . $course->id . '/img/'. '/3x2' . $filename))){
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
		$studentCount = $studentCount - 1;		
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
		$studentCount = $studentCount - 1;	
		if(Auth::check()){
			$course = Course::find($id);

			$isJoined = UserCourse::where(function ($query) {
			    $query->where('user_id', '=', Auth::user()->id);
			})->where(function ($query) use ($id) {
			    $query->where('course_id', '=', $id);
			})->count();

			if(($isJoined || Auth::user()->admin) && ($course->approved == 1 || $course->user_id == Auth::user()->id || Auth::user()->admin)){
				$lesson = Lesson::where(function ($query) use ($lesson) {
				    $query->where('order', '=', $lesson);
				})->where(function ($query) use ($id) {
				    $query->where('course_id', '=', $id);
				})->first();

				if($lesson->approved == 1 || $course->user_id == Auth::user()->id || Auth::user()->admin){
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


                    	$test = Test::find($id);
	                 	$questions =  Test::where('lesson_id', '=', $lesson->id)->get();

						return View::make('courses.lesson')
								->with(array('course' => $course, 'currentLesson' => $lesson, 'nextLesson' => $nextLesson, 'previousLesson' => $previousLesson, 'lessonList' => $lessonList, 'creator' => $creator, 'questions' => $questions));
				}else{
						return Redirect::route('course-page', array('id' => $id));
				}
			}else{
					return View::make('courses.not_join')
							->with(array('course' => $course, 'studentCount' => $studentCount));
			}
		}else{
			return View::make('home.before');
		}
	}

	public function coursePostAdd($id){
		$course = Course::find($id);

		if(Auth::check() && ($course->approved == 1 || $course->user_id == Auth::user()->id) && $course->user_id == Auth::user()->id){
		 	if(Input::hasFile('video') && (Input::file('video')->getClientOriginalExtension() == "mp4")){

		 		$file = Input::file('video');
				
				$validator = Validator::make(Input::all(),
					array(
							'name' 				 => 'required|min:4|max:64',
							'description'		 => 'required|min:10|max:1024',
					));

				if($validator->fails()){		
				return Redirect::route('course-add', array('id' => $id))
							->withErrors($validator);
				}else{


				$name 	 = Input::get('name');
				$description = Input::get('description');

				$course = Course::find($id);
				$user = User::find($course->user_id);
				$order = Lesson::where('course_id', '=', $id)->count() + 1;


				$path = public_path().'/courses/'. $course->id . '/' . $order;
				$filename = "video.mp4";
				$resultMake  = File::makeDirectory(public_path() .'/courses/' . $course->id . '/' . $order);
		   		$file->move($path, $filename);

				$message = nl2br($description);
				$description = trim($message);
				
				$ffmpeg = public_path().'/ffmpeg/ffmpeg';  
			 	$video = $path.'/'.$filename; 

				$full_duration = exec("$ffmpeg -i $video 2>&1 | 
				grep Duration | cut -d ' ' -f 4 | sed s/,//");

				$hour = substr($full_duration, 0, 2);
				$minute = substr($full_duration, 3, 2);
				$second = substr($full_duration, 6, 2);

				$duration = $minute . ':' .  $second;
		   		
		   		$hour_i = (int) $hour;
		   		$minute_i = (int) $minute;
		   		$second_i = (int) $second;


		   		if($hour_i != 0){
		   			$deleteMake  = File::deleteDirectory(public_path() .'/courses/' . $course->id . '/' . $order);
		   			return Redirect::route('course-add', array('id' => $id, 'user'=> $user))
						 ->withErrors(array('video' => 'The video is bigger than 5 minutes.'));
		   		}else{
		   			if($minute_i<=4 || ($minute_i==5 && $second_i==0)){

		   			}else{
		   				$deleteMake  = File::deleteDirectory(public_path() .'/courses/' . $course->id . '/' . $order);
		   				return Redirect::route('course-add', array('id' => $id, 'user'=> $user))
							 ->withErrors(array('video' => 'The video is bigger than 5 minutes.'));
		   			}
		   		}


				 

		   		 // Get Thumbnail  
				 $image = $path.'/thumb.png';  
				 $interval = 1;  
			     $cmd = "$ffmpeg -i $video -deinterlace -an -ss $interval -f mjpeg -t 1 -r 1 -y $image 2>&1";
     		     shell_exec($cmd);

     		     //Queue::push('Convert', array('video' => $video, 'path' => $path, 'ffmpeg' => $ffmpeg));

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
						'duration'	  => $duration,
						));

		   		  if($lesson){
					if(!Input::has("q1") || !Input::has("11") || !Input::has("12")){
						//redirect
					}
					
					$continue = true;
					for($i = 1; $i<=5; $i++){
						if(Input::has("q" . $i) && $continue){
								$answers = array();
								for($j = 1; $j<=4; $j++){
									if($j<=2){
										if(!Input::has((string) ($i . $j))  ){
											break;
											$continue = false;
										}else{
											$answers[$j] = Input::get((string) ($i . $j));
										}
									}else{
										if(!Input::has((string) ($i . $j))  ){
											 break;
										}else{
											$answers[$j] = Input::get((string) ($i . $j));
										}
									}
								}
								if($continue){
									$test = new Test;
									$test->lesson_id = 	$lesson->id;
									$test->question = Input::get("q" . $i);
									$test->choice_1 = $answers[1];
									$test->choice_2 = $answers[2];
									if(array_key_exists(3, $answers)){
										$test->choice_3 = $answers[3];
									}
									if(array_key_exists(4, $answers)){
										$test->choice_4 = $answers[4];
									}
									$test->answer = Input::get("r".$i)%10;
									$test->save();
								}
						}
					}
					return Redirect::route('course-page', array('id' => $id, 'user'=> $user));
				}else{
					return Redirect::route('course-page', array('id' => $id, 'user'=> $user))
												->with('global-negative', 'You could not join this course.');
				}
			}

			}else{
					return Redirect::route('course-add', array('id' => $id, 'user'=> $user))
						 ->withErrors(array('video' => 'You have not selected a video file or it has a wrong extension.'));
			}
		}else{

					return View::make('home.before');
		}
	}


	public function lessonEdit($id,$lesson,$user)
	{
		$course = Course::find($id);
		if(Auth::check() && ($course->approved == 1 || $course->user_id == Auth::user()->id) && $course->user_id == Auth::user()->id){
			$course = Course::find($id);
			$lesson = Lesson::where(function ($query) use ($lesson) {
				    $query->where('order', '=', $lesson);
				})->where(function ($query) use ($id) {
				    $query->where('course_id', '=', $id);
				})->first();

			return View::make('courses.edit_lesson')->with(array('course' => $course, 'lesson' => $lesson));
		}else{
			return View::make('home.before');
		}
	}
	public function postLessonTest($id,$lesson){
		$course = Course::find($id);
		if(Auth::check()){
			$user = Auth::user();
			$lesson = Lesson::find($lesson);
			$questions = Test::where('lesson_id', '=', $lesson->id)->get();
			$scored = 0;
			$total = count($questions);
			$choices = array();
			$i = 0;
			foreach ($questions as $question) {
				$answer = $question->answer;
				do{
					$i++;
					if(Input::has("r".$i)){
						$choices[$i] = Input::get("r".$i)%10;	
						//Log::info("Choice:    " . print_r($choices[$i],true));
						if($choices[$i] == $answer)
						{
							$scored++;
						}
					}
				}while($i > 5);

				//Log::info("Answer:    " . $answer);
				//Log::info("Scored:    " . $scored);
			}

			$result = new Result;
			$result->lesson_id = $lesson->id;
			$result->user_id = $user->id;
			$result->total = $total;
			$result->right = $scored;
			$result->save();

			$returner = array();
			$returner['percentage'] = intval(intval($scored)/intval($total));
			$returner['total'] = intval($total);
			$returner['right'] = intval($scored);

			return $returner;
		}else{
			return View::make('home.before');
		}						
	}


	

	public function changeVideo($id,$lesson)
	{
		$course = Course::find($id);
		if(Auth::check() && ($course->approved == 1 || $course->user_id == Auth::user()->id) && $course->user_id == Auth::user()->id){
			$course = Course::find($id);
			$lesson = Lesson::where(function ($query) use ($lesson) {
				    $query->where('order', '=', $lesson);
				})->where(function ($query) use ($id) {
				    $query->where('course_id', '=', $id);
				})->first();
			
			return View::make('courses.change_video')->with(array('course' => $course, 'lesson' => $lesson));
		}else{
			return View::make('home.before');
		}
	}



	public function postLessonEdit($id,$lesson){

		$course = Course::find($id);

		if(Auth::check() && ($course->approved == 1 || $course->user_id == Auth::user()->id) && $course->user_id == Auth::user()->id){
			$validator = Validator::make(Input::all(),
				array(
						'name' 				 => 'required|min:4|max:64',
						'description' 			 => 'min:10|max:1024',
				));

			if($validator->fails()){		
				return Redirect::route('edit-lesson', array('id' => $id))
							->withErrors($validator);

			}else{

				$name 	 = Input::get('name');
				$description = Input::get('description');

				$message = nl2br($description);
				$description = trim($message);


				$course = Course::find($id);


				$order = Lesson::where('course_id', '=', $id)->count();	

				$lesson = Lesson::where(function ($query) use ($lesson) {
				    $query->where('order', '=', $lesson);
				})->where(function ($query) use ($id) {
				    $query->where('course_id', '=', $id);
				})->first();

				$lesson->name = $name;
				$lesson->description = $description;

				

		   		  if($lesson->save()){
					return Redirect::route('course-page', array('id' => $id));
				}else{
					return Redirect::route('edit-lesson', array('id' => $id))
												->with('global-negative', 'You could not edit this lesson.');
				}
			}

		}else{

					return View::make('home.before');
		}
	}


	public function postChangeVideo($id,$lesson){
		$course = Course::find($id);
		if(Auth::check() && ($course->approved == 1 || $course->user_id == Auth::user()->id) && $course->user_id == Auth::user()->id){
		 	if(Input::hasFile('video') && (Input::file('video')->getClientOriginalExtension() == "mp4")){
				
				$file = Input::file('video');
				$course = Course::find($id);
				$order = Lesson::where('course_id', '=', $id)->count();	
				
				$lesson = Lesson::where(function ($query) use ($lesson) {
				    $query->where('order', '=', $lesson);
				})->where(function ($query) use ($id) {
				    $query->where('course_id', '=', $id);
				})->first();
		   		
		   		$path = public_path().'/courses/'. $course->id . '/' . $order;
		   		$success = File::cleanDirectory($path);
		   		$filename = "video.mp4";
		   		$file->move($path, $filename);
			    $ffmpeg = public_path().'/ffmpeg/ffmpeg';  
			 	$video = $path.'/'.$filename;
			 	$full_duration = exec("$ffmpeg -i $video 2>&1 | 
				grep Duration | cut -d ' ' -f 4 | sed s/,//");
				$hour = substr($full_duration, 0, 2);
				$minute = substr($full_duration, 3, 2);
				$second = substr($full_duration, 6, 2);   
				$duration = $minute . ':' .  $second;
		   		
		   		$hour_i = (int) $hour;
		   		$minute_i = (int) $minute;
		   		$second_i = (int) $second;
		   		if($hour_i != 0){
		   			$deleteMake  = File::deleteDirectory(public_path() .'/courses/' . $course->id . '/' . $order);
		   			return Redirect::route('course-add', array('id' => $id, 'user'=> $user))
						 ->withErrors(array('video' => 'The video is bigger than 5 minutes.'));
		   		}else{
		   			if($minute_i<=4 || ($minute_i==5 && $second_i==0)){
		   			}else{
		   				$deleteMake  = File::deleteDirectory(public_path() .'/courses/' . $course->id . '/' . $order);
		   				return Redirect::route('course-add', array('id' => $id, 'user'=> $user))
							 ->withErrors(array('video' => 'The video is bigger than 5 minutes.'));
		   			}
		   		}
			    // Get Thumbnail
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
				 
				 $lesson->filepath = $filename;
				 $lesson->duration = $duration;
				 $lesson->approved = 0;
			   		  
		   		  if($lesson->save()){
					return Redirect::route('course-page', array('id' => $id));
				}else{
					return Redirect::route('change-lesson-video', array('id' => $id))
												->with('global-negative', 'You could not edit this lesson.');
				}
			}else{
					return Redirect::route('course-page', array('id' => $id));
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
			$studentCount = $studentCount - 1;	
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

			if(($isJoined && ($course->approved == 1 || $course->user_id == Auth::user()->id)) || Auth::user()->admin = 1){
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
			$studentCount = $studentCount - 1;		
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
							'title' 			 => 'required|min:4|max:64',
							'question'		 => 'required|min:10|max:1024',
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
						
						return Redirect::route('course-answers', array('id' => $id, 'question' => $courseQuestion->id));

						//return View::make('courses.question')
						//		->with(array('course' => $course, 'user' => $user, 'studentCount' => $studentCount, 'questionList' => $questionList ));
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
			$studentCount = $studentCount - 1;	
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
			$studentCount = $studentCount - 1;		
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
							'answer'		 => 'required|min:10|max:1024',
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
		
			$course = Course::find($id);
			$studentCount = UserCourse::where('course_id', '=', $id)->count();	
			$studentCount = $studentCount - 1;
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
			$user = User::find($course->user_id);
			$studentId = DB::table('user_courses')
			        ->join('users', function($join)  use ($id)
			        {
			            $join->on('user_courses.user_id', '=', 'users.id')
			                 ->where('course_id', '=', $id);
			        })->orderBy('users.name')->get();
			$studentList = $studentId;
			
			if(Auth::check()){
			$isJoined = UserCourse::where(function ($query) {
			    $query->where('user_id', '=', Auth::user()->id);
			})->where(function ($query) use ($id) {
			    $query->where('course_id', '=', $id);
			})->count();

			if($course->approved == 1 || $course->user_id == Auth::user()->id){
			return View::make('courses.students')
					->with(array('course' => $course, 'isJoined' => $isJoined, 'user' => $user, 'studentCount' => $studentCount,'studentList' => $studentList));
			}else{
				return Redirect::route('course-page', array('id' => $id));
			}
		
		}else{
			return View::make('courses.students')
					->with(array('course' => $course, 'user' => $user, 'studentCount' => $studentCount,'studentList' => $studentList));
		}
	}


}

