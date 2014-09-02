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

use Karma\FriendButtonComposer;

class FriendController extends BaseController
{
    public function allMy()
    {
        $user = \Karma\Auth\OAuth::getUser();
        $showRequests = \Input::has('p') && \Input::get('p') == 'requests';
        return $this->all($user, true, $showRequests);
    }
    
    public function all(User $user, $withRequests = false, $showRequests = false)
    {
        $friends = $user->friends();
        $current_user = $this->getCurrentUser($user);
        $data = [
           'friends'      => $friends,
           'user'         => $user,
           'current_user' => $current_user,
        ];
        if ($withRequests || $user->id == \KAuth::getUserId())
        {
            $requests = $user->friendshipz()->requests()->with('user')->get();
            $data = array_add($data, 'requests', $requests);
        }
        
        return View::make('friends')->with($data)->with('showRequests', $showRequests);
    }

    public function add(User $user)
    {
        if ($user->id == Session::get('user_id')){
            return Redirect::action('profileIndex');
        }
        $currentUser = $this->getCurrentUser($user);
        $currentUser->sendRequest($user->id);
        return $this->resolveAjax(\Response::json(FriendButtonComposer::sent($user)));
    }

    public function cancel(User $user)
    {
        $currentUser = $this->getCurrentUser($user);
        $currentUser->removeRequest($user->id);
        return $this->resolveAjax(\Response::json(FriendButtonComposer::add($user)));
    }
    
    public function delete(User $user)
    {
        $currentUser = $this->getCurrentUser($user);
        $currentUser->deleteFriend($user->id);
        return $this->resolveAjax(\Response::json(FriendButtonComposer::restore($user)));
    }

    public function confirm(User $user)
    {
        $currentUser = $this->getCurrentUser($user);
        $currentUser->confirmFriend($user->id);
        return $this->resolveAjax(\Response::json(FriendButtonComposer::remove($user)));
    }
    
    public function restore(User $user)
    {
        $currentUser = $this->getCurrentUser($user);
        $currentUser->forceFriendshipTo($user);
        return $this->resolveAjax(\Response::json(FriendButtonComposer::remove($user)));
    }

    public function resolveAjax($response)
    {
        if (Request::ajax())
            return $response;
        else
            return Redirect::route('profileIndex');
    }
    
    private function getCurrentUser(User $user)
    {
        return \KAuth::getUserId() == $user->id ? $user : \KAuth::user();
    }
    
}