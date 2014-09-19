<?php
/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 19.09.14
 * Time: 1:39
 */

namespace Karma\Wrappers;


use Karma\Util\FriendButtonComposer;

class UserTileWrapper extends AbstractWrapper
{
    public function wrap_single($user)
    {
        return array(
            'id' => $user->id,
            'profileUrl' => $user->profileUrl,
            'photoUrl' => $user->photoUrl,
            'username' => strval($user),
            'audioUrl' => action('Karma\Controllers\LibraryController@userAudio', $user->id),
            'friendsUrl' => \URL::route('friends', ['user' => $user->id ]),
            'messagesUrl' => '/messages#user/' . $user->id,
            'friendshipBtnData' => FriendButtonComposer::compose($user),
            'isTemplate' => false,
            'isAnotherUser' => $user->id != \Karma\Auth\OAuth::getUserId()
        );
    }

    public function template_single()
    {
        return array(
            'id' => '<%= id %>',
            'profileUrl' => '<%= profileUrl %>',
            'photoUrl' => '<%= photoUrl %>',
            'username' => '<%= username %>',
            'audioUrl' => '<%= audioUrl %>',
            'friendsUrl' => '<%= friendsUrl %>',
            'messagesUrl' => '<%= messagesUrl %>',
            'friendshipBtnData' => FriendButtonComposer::template(),
            'isTemplate' => true,
        );
    }
}