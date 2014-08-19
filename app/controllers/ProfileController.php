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
            ->with(array('user' => $user,
                         'groups' => $user->groups(),
                         'friends' => $user->friends(),
                         'requests' => $user->friendshipRequests(),
                         'preferred_artists' => $user->preferredArtists(),
                         'socials' => $user->socials()));
    }
    
    public function show(User $user)
    {
        if($user->id == Session::get('user_id'))
        {
            return Redirect::route('profile'); 
        }
        
        return View::make('profile')
            ->with(array('user' => $user,
                         'groups' => $user->groups(),
                         'friends' => $user->friends(),
                         'requests' => $user->friendshipRequests(),
                         'preferred_artists' => $user->preferredArtists()));
    }

    public function addFriend(User $user)
    {
        if ($user->id == Session::get('user_id')){
            return Redirect::action('profileIndex');
        }
        $currentUser = User::find(Session::get('user_id'));
        $currentUser->sendRequest($user->id);
        return Redirect::action('profile',
                                array(Session::get('user_id')));
    }

    public function deleteFriend(User $user)
    {
        $currentUser = User::find(Session::get('user_id'));
        $currentUser->deleteFriend($user->id);
        return Redirect::action('profile',
                                array(Session::get('user_id')));
    }

    public function getAllFriends(User $user)
    {
        $requests = $user->friendshipRequests();
        $friends = $user->friends();
        return View::make('auth.friends')
            ->with('friends', $friends)
            ->with('requests', $requests);
    }

    public function confirmFriend(User $user)
    {
        $currentUser = User::find(Session::get('user_id'));
        $currentUser->confirmFriend($user->id);
        return Redirect::action('profile',
                                array(Session::get('user_id')));
    }
}