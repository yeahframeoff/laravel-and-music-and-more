<?php

namespace Karma\Entities;

/**
 * This class represents resource which could be used to log in.
 **/

class Social extends \Eloquent
{
    protected $fillable = array('id', 'name', 'title');
    public $timestamps = false;
    
    public static function byName($name) {
        return self::where('name', $name)->first();
    }
    
    public function iconUrl()
    {
        return 'public/images/' . strtoupper($this->name) . '_logo_small.png';
    }
}
