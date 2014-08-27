<?php

namespace Karma\Entities;

use \Karma\Entities\User;


trait NotifyingTrait
{
    public function notifications()
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
        return $this->notifications()->save($notification);
    }

    //public abstract function getMessageParams();

}


class NotifType
{
    const FRIENDS_REQUEST_NEW       = 'friends-request-new';
    const FRIENDS_REQUEST_CONFIFMED = 'friends-request-confirmed';
    const FRIENDS_REQUEST_DENIED    = 'friends-request-denied';
    const FRIENDS_DELETED           = 'friends-request-deleted';

    private static $messages = array(
        /*
         * @params: user
         */
        self::FRIENDS_REQUEST_NEW =>
            [
                'popup' => 'New friendship request',
                'msg' => 'User %user% wants to be your friend',
            ],
        self::FRIENDS_REQUEST_CONFIFMED =>
            [
                'popup' => 'Friendship request confirmed',
                'msg' => 'User %user% confirmed your friendship request',
            ],
        self::FRIENDS_REQUEST_DENIED =>
            [
                'popup' => 'Friendship request denied',
                'msg' => 'User %user% decided to reject your friendship request',
            ],
        self::FRIENDS_DELETED =>
            [
                'popup' => 'Someone deleted you from friends list',
                'msg' => 'User %user% deleted you from friends list',
            ],
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
}


class Notification extends \Eloquent
{
    use \SoftDeletingTrait;

    protected $table = 'notifications';
    protected $fillable = ['type'];
    //protected $dates = ['deleted_at'];

    //protected $attributes = ['message'];
    protected $appends = ['message', 'popupText'];

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
        return NotifType::message($this->type, ['user' => 'The User']);
    }

    public function getPopupTextAttribute()
    {
        return NotifType::popupText($this->type);
    }
} 