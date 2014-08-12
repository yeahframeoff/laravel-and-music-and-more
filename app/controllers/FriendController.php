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
            $user = User::find(Session::get('user_id'));
        
        if ($user === null)
            \App::abort(403, 'Forbidden! Please, sign in to watch friends');
        
        $friends = $user->friends();
        return View::make('friends')->with('friends', $friends);
    }
}