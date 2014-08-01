<?php

namespace Karma\DataAccess;

interface Repository
{
    public function create();    
    
    public function find($id);
    
    public function all();
}