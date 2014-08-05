<?php

namespace Karma\Controllers;

class HomeController extends BaseController 
{
    
    public function __construct()
    {
        $this->layout = "layouts.main";
    }
    
    public function index()
    {
        $this->layout->content = View::make("index");
    }
}