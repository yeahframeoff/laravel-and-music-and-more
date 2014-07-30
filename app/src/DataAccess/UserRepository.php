<?php

interface UserRepository extends Repository
{
    public function find($id);
    
    public function all();
}