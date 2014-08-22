<?php

namespace Karma\Controllers;


class NotificationController extends BaseController
{
    public function checkNotifications()
    {
        $notifications = \Karma\Auth\OAuth::getUser()
            ->notifications()->unchecked()->with('type')->get();

    }
} 