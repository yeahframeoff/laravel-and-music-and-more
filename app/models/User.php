<?php

namespace Karma\Entities;

class User extends Entity implements UserInterface {

    protected $fillable = array('id');

    public function credentials()
    {
        return $this->hasMany('Credential');
    }    

}
