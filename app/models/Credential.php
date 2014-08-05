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
    
    public static function scopeBySocialAndId($id, $social)
    {
        return self::where('id', '=', $id)->where('name', '=', $social)->first();
    }
    
    public static function scopeByToken($token)
    {
        return self::where('token', '=', $token)->first();
    }
}
