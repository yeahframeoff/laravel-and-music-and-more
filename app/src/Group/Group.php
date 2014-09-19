<?php

namespace Karma\Group;

use Evenement\EventEmitterInterface;
use Ratchet\ConnectionInterface;
use Exception;
use SplObjectStorage;
use Karma\Entities\Group as KarmaGroup;

class Group implements GroupInterface{
    protected $users;
    protected $emitter;
    protected $id = 1;

    public function getUserBySocket(ConnectionInterface $socket)
    {
        foreach ($this->users as $next)
        {
            if ($next->getSocket() === $socket)
            {
                return $next;
            }
        }

        return null;
    }

    public function getEmitter()
    {
        return $this->emitter;
    }

    public function setEmitter(EventEmitterInterface $emitter)
    {
        $this->emitter = $emitter;
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function __construct(EventEmitterInterface $emitter)
    {
        $this->emitter = $emitter;
        $this->users   = array();
    }

    public function onOpen(ConnectionInterface $socket)
    {
        try{
            $groupId = $this->getGroupIdFromUrl($socket);
            $user = $this->getUserFromCookie($socket);
            $user->setSocket($socket);
            foreach($this->users[$groupId]['subscribers'] as $key => $tmpUser){
                if($tmpUser->id == $user->id){
                    $tmpUser->setSocket($socket);
                }
            }

            /*if(array_key_exists($groupId, $this->users)){
                $this->users[$groupId]['subscribers'][] = $user;
            } else {
                $this->users[$groupId] = array();
                $this->users[$groupId]['owner'] = $user;
                $this->users[$groupId]['subscribers'] = array();
            }
            */

            /*
            $user->getSocket()->send(json_encode([
                "type" => "currentUser",
                "data" => $user
            ]));
            $onlineFriends = $this->getOnlineFriends($user);
            foreach($onlineFriends as $onlineFriend){
                $onlineFriend->getSocket()->send(json_encode([
                    "type" => "onlineNow",
                    "data" => '',
                    "id" => $user->id
                ]));
            }
            */
            $this->emitter->emit("open", [$user]);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

    public function onMessage(
        ConnectionInterface $socket,
        $message
    )
    {
        $user = $this->getUserFromCookie($socket);
        $user->setSocket($socket);
        $message = json_decode($message);
        $this->emitter->emit("message", [
            $user,
            $message->type
        ]);

        $functionName = $message->type;
        if(method_exists($this, $functionName)){
            var_dump('method exist');
            if(isset($message->id))
                $id = $message->id;
            else
                $id = NULL;
            if(!isset($message->data->group_id))
                $message->data->group_id = $this->getGroupIdFromUrl($socket);
            $this->$functionName($user, $message->data, $id);
        } else {
            var_dump('method doesnt exist');
            $this->emitter->emit("error", [
                $user,
                new Exception('Method ' . $functionName . ' doesnt exist')
            ]);
        }
        /*
        switch($message->type){
            case 'message':
                $privateMessage = \Karma\Entities\PrivateMessage::create(array(
                    'from_user_id' => $user->id,
                    'to_user_id' => $message->user,
                    'message' => $message->data
                ));
                $this->sendMessageToIdFromId($message->user, $message->data, $user->id);
                break;
        }
        */
    }

    public function onClose(ConnectionInterface $socket)
    {
        /*
        $user = $this->getUserBySocket($socket);

        $onlineFriends = $this->getOnlineFriends($user);
        foreach($onlineFriends as $onlineFriend){
            $onlineFriend->getSocket()->send(json_encode([
                "type" => "offlineNow",
                "data" => '',
                "id" => $user->id
            ]));
        }
        */
        //$this->emitter->emit("close", [$user]);
    }

    public function onError(
        ConnectionInterface $socket,
        Exception $exception
    )
    {
        /*
        $user = $this->getUserBySocket($socket);

        if ($user)
        {
            $user->getSocket()->close();
        }
        */
        //$this->emitter->emit("error", [$user, $exception]);
    }

    private function getUserFromCookie($socket)
    {
        $cookie = $socket->WebSocket->request->getCookie('laravel_session');
        $cookie = str_replace('%3D', '', $cookie);
        $key = \Config::get('app.key');
        $encryptor = new \Illuminate\Encryption\Encrypter($key);
        $id = $encryptor->decrypt($cookie);
        $payload = base64_decode(\DB::table('sessions')->where('id', $id)->first()->payload);
        $payload = unserialize($payload);
        $user = User::find($payload['user_id']);
        return $user;
    }

    private function getGroupIdFromUrl($socket)
    {
        $url = $socket->WebSocket->request->getUrl();
        $urlParts = explode('/', $url);
        $id = end($urlParts);
        return $id;
    }

    private function translateCommand($sender, $dataObject, $id)
    {
        try{
        var_dump('begin translate');
        $groupId = $dataObject->group_id;
        foreach($this->users[$groupId]['subscribers'] as $user){
            var_dump($user->id);
            $user->getSocket()->send(json_encode([
                'type' => 'translateCommand',
                'data' => $dataObject
            ]));
        }
        var_dump('end translate');
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

    private function startBroadcast($sender, $dataObject, $id)
    {
        var_dump('start broadcast');
        $groupId = $dataObject->group_id;
        $group = KarmaGroup::find($groupId);
        if($sender->id == $group->founder_id){
            $group->active = true;
            $group->save();
        }
        $this->users[$group->id] = array();
        $this->users[$group->id]['subscribers'] = array();
        var_dump('end broadcast');
    }

    private function stopBroadcast($sender, $dataObject, $id)
    {
        var_dump('start stoping broadcast');
        $groupId = $dataObject->group_id;
        $group = KarmaGroup::find($groupId);
        if($sender->id == $group->founder_id){
            $group->active = false;
            $group->save();
        }

        var_dump('detach');
        foreach($this->users[$group->id]['subscribers'] as $user){
            var_dump($user->id);
            $group->activeUsers()->detach($user->id);
        }
        unset($this->users[$group->id]);
        /*
         * TODO: detach all users
         */
        var_dump('end stoping broadcast');
    }

    private function subscribe($sender, $dataObject, $id)
    {
        var_dump('subscribe');
        $user = User::find($sender->id);
        $groupId = $dataObject->group_id;
        $group = KarmaGroup::find($groupId);
        $group->activeUsers()->save($user);
        $group->save();
        $this->users[$group->id]['subscribers'][] = $sender;
        var_dump('end subscibe');
    }

    private function unsubscribe($sender, $dataObject, $id)
    {
        var_dump('unsubscribe');
        $user = User::find($sender->id);
        $groupId = $dataObject->group_id;
        $group = KarmaGroup::find($groupId);
        $group->activeUsers()->detach($user->id);
        $group->save();
        foreach($this->users[$group->id]['subscribers'] as $key => $user){
            if($user->id == $sender->id){
                unset($this->users[$group->id]['subscribers'][$key]);
            }
        }
        var_dump('end unsubscibe');
    }

    private function message($sender, $messageObject, $id)
    {
        var_dump('message');
        $receiver_id = $messageObject->to_user_id;
        $message = $messageObject->message;
        $cid = $id;

        $messageData = array(
            "from_user_id" => $sender->id,
            "to_user_id" => $receiver_id,
            "message" => $message
        );

        $privateMessage = \Karma\Entities\PrivateMessage::create($messageData);
        $messageData['id'] = $privateMessage->id;

        foreach ($this->users as $next)
        {
            if ($next->id == $receiver_id)
            {
                var_dump('send');
                $next->getSocket()->send(json_encode([
                    "type" => "message",
                    "data" => $messageData
                ]));
                break;
            }
        }

        $sender->getSocket()->send(json_encode([
            "type" => "message",
            "data" => $messageData,
            "id" => $cid
        ]));
        $next->notify($receiver_id, \Karma\Entities\NotifType::MESSAGES_NEW);
    }

    private function getFriends($user, $messageArray, $id)
    {
        var_dump('friends');
        $result = $this->getOnlineFriends($user);

        foreach($user->friends() as $friend){
            if(!$this->userInArray($friend, $result)){
                $friend->isOnline = false;
                $result[] = $friend;
            }
        }
        var_dump(json_encode(["result" => $result]));
        $user->getSocket()->send(json_encode([
            "type" => "friends",
            "data" => [
                "result" => $result
            ]
        ]));
    }

    private function userInArray($user, $array)
    {
        foreach($array as $_user)
            if($user->id == $_user->id)
                return true;
        return false;
    }

    private function getOnlineFriends($user)
    {
        $result = array();
        foreach($this->users as $next)
        {
            if($next->isFriend($user->id)){
                $next->isOnline = true;
                $result[] = $next;
            }
        }
        return $result;
    }
}