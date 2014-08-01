<?php

namespace Karma\Controllers;

class HomeController extends BaseController 
{
    
    public function __construct()
    {
        $this->layout = View::make("layouts.main");
    }
    
    public function showIndex()
    {
        $this->layout->content = View::make("index");
    }
}