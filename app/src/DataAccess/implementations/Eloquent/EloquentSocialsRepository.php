<?php

namespace Karma\DataAccess;

class EloquentSocialsRepository implements SocialsRepository
{
	public function find($id)
    {
        return Social::find($id);
    }
    
    public function all()
    {
        return Social::all();
    }
    
    public function byName($name)
    {
        return Social::byName($name);
    }
    
    public function create()
    {
        return new Social;
    }
}