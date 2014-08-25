<?php

namespace Karma\Controllers;


class NotificationController extends BaseController
{
    public function checkNotifications()
    {
        $notifications = \KAuth::getUser()->notifications()->unchecked()->with('object')->get();
        return \Response::json($notifications);
    }
} 