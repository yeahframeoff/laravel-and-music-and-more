<?php

namespace Karma\Entities;

class PrivateMessage extends \Eloquent
{
    protected $fillable = array('id', 'from_user_id', 'to_user_id', 'message');
}
