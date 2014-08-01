<?php

namespace Karma\Util;

trait ValidationTrait
{
    protected static $rulesCreate = array();
    protected static $rulesStatic = array();
    protected static $errors;
    
    protected static function validate($rules, $data)
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
    public static function validateStatic($data)
    {
    	return self::validate($rulesStatic, $data);    
    }
    
    /**
     * Method provides validation of data, which intended to be used as source for a new entity
     **/
    public static function validateCreate($data)
    {
        return self::validate($rulesCreate, $data); 
    }
    
    public static function errors()
    {
        return self::errors;
    }
}