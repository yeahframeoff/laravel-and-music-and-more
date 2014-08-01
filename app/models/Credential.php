<?php

namespace Karma\Entities;

/**
 * This class represents user's auth data
 **/

class Credential extends \Eloquent
{
    protected $fillable = array('id', 'user_id', 'social_id', 'external_id', 'token');

    public function user()
    {
        return $this->belongsTo('User');
    }
    
    public function social()
    {
        return $this->belongsTo('Social');
    }
}
