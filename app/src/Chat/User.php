<?php

namespace Karma\Chat;

use Ratchet\ConnectionInterface;

class User
    extends \Karma\Entities\User
    implements UserInterface
{
    protected $socket;

    public function getSocket()
    {
        return $this->socket;
    }

    public function setSocket(ConnectionInterface $socket)
    {
        $this->socket = $socket;
        return $this;
    }
}