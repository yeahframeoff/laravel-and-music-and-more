<?php

namespace Karma\Controllers;

class ImportController extends BaseController
{
    public function index()
    {
        return \View::make('import')->with('socials', \Karma\Entities\User::find(\Session::get('user_id'))->socials());
    }
}