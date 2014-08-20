<?php

namespace Karma\Controllers;

use \View;
use \Session;

class MainController extends BaseController
{
    public function index()
    {
        if(AuthController::logged())
        {
            return View::make('import')->with('socials', \Karma\Entities\User::find(Session::get('user_id'))->socials());
        }
        else
        {
            return View::make('index');
        }
    }
    
    public function about()
    {
        return View::make('about');
    }
    
    public function rights()
    {
        return View::make('rights');
    }
    
    public function library()
    {
        return View::make('library');
    }
}