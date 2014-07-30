<?php

namespace Karma\Entities;

/**
 * This class represents user's auth data
 **/

class Credential extends Entity
{
    protected $fillable = array('id', 'user_id', 'social_id', 'external_id', 'token');
    
    protected

	public function user()
    {
        return $this->belongsTo('User');
    }
}