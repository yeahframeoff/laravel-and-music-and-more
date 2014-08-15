<?php

namespace Karma\Controllers;

use \Karma\Auth;
use \Karma\API;
use \Karma\Entities\User;
use \View;
use \Session;
use \Redirect;
use \DB;
use \Request;

class FriendController extends BaseController
{
    public function getAllMy()
    {
        $user = User::find(Session::get('user_id'));
        return $this->getAll($user);
    }
    
    public function getAll(User $user)
    {
        //$requests = $user->friendshipRequests();
        $friends = $user->friends();
        $current_user = $this->getCurrentUser($user);
        return View::make('friends')
            ->with('friends', $friends)
            //->with('requests', $requests)
            ->with('user', $user)
            ->with('current_user', $current_user);
    }

    public function add(User $user)
    {
        if ($user->id == Session::get('user_id')){
            return Redirect::action('profileIndex');
        }
        $currentUser = $this->getCurrentUser($user);
        $currentUser->sendRequest($user->id);
        if (Request::ajax())
            return View::make('friendship_button.sent')
                ->with('user', $user)
                ->with('current', $currentUser);
        else
            return Redirect::action('profile',
                                array(Session::get('user_id')));
    }

    public function cancel(User $user)
    {
        $currentUser = $this->getCurrentUser($user);
        $currentUser->removeRequest($user->id);
        if (Request::ajax())
            return View::make('friendship_button.add')
                ->with('user', $user)
                ->with('current', $currentUser);
        else
            return Redirect::action('profile',
                                array(Session::get('user_id')));
    }
    
    public function delete(User $user)
    {
        $currentUser = $this->getCurrentUser($user);
        $currentUser->deleteFriend($user->id);
        if (Request::ajax())
            return View::make('friendship_button.restore')
                ->with('user', $user)
                ->with('current', $currentUser);
        else
            return Redirect::action('profile',
                                array(Session::get('user_id')));
    }

    public function confirm(User $user)
    {
        $currentUser = $this->getCurrentUser($user);
        $currentUser->confirmFriend($user->id);
        if (Request::ajax())
            return View::make('friendship_button.remove')
                ->with('user', $user)
                ->with('current', $currentUser);
        else
            return Redirect::action('profile',
                                array(Session::get('user_id')));
    }
    
    public function restore(User $user)
    {
        $currentUser = $this->getCurrentUser($user);
        $currentUser->forceFriendshipTo($user->id);
        if (Request::ajax())
            return View::make('friendship_button.remove')
                ->with('user', $user)
                ->with('current', $currentUser);
        else
            return Redirect::action('profile',
                                array(Session::get('user_id')));
    }
    
    private function getCurrentUser(User $user)
    {
        return Session::get('user_id') == $user->id ?
            $user :
            User::find(Session::get('user_id'));
    }
    
}