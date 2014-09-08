<?php

namespace Karma\Group;

use Evenement\EventEmitterInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\WampServerInterface;

interface GroupInterface
    extends WampServerInterface
{
    //public function getUserBySocket(ConnectionInterface $socket);
    //public function getEmitter();
    //public function setEmitter(EventEmitterInterface $emitter);
    //public function getUsers();
}