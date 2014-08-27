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
        $checked = \Input::get('checked');
        \Log::info($checked);
        if (!empty($checked))
            \Karma\Entities\Notification::whereIn('id', $checked)->update(['checked' => true]);
    }
} 