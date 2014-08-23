<?php

namespace Karma\Entities;

class Friend extends \Eloquent
{
    use NotifyingTrait;

    protected $fillable = ['user_id', 'friend_id', 'confirmed'];

    public function friend()
    {
        return $this->belogsTo('Karma\Entities\User', 'friend_id');
    }
}