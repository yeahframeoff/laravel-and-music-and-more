<?php

namespace Karma\Entities;

/**
 * This class represents resource which could be used to log in.
 **/

class Social extends \Eloquent
{
    protected $fillable = array('id', 'name', 'title');
    public $timestamps = false;
    
    public function scopeByName($query, $name)
    {
        return $query->where('name', $name)->first();
    }
    
    public function iconUrl()
    {
        return '/public/images/' . strtoupper($this->name) . '_logo_small.png';
    }

    public function users()
    {
        return $this->belongsToMany('Karma\Entities\User', 'credentials');
    }

    public function credentials()
    {
        return $this->hasMany('Karma\Entities\Credential');
    }
}
