<?php 

class MessagesController extends \BaseController {
	public function index()
	{
		if(Auth::check()){

			$messagesId = Message::where('sender_id', '=', Auth::id())->orWhere('recipient_id', '=', Auth::id())->get();
			$users = array();

			foreach ($messagesId as $message) {	
				if($message->sender_id == Auth::id()){
					$users[] = User::find($message->recipient_id);
				}else{
					$users[] = User::find($message->sender_id);
				}
			}

			$users = array_unique($users);

			return View::make('message.index', ['users' => $users]);
		}else{
			return Redirect::action('AuthController@index');
		}
	}

	public function sendMessage()
	{
		$id = Input::get('userId');
		$message = Input::get('message');

		$message = Message::create(array(
			'sender_id' 		=> Auth::user()->id,
			'recipient_id'  => $id,
			'message' => $message,
			'seen_sender' => 1
		));
	}

	public function getMessage()
	{
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
					if($key%2 == 0){
						$messageList[$key] = $message->message;
					}else{
						$messageList[$key+1] = $message->message;
					}
				}else{
					if($key%2 == 0){
						$messageList[$key+1] = $message->message;
					}else{
						$messageList[$key] = $message->message;
					}
				}
				$key++;
		}
		
		return $messageList;
	}

	public function getNewMessage()
	{
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
				
					if($tMessage->sender_id == $myId)
					{		
						if($key%2 == 0){
							$messageList[$key] = $message->message;
						}else{
							$messageList[$key+1] = $message->message;
						}
					}else{
						if($key%2 == 0){
							$messageList[$key+1] = $message->message;
						}else{
							$messageList[$key] = $message->message;
						}
					}
				}
		}
		
		return $messageList;
	}

 
}