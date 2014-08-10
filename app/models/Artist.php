<?php

namespace Karma\Entities;

class Artist extends \Eloquent
{
    protected $fillable = array('id', 'name', 'bio');
    public $timestamps = false;
    
    public function albums()
    {
        return $this->hasMany('Album');
    }
    
    public function tracks()
    {
        return $this->hasMany('Track');
    }
}