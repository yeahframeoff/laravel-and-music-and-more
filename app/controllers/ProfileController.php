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

    public function show(User $user)
    {
        return View::make('auth.profile')->with('user', $user);
    }

    public function addFriend(User $user)
    {
        DB::table('friends')->insert(array(
            'user_id' => Session::get('user_id'),
            'friend_id' => $user->id,
            'confirmed' => false
        ));
        return Redirect::action('profile',
                                array(Session::get('user_id')));
    }

    public function deleteFriend(User $user)
    {
        DB::table('friends')
            ->where('user_id', $user->id)
            ->where('friend_id', Session::get('user_id'))
            ->delete();
        DB::table('friends')
            ->where('user_id', Session::get('user_id'))
            ->where('friend_id', $user->id)
            ->delete();
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
        DB::table('friends')
            ->where('user_id', $user->id)
            ->where('friend_id', Session::get('user_id'))
            ->where('confirmed', false)
            ->update(array('confirmed' => true));
        DB::table('friends')->insert(array(
            'user_id' => Session::get('user_id'),
            'friend_id' => $user->id,
            'confirmed' => true
        ));
        return Redirect::action('profile',
                                array(Session::get('user_id')));
    }

}
?>
