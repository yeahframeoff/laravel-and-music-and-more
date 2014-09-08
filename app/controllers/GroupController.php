<?php

namespace Karma\Controllers;

use \View;
use \Session;
use \Karma\Entities\User;
use \Karma\Entities\PrivateMessage;

class GroupController extends BaseController
{
    public function index()
    {
        return View::make('group.index');
    }

}