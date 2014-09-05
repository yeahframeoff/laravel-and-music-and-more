<?php

namespace Karma\Entities;

use \Karma\Entities\User;


trait NotifyingTrait
{
    public function boundNotifications()
    {
        return $this->morphMany('Karma\Entities\Notification', 'object');
    }

    public function notify($user, $type)
    {
        \Log::info ('NOTIFYING TRAIT used: NOTIFY');
        if (!($user instanceof User))
            $user = User::find($user);
        $notification = new Notification();
        $notification->type = $type;
        $notification->refferedUser()->associate($user);
        $notification->object()->associate($this);
        $notification->save();
        return $this->boundNotifications()->save($notification);
    }

    public function unnotify($user, $type)
    {
        if ($user instanceof User)
            $user = $user->id;
        $found = $this->boundNotifications()->where('reffered_user_id', '=', $user)
            ->where('type', '=', $type)->orderBy('updated_at', 'desc')->first();
        if ($found !== null)
            $found->delete();
    }

    public abstract function getMessageParams($type);

    public abstract function getUrlParams($type);
}


class NotifType
{
    const FRIENDS_REQUEST_NEW       = 'friends-request-new';
    const FRIENDS_REQUEST_CONFIFMED = 'friends-request-confirmed';
    const FRIENDS_REQUEST_REMOVED   = 'friends-request-removed';
    const FRIENDS_REQUEST_DENIED    = 'friends-request-denied';
    const FRIENDS_DELETED           = 'friends-deleted';
    const FEED_POST                 = 'feed-post';

    private static $messages = array(
        /*
         * @params: user
         */
        self::FRIENDS_REQUEST_NEW =>
            [
                'popup' => 'New friendship request',
                'msg'   => 'User %user% wants to be your friend',
                'route' => 'profile',
            ],
        self::FRIENDS_REQUEST_CONFIFMED =>
            [
                'popup' => 'Friendship request confirmed',
                'msg'   => 'User %user% confirmed your friendship request',
                'route' => 'profile',
            ],
        self::FRIENDS_REQUEST_REMOVED =>
            [
                'popup' => 'Friendship request cancelled',
                'msg'   => 'User %user% cancelled friendship request, sent to you before',
                'route' => 'profile',
            ],
        self::FRIENDS_REQUEST_DENIED =>
            [
                'popup' => 'Friendship request denied',
                'msg'   => 'User %user% decided to reject your friendship request',
                'route' => 'profile',
            ],
        self::FRIENDS_DELETED =>
            [
                'popup' => 'Someone deleted you from friends list',
                'msg'   => 'User %user% deleted you from friends list',
                'route' => 'profile',
            ],
        self::FEED_POST =>
            [
                'popup' => 'Someone shared music with you',
                'msg'   => 'User %author% shared some music with you',
                'route' => 'feed.show',
            ]
    );

    public static function message($type, array $params)
    {
        if (!isset(self::$messages[$type]))
            return '';
        $message = self::$messages[$type]['msg'];
        foreach ($params as $key => $param)
        {
            $key = '%' . $key . '%';
            $message = str_replace ($key, $param, $message);
        }
        return $message;
    }

    public static function popupText($type)
    {
        if (!isset(self::$messages[$type]))
            return '';
        return self::$messages[$type]['popup'];
    }

    public static function objectUrl($type, array $params)
    {
        if (!isset(self::$messages[$type]))
            return '';
        $route = self::$messages[$type]['route'];
        return \URL::route($route, $params);
    }
}


class Notification extends \Eloquent
{
    use \SoftDeletingTrait;

    protected $table = 'notifications';
    protected $fillable = ['type'];
    //protected $dates = ['deleted_at'];

    protected $appends = ['message', 'popupText', 'objectUrl'];

    protected $hidden = [];

    public function scopeChecked($query)
    {
        return $query->where('checked', '=', 1);
    }

    public function scopeUnchecked($query)
    {
        return $query->where('checked', '=', 0);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', '=', $type)->orWhere('type', 'LIKE', '%' . $type . '%');
    }

    public function refferedUser()
    {
        return $this->belongsTo('Karma\Entities\User', 'reffered_user_id');
    }

    public function object()
    {
        return $this->morphTo('object');
    }

    /*
     * Appended attribute
     */

    public function getMessageAttribute()
    {
        return NotifType::message($this->type, $this->object->getMessageParams($this->type));
    }

    public function getPopupTextAttribute()
    {
        return NotifType::popupText($this->type);
    }

    public function getObjectUrlAttribute()
    {
        return NotifType::objectUrl($this->type, $this->object->getUrlParams($this->type));
    }
} 