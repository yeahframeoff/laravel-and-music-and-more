<?php

namespace Karma\Group;

use Evenement\EventEmitterInterface;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

interface UserInterface
{
    public function getSocket();
    public function setSocket(ConnectionInterface $socket);
}