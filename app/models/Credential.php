<?php

namespace Karma\Entities;

/**
 * This class represents user's auth data
 **/

class Credential extends Eloquent
{
    protected $fillable = array('id', 'user_id', 'social_id', 'external_id', 'token', 'created_at', 'updated_at');

    public function user()
    {
        return $this->hasOne('User');
    }
    
    public function social()
    {
        return $this->hasOne('Social');
    }
}
