<?php 

class MessagesController extends \BaseController {
	public function index()
	{
		if(Auth::check()){
			$myId = Auth::id();

			$users = DB::select( DB::raw("SELECT DISTINCT users.* FROM users, messages 
											 WHERE (messages.sender_id = '$myId' AND users.id = messages.recipient_id) OR (messages.recipient_id = '$myId' AND users.id = messages.sender_id) AND users.id <> '$myId'
											 GROUP BY users.id ORDER BY MAX(messages.created_at) DESC "));
			$count = array();

			foreach ($users as $user) {	

				$count[] = Message::where('sender_id', '=', $user->id)->where('recipient_id', '=', $myId )->where('seen_recipient', '=', 0)->count();
			}


			$newUsers = DB::select( DB::raw("SELECT users.* FROM users, follows
											 WHERE follows.follower_id = '$myId' AND follows.following_id = users.id 
											"));

			// AND (users.id NOT IN (SELECT messages.sender_id FROM messages WHERE messages.recipient_id = '$myId') 
	        // OR  users.id NOT IN (SELECT messages.recipient_id FROM messages WHERE messages.sender_id = '$myId')) 


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
			$offset = (int) Input::get('offset');
			$twenty = 20;

			$size = DB::select( DB::raw("SELECT COUNT(*) FROM messages WHERE (sender_id = '$myId' AND recipient_id = '$id') OR (sender_id = '$id' AND recipient_id = '$myId')") );
			$size = $size[0]->{'COUNT(*)'};
			$size = $size - $offset - 20;

			if($size<0){
				if($size>-20){
					$twenty = $twenty+$size;
					$size = 0;
				}else{
					return [];
				}
			}

			$messagesId = DB::select( DB::raw("SELECT * FROM messages WHERE (sender_id = '$myId' AND recipient_id = '$id') OR (sender_id = '$id' AND recipient_id = '$myId') LIMIT $size, $twenty") );
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