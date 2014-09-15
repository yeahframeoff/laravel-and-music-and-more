<?php

namespace Karma\Group;

use Evenement\EventEmitterInterface;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

interface GroupInterface
    extends MessageComponentInterface
{
    public function getUserBySocket(ConnectionInterface $socket);
    public function getEmitter();
    public function setEmitter(EventEmitterInterface $emitter);
    public function getUsers();
}