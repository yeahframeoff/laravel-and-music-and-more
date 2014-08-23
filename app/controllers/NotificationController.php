<?php

namespace Karma\Controllers;


class NotificationController extends BaseController
{
    public function checkNotifications()
    {
        $notifications = \KAuth::getUser()->notifications()->unchecked()->get();
        return \Response::json($notifications);
    }
} 