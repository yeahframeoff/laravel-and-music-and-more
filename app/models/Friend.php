<?php

namespace Karma\Entities;

class Friend extends \Eloquent
{
    use NotifyingTrait;

    protected $fillable = ['user_id', 'friend_id', 'confirmed'];

    public function user()
    {
        return $this->belogsTo('Karma\Entities\User', 'user_id');
    }

    public function friend()
    {
        return $this->belogsTo('Karma\Entities\User', 'friend_id');
    }

//    public function getMessageParams()
//    {
//        $user = $this->user();
//        return ['user' => $user->first_name . ' ' . $user->last_name];
//    }
}