<?php

namespace Karma\Entities;

class Album extends \Eloquent
{
    protected $fillable = array('id', 'artist_id', 'name', 'artwork', 'release_date');
    public $timestamps = false;
    
 	public function artist()
    {
        return $this->hasOne('Artist');
    }
    
    public function genres()
    {
        return $this->belongsToMany('Genre');
    }
    
    public function tracks()
    {
        return $this->belongsToMany('Track');
    }
}