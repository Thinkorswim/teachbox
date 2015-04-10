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
			$notify[1]['amount'] = 0;
			$i = 1;
			foreach ($notifications as $notification) {
				if ($notification->type = '1') {
					if ($isFirstFollow) {
						$notify[1]['last_name'] = User::find($notification->event_id)->name;
						$notify[1]['last_id'] = $notification->event_id;
						$isFirstFollow = false;
						switch ($i) {
							case 1:
								$notify['order'][1] = 1;
								break;
							case 2:
								$notify['order'][2] = 1;
								break;
							case 3:
								$notify['order'][3] = 1;
								break;
						}
						$i++;
					} else {
						$notify[1]['amount'] += 1;
					}
				} else if ($notification->type = '2') {

				} else if ($notification->type = '3') {

				}
			}
			return $notify;
		}
	}
}
