<?php

namespace Karma\Controllers;

class ImportController extends BaseController
{
    public function index()
    {
        $id = \Session::get('user_id');
        
        return \View::make('import')->with('socials', \Karma\Entities\User::find($id)->socials()->get());
    }
}