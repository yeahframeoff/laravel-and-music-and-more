<?php

namespace Karma\Chat;

use Evenement\EventEmitterInterface;
use Exception;
use Ratchet\ConnectionInterface;
use SplObjectStorage;

class Chat
    implements ChatInterface
{
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
        $this->users   = new SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $socket)
    {
        try{
            $user = $this->getUserFromCookie($socket);
            $user->setSocket($socket);
            $this->users->attach($user);
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
        $user = $this->getUserBySocket($socket);
        $message = json_decode($message);

        $this->emitter->emit("message", [
            $user,
            $message->type
        ]);

        $functionName = $message->type;
        if(method_exists($this, $functionName)){
            if(isset($message->id))
                $id = $message->id;
            else
                $id = NULL;
            $this->$functionName($user, $message->data, $id);
        } else {
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
        $user = $this->getUserBySocket($socket);

        $onlineFriends = $this->getOnlineFriends($user);
        foreach($onlineFriends as $onlineFriend){
            $onlineFriend->getSocket()->send(json_encode([
                "type" => "offlineNow",
                "data" => '',
                "id" => $user->id
            ]));
        }
        $this->users->detach($user);
        $this->emitter->emit("close", [$user]);
    }

    public function onError(
        ConnectionInterface $socket,
        Exception $exception
    )
    {
        $user = $this->getUserBySocket($socket);

        if ($user)
        {
            $user->getSocket()->close();
            $this->emitter->emit("error", [$user, $exception]);
        }
    }

    private function getUserFromCookie($socket)
    {
        var_dump($socket->WebSocket->request);
        $cookie = $socket->WebSocket->request->getCookie('laravel_session');
        var_dump($cookie);
        $cookie = str_replace('%3D', '', $cookie);
        $key = \Config::get('app.key');
        var_dump($key);
        $encryptor = new \Illuminate\Encryption\Encrypter($key);
        $id = $encryptor->decrypt($cookie);
        var_dump($id);
        $payload = base64_decode(\DB::table('sessions')->where('id', $id)->first()->payload);
        $payload = unserialize($payload);
        var_dump($payload);
        $user = User::find($payload['user_id']);
        return $user;
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