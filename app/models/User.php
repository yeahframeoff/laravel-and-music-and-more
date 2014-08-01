<?php

namespace Karma\Entities;

class User extends \Eloquent{

    protected $fillable = array('id');

    public function credentials()
    {
        return $this->hasMany('Credential');
    }

}
