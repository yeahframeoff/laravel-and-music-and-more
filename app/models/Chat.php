<?php

class Chat extends Eloquent
{
    
    public function participants()
    {
        return $this->hasManyThrough('ChatUser', 'User');
    }
    
    public function messages()
    {
        return $this->
    }
}