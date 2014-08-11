<?php

namespace Karma\Controllers;

class SearchController extends BaseController
{
    public function search($for, $what)
    {
        $method = 'searchFor'.ucfirst($for);
        
        if(!method_exists($method))
        {
            return App::abort(404);
        }
        else
        {
            return call_user_func($method, urldecode($what));
        }
    }
    
    protected function searchForPeople($whom)
    {
        
    }
    
    protected function searchForMusic($what)
    {
        
    }
    
    protected function searchForGroups($what)
    {
        
    }
}