<?php

namespace Karma\Controllers;

use \View;
use \Session;
use \Karma\Entities\User;
use \Karma\Entities\PrivateMessage;

class ChatController extends BaseController
{
    public function index()
    {
        return View::make('chat.chat');
    }

    public function chatWithUser($id)
    {
        $user = \Karma\Entities\User::find($id);
        return View::make('chat.chat')
            ->with('user', $user);
    }

    public function getHistory($user)
    {
        $connectedUser = \Karma\Auth\OAuth::getUser();
        $messages = PrivateMessage::select('id', 'from_user_id', 'message')
            ->whereRaw
                ('from_user_id = ? and to_user_id = ?',
                array($connectedUser->id, $user->id))
            ->orWhereRaw
                ('from_user_id = ? and to_user_id = ?',
                array($user->id, \Karma\Auth\OAuth::getUser()->id))
            ->get()
            ->toArray();


        for($i = 0; $i < count($messages); $i++){
            $message = &$messages[$i];
            if($message['from_user_id'] == $user->id)
                $message['user_name'] = $user->first_name;
            else
                $message['user_name'] = $connectedUser->first_name;
        }
        return \Response::json($messages);
    }

}