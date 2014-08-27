<?php

namespace Karma\Controllers;


class NotificationController extends BaseController
{
    public function checkForNew()
    {
        $notifications = \KAuth::getUser()->notifications()->unchecked()->with('object')->get();
        return \Response::json($notifications);
    }

    public function checkNotifications()
    {
        dd(\Input::all());
    }
} 