<?php

class NotificationController extends \BaseController {

	public function getNotificationAmount() {
		if (Auth::check()) {
			$myId = Auth::id();
			//delete all before 1 week

			$type_one = Notification::where('user_id', '=', Auth::id())->where('type', '=', '1')->where('seen', '=', '0')->count();
			$type_two = Notification::where('user_id', '=', Auth::id())->where('type', '=', '2')->where('seen', '=', '0')->count();
			$type_three = Notification::where('user_id', '=', Auth::id())->where('type', '=', '3')->where('seen', '=', '0')->count();

			if ($type_two) {
				$type_two = 1;
			}
			if ($type_three) {
				$type_three = 1;
			}

			return $type_one + $type_two + $type_three;
		}
	}

	public function getNotification() {
		if (Auth::check()) {
			$myId = Auth::id();

			$notifications = Notification::where('user_id', '=', Auth::id())->get();
			$notify = array();

			$isFirstFollow = true;
			$isFirstJoin = true;
			$isFirstLesson = true;

			$notify['follow']['amount'] = 0;
			$i = 0;
			foreach ($notifications as $notification) {
				if ($notification->type = '1') {
					if ($isFirstFollow) {
						$notify['follow']['last_name'] = User::find($notification->event_id)->name;
						$notify['follow']['last_id'] = $notification->event_id;
						$isFirstFollow = false;
						$notify['order'][$i] = 0;
						$i++;
					} else {
						$notify['follow']['amount'] += 1;
					}
				} else if ($notification->type = '2') {
					if ($isFirstJoin) {
						$user_course = UserCourse::find($notification->event_id);

						$notify['join']['last_name'] = User::find($user_course->user_id)->name;
						$notify['join']['last_id'] = $user_course->user_id;
						$notify['join']['course'] = Course::find($user_course->course_id)->name;

						$isFirstJoin = false;
						$notify['order'][$i] = 1;
						$i++;
					} else {
						$notify['join']['amount'] += 1;
					}
				} else if ($notification->type = '3') {
					$notify['order'][$i] = 2;
					$i++;
				}
			}
			return $notify;
		}
	}
}
