<?php

class EloquentUserRepository implements UserRepository
{
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