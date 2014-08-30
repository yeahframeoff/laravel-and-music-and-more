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
            $cookie = $socket->WebSocket->request->getCookie('laravel_session');
            $cookie = str_replace('%3D', '', $cookie);
            $key = \Config::get('app.key');
            $encryptor = new \Illuminate\Encryption\Encrypter($key);
            $id = $encryptor->decrypt($cookie);
            $payload = base64_decode(\DB::table('sessions')->where('id', $id)->first()->payload);
            $payload = unserialize($payload);
            $user = User::find($payload['user_id']);
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
            $message->data
        ]);

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

    private function sendMessageToIdFromId($id, $message, $senderId)
    {
        foreach ($this->users as $next)
        {
            if ($next->id == $id)
            {
                var_dump('send');
                $next->getSocket()->send(json_encode([
                    "id" => $senderId,
                    "message" => $message
                ]));
            }
        }
    }
}