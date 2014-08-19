<?php

namespace Karma\Controllers;

use \Karma\Auth;
use \Karma\API;
use \Karma\Entities\User;
use \View;
use \Session;
use \Redirect;
use \DB;

class ProfileController extends BaseController
{
    public function index()
    {
        $user = User::find(Session::get('user_id'));
        return View::make('profile')
            ->with('user', $user)
            ->with('friends', $user->friends())
            ->with('requests', $user->friendshipRequests())
            ->with('tracks', $user->tracks());
    }
    
    public function show(User $user)
    {
        return View::make('profile')
            ->with('user', $user)
            ->with('friends', $user->friends())
            ->with('tracks', $user->tracks());
    }

}