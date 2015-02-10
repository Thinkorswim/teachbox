<?php 

class MessagesController extends \BaseController {
	public function index()
	{
		if(Auth::check()){
			$myId = Auth::id();
			$messagesId = Message::where('sender_id', '=', Auth::id())->orWhere('recipient_id', '=', Auth::id())->get();
			$users = array();

			$count = array();

			foreach ($messagesId as $message) {	
				if($message->sender_id == $myId){
					$users[] = User::find($message->recipient_id);
				}else{
					$users[] = User::find($message->sender_id);
				}

				$count[] = Message::where('sender_id', '=', $message->sender_id)->where('recipient_id', '=', $myId )->where('seen_recipient', '=', 0)->count();
			}

			$users = array_unique($users);


			$newUsers = DB::select( DB::raw("SELECT users.* FROM users, follows
											 WHERE follows.follower_id = '$myId' AND follows.following_id = users.id "));

			return View::make('message.index', ['users' => $users, 'count' => $count, 'newUsers' => $newUsers]);
		}else{
			return Redirect::action('AuthController@index');
		}
	}

	public function sendMessage()
	{
		if(Auth::check()){
			$id = Input::get('userId');
			$message = Input::get('message');

			$message = Message::create(array(
				'sender_id' 		=> Auth::user()->id,
				'recipient_id'  => $id,
				'message' => $message,
				'seen_sender' => 1
			));
		}
	}

	public function getMessage()
	{
		if(Auth::check()){
			$id = Input::get('userId');
			$myId = Auth::id();

			$messagesId = DB::select( DB::raw("SELECT * FROM messages WHERE (sender_id = '$myId' AND recipient_id = '$id') OR (sender_id = '$id' AND recipient_id = '$myId')") );
			$messageList = array();

			$key = 0;
			foreach ($messagesId as $message) {	
					$tMessage = Message::find($message->id);
					if($tMessage->recipient_id == $myId){
						$tMessage->seen_recipient = 1;
						$tMessage->save();
					}

					if($tMessage->sender_id == $myId)
					{		
						$messageList[$key]['sender'] = 0;
					}else{
					
						$messageList[$key]['sender'] = 1;
					}
					
					$user = User::find($tMessage->sender_id);

					$messageList[$key]['id'] = $user->id;
					$messageList[$key]['pic'] = $user->pic;
					$messageList[$key]['message'] = $message->message;

					$key++;
			}
			
			return $messageList;
		}
	}

	public function getNewMessage()
	{
		if(Auth::check()){
			$id = Input::get('userId');
			$myId = Auth::id();

			$messagesId = DB::select( DB::raw("SELECT * FROM messages WHERE ((sender_id = '$myId' AND recipient_id = '$id') OR (sender_id = '$id' AND recipient_id = '$myId')) AND seen_recipient = 0") );
			$messageList = array();

			$key = 0;
			foreach ($messagesId as $message) {	
					$tMessage = Message::find($message->id);
					if($tMessage->recipient_id == $myId){
						$tMessage->seen_recipient = 1;
						$tMessage->save(); 
					
						$user = User::find($tMessage->sender_id);

						$messageList[$key]['id'] = $user->id;
						$messageList[$key]['pic'] = $user->pic;
						$messageList[$key]['message'] = $message->message;

						$key++;
					}
			}
			
			return $messageList;
		}
	}

	public function getNotification()
	{
		if(Auth::check()){
			$myId = Auth::id();
			$messagesId = DB::select( DB::raw("SELECT * FROM messages WHERE recipient_id = '$myId' AND seen_recipient = 0") );
			$users = array();

			foreach ($messagesId as $message) {	
				$users[] = User::find($message->sender_id);				
			}

			$users = array_unique($users);

			return  count($users);
		}
	}

 
}