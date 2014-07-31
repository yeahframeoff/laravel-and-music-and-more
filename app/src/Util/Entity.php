<?php

namespace Karma\Util;

class Entity extends Eloquent 
{
    protected $rulesCreate = array();
    protected $rulesStatic = array();
    protected $errors;
    
    protected function validate($rules, $data)
    {
    	$validator = Validator::make($data, $rules);
        
        if($validator->fails())
        {
            $this->errors = $validator->errors();
            return false;
        }
        
        return true;
    }
    
    /**
     * Method provides static check (without checking uniqueness, etc.)
     **/
    public function validateStatic($data)
    {
    	return validate($rulesStatic, $data);    
    }
    
    /**
     * Method provides validation of data, which intended to be used as source for a new entity
     **/
    public function validateCreate($data)
    {
        return validate($rulesCreate, $data); 
    }
    
    public function errors()
    {
        return $this->errors;
    }
}