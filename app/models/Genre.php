<?php

namespace Karma\Entities;

class Genre extends \Eloquent
{
    protected $fillable = array('id', 'name');
    protected $timestamps = false;    
}