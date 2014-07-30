<?php

namespace Karma\Entities;

/**
 * This class represents resource which could be used to log in.
 **/

class Social extends Entity
{
    protected $fillable = array('id', 'name');
    
}