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
        $cookie = $socket->WebSocket->request->getCookie('uid');
        dd($socket);
        var_dump($cookie);
        /*
        $path = \Config::get('session.files');
        $filesystem = new \Illuminate\Filesystem\Filesystem();
        $files = new \Illuminate\Session\FileSessionHandler($filesystem, $path);
        //var_dump($files->read('1bd425b29ad260f7f98c2027798b997d16bd8e7c'));
        */
        $user = new User();
        $user->setSocket($socket);

        $this->users->attach($user);
        $this->emitter->emit("open", [$user]);
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

        foreach ($this->users as $next)
        {
            if ($next !== $user)
            {
                $next->getSocket()->send(json_encode([
                    "user" => [
                        "id"   => $user->id,
                        "name" => $user->first_name
                    ],
                    "message" => $message
                ]));
            }
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
}