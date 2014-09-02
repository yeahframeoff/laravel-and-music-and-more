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
        var_dump($functionName);
        $this->$functionName($user, $message);

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

        if ($user)
        {
            $this->users->detach($user);
            $this->emitter->emit("close", [$user]);
        }
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

    private function message($sender, $messageArray)
    {
        var_dump('message');
        $id = $messageArray->user;
        $message = $messageArray->data;

        $privateMessage = \Karma\Entities\PrivateMessage::create(array(
            'from_user_id' => $sender->id,
            'to_user_id' => $id,
            'message' => $message
        ));

        foreach ($this->users as $next)
        {
            if ($next->id == $id)
            {
                var_dump('send');
                $next->getSocket()->send(json_encode([
                    "id" => $sender->id,
                    "type" => "message",
                    "message" => $message
                ]));
            }
        }
        $next->notify($id, \Karma\Entities\NotifType::MESSAGES_NEW);
    }

    private function getFriends($user, $messageArray)
    {
        var_dump('friends');
        $online = array();
        foreach ($this->users as $next)
        {
            var_dump('foreach');
            if($next->isFriend($user->id)){
                $online[] = $next;
                var_dump('is friend');
            }
        }

        var_dump(count($online));
        $result = array();
        $result['online'] = $online;
        foreach($user->friends() as $friend){
            if(!$this->userInArray($friend, $online)){
                $result['offline'][] = $friend;
            }
        }
        var_dump(json_encode(["result" => $result]));
        $user->getSocket()->send(json_encode([
            "result" => $result,
            "type" => "friends"
        ]));
    }

    private function userInArray($user, $array)
    {
        foreach($array as $_user)
            if($user->id == $_user->id)
                return true;
        return false;
    }
}