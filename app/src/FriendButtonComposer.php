<?php
/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 29.08.14
 * Time: 17:56
 */

namespace Karma;

use Karma\Entities\User;

class FriendButtonComposer
{
    private static $insta;

    private static function instance()
    {
        if (self::$insta === null)
            self::$insta = new self;
        return self::$insta;
    }

    public static function __callStatic($method, $args)
    {
        switch($method)
        {
            case 'compose':
                return self::instance()->$method($args[0]);
            case 'add':
            case 'received':
            case 'remove':
            case 'restore':
            case 'sent':
                \Log::info($args);
                return self::instance()->$method($args[0]);
            default:
                die('Call to undefined singleton method');
        }
    }

    private function wrap(User $user, array $data)
    {
        $data['route'] = \URL::route($data['route'], ['user' => $user->id]);
        return $data;
    }

    private function compose(User $user)
    {
        return $this->wrap($user, $this->getData($user));
    }

    public function __call($method, $args)
    {
        $method = 'data' . ucfirst($method);
        if (method_exists($this, $method))
            return $this->wrap($args[0], $this->$method());
        return [];
    }

    private function getData(User $user)
    {
        $current = \KAuth::user();
        $sentRequest = $current->friendships()->requests()->where('friend_id', '=', $user->id)->exists();
        $receivedRequest  = $current->friendshipz()->requests()->where('user_id', '=', $user->id)->exists();
        $isFriend    = $user->isFriend ($current->id);
        $isNotFriend = !$user->isFriend ($current->id) && !$sentRequest && !$receivedRequest;

        if ($isFriend)
            return $this->dataRemove();
        elseif ($isNotFriend)
            return $this->dataAdd();
        elseif ($sentRequest)
            return $this->dataSent();
        elseif ($receivedRequest)
            return $this->dataReceived();
    }

    private function dataAdd()
    {
        return array(
            'class' => 'friendship-add',
            'route' => 'friends.add',
            'glyphicon' => 'glyphicon-plus',
            'title' => 'Add to my friends',
            'btncolor' => 'btn-primary',
        );
    }

    private function dataReceived()
    {
        return array(
            'class' => 'friendship-accept',
            'route' => 'friends.confirm',
            'glyphicon' => 'glyphicon-ok',
            'title' => 'Accept request',
            'btncolor' => 'btn-success',
        );
    }

    private function dataRemove()
    {
        return array(
            'class' => 'friendship-remove',
            'route' => 'friends.delete',
            'glyphicon' => 'glyphicon-remove',
            'title' => 'Delete from my friends',
            'btncolor' => 'btn-default',
        );
    }

    private function dataRestore()
    {
        return array(
            'class' => 'friendship-restore',
            'route' => 'friends.restore',
            'glyphicon' => 'glyphicon-repeat',
            'title' => 'Restore friend',
            'btncolor' => 'btn-primary',
        );
    }

    private function dataSent()
    {
        return array(
            'class' => 'friendship-cancel',
            'route' => 'friends.cancel',
            'glyphicon' => 'glyphicon-minus',
            'title' => 'Cancel request',
            'btncolor' => 'btn-warning',
        );
    }
} 