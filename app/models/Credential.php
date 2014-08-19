<?php

namespace Karma\Entities;

/**
 * This class represents user's auth data
 **/

class Credential extends \Eloquent
{
    protected $fillable = array('id', 'user_id', 'social_id', 'external_id', 'refresh_token', 'access_token', 'expiration');

    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }
    
    public function social()
    {
        return $this->hasOne('Social');
    }
    
    public function expired()
    {
        return strtotime($this->expiration) > time();
    }
    
    public static function bySocialAndId($social, $id)
    {
        return self::where('user_id', $id)->where('social_id', Social::byName($social)->id)->first();
    }
    
    public static function byToken($token)
    {
        return self::where('access_token', $token)->first();
    }
}
