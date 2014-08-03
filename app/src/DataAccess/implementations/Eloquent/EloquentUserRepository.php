<?php

namespace Karma\DataAccess;

class EloquentUserRepository implements UserRepository
{
    use ValidationTrait;
    
	static function init()
    {
        //init validation rules here
    }
    
    public function find($id)
    {
        return User::find($id);
    }
    
    public function all()
    {
        return User::all();
    }
    
    public function create()
    {
        return new User;
    }
}

EloquentUserRepository::init();