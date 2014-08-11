<?php

namespace Karma\Controllers;

use \View;

class MainController extends BaseController
{
    public function index()
    {
        //dd(\Session::all());
        return View::make('index');
    }
    
    public function about()
    {
        return View::make('about');
    }
    
    public function rights()
    {
        return View::make('rights');
    }
}