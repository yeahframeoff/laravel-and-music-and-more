<?php

namespace Karma\Entities;

class Genre extends \Eloquent
{
    protected $fillable = array('id', 'parent_id', 'name');
    public $timestamps = false;
    
    public function relative()
    {
        return self::where('parent_id', $this->parent_id);
    }
}