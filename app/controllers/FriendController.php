<?php

namespace Karma\Controllers;

use \Karma\Auth;
use \Karma\API;
use \Karma\Entities\User;
use \View;
use \Session;
use \Redirect;
use \DB;

class FriendController extends BaseController
{
    public function index(User $user = null)
    {
        if ($user === null)
            return Redirect::route('friends', ['user' => Session::get('user_id')]);
        
        $friends = $user->friends();
        $current_user = User::find(Session::get('user_id'));
        return View::make('friends')->with(['friends' => $friends, 'user' => $user, 'current_user' => $current_user]);
    }
}