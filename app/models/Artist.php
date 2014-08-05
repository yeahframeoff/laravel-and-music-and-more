<?php

namespace Karma\Entities;

class Artist extends Eloquent
{
    protected $fillable = array('id', 'name', 'genre_id', 'bio');
    protected $timestamps = false;
    
    public function genre()
    {
        return $this->hasOne('Genre');
    }
    
    public function albums()
    {
        return $this->hasMany('Album');
    }
    
    public function tracks()
    {
        return $this->hasMany('Track');
    }
}