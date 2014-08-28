<?php

namespace Karma\Controllers;

use \View;
use \Session;
use \Karma\Entities\User;

class ChatController extends BaseController
{
    public function index()
    {
        $user = \Karma\Auth\OAuth::getUser();
        $friends = $user->friends();
        return View::make('chat.index')
            ->with('friends', $friends);
    }

    public function chatWithUser($id)
    {
        $user = \Karma\Entities\User::find($id);
        \Cookie::queue('userId', $user->id, 214445);
        return View::make('chat.chat');
    }

}