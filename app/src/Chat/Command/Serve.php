<?php

namespace Karma\Chat\Command;

use Illuminate\Console\Command;
use Karma\Chat\ChatInterface;
use Karma\Chat\UserInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Serve
    extends Command
{
    protected $name        = "chat:serve";
    protected $description = "Command description.";
    protected $chat;

    protected function getUserName($user)
    {
        return "User" . $user->first_name;
    }

    public function __construct(ChatInterface $chat)
    {
        parent::__construct();

        $this->chat = $chat;

        $open = function(UserInterface $user)
        {
            $name = $this->getUserName($user);
            $this->line("
                <info>" . $name . " connected.</info>
            ");
        };

        $this->chat->getEmitter()->on("open", $open);

        $close = function(UserInterface $user)
        {
            $name = $this->getUserName($user);
            $this->line("
                <info>" . $name . " disconnected.</info>
            ");
        };

        $this->chat->getEmitter()->on("close", $close);

        $message = function(UserInterface $user, $message)
        {
            $name = $this->getUserName($user);
            $this->line("
                <info>New message from " . $name . ":</info>
                <comment>" . $message . "</comment>
                <info>.</info>
            ");
        };

        $this->chat->getEmitter()->on("message", $message);

        $error = function(UserInterface $user, $exception)
        {
            $message = $exception->getMessage();

            $this->line("
                <info>User encountered an exception:</info>
                <comment>" . $message . "</comment>
                <info>.</info>
            ");
        };

        $this->chat->getEmitter()->on("error", $error);
    }

    public function fire()
    {
        $port = (integer) $this->option("port");

        if (!$port)
        {
            $port = 7778;
        }

        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    $this->chat
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