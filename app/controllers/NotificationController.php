<?php

namespace Karma\Controllers;


class NotificationController extends BaseController
{
    public function checkForNew()
    {
        $notifications = \KAuth::user()->notifications()->unchecked()->with('object')->get();
        $retData = ['notifications' => $notifications];
        if (\Input::has('friends'))
        {
            $fIds = \Input::get('friends');
            $friends = \Karma\Entities\User::whereIn('id', $fIds)->get();
            $fData = $friends->map(function($friend)
            {
                return ['id' => $friend->id, 'data' => \Karma\FriendButtonComposer::compose($friend)];
            });
            $retData['friends'] = $fData->toArray();
        }
        return \Response::json($retData);
    }

    public function checkNotifications()
    {
        $checked = \Input::get('checked');
        if (!empty($checked))
            \Karma\Entities\Notification::whereIn('id', $checked)->update(['checked' => true]);
    }
} 