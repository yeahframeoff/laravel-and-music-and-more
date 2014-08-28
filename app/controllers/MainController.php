<?php

namespace Karma\Controllers;

use \View;
use \Session;
use \Karma\Entities\User;

class MainController extends BaseController
{
    public function index()
    {
        if(AuthController::logged())
        {
            return View::make('import')->with('socials', \KAuth::user()->socials->keyBy('name'));
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
        $user = \KAuth::user();
        
        return View::make('library')->with(array('playlists' => $user->playlists(),
                                                 'tracks' => $user->tracks()));
    }
}