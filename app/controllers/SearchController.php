<?php

namespace Karma\Controllers;

class SearchController extends BaseController
{
    public function search($for, $what)
    {
        $method = 'searchFor'.ucfirst($for);
        
        if(!method_exists($this, $method))
            return App::abort(404);
        else
            return $this->$method(urldecode($what));
    }
    
    protected function searchForPeople()
    {
        $whom = \Input::has('q') ? \Input::get('q') : '';
        $people = \Karma\Util\Search::search('\Karma\Entities\User', ['first_name', 'last_name'], $whom);
        return \View::make('search', ['page' => 'people', 'result' => $people]);
    }
    
    protected function searchForMusic($what)
    {
        
    }
    
    protected function searchForGroups($what)
    {
        
    }
}