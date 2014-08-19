<?php

namespace Karma\Entities;

class Artist extends \Eloquent
{
    protected $fillable = array('id', 'name', 'bio');
    public $timestamps = false;
    
    public function albums()
    {
        return $this->hasMany('Karma\Entities\Album');
    }
    
    public function tracks()
    {
        return $this->hasMany('Karma\Entities\Track');
    }
}