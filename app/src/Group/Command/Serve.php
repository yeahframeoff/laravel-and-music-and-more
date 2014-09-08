<?php

namespace Karma\Group\Command;

use Illuminate\Console\Command;
use Karma\Group\GroupInterface;
use Karma\Group\UserInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Wamp\WampServer;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Serve
    extends Command
{
    protected $name        = "group:serve";
    protected $description = "Command description.";
    protected $group;

    protected function getUserName($user)
    {
        return "User" . $user->first_name;
    }

    public function __construct(GroupInterface $group)
    {
        parent::__construct();

        $this->group = $group;
    }

    public function fire()
    {
        $port = (integer) $this->option("port");

        if (!$port)
        {
            $port = 7779;
        }

        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new WampServer(
                        $this->group
                    )
                )
            ),
            $port
        );

        $this->line("
            <info>Listening on port</info>
            <comment>" . $port . "</comment>
            <info>.</info>
        ");

        $server->run();
    }

    protected function getOptions()
    {
        return [
            [
                "port",
                null,
                InputOption::VALUE_REQUIRED,
                "Port to listen on.",
                null
            ]
        ];
    }
}