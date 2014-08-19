<?php

namespace Karma\Entities;

class Album extends \Eloquent
{
    protected $fillable = array('id', 'artist_id', 'name', 'artwork', 'release_date');
    public $timestamps = false;
    
 	public function artist()
    {
        return $this->hasOne('Karma\Entities\Artist');
    }
    
    public function genres()
    {
        return $this->belongsToMany('Karma\Entities\Genre');
    }
    
    public function tracks()
    {
        return $this->belongsToMany('Karma\Entities\Track');
    }
}