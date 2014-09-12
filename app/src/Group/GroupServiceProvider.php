<?php

namespace Karma\Group;

use Evenement\EventEmitter;
use Illuminate\Support\ServiceProvider;
use Ratchet\Server\IoServer;

class GroupServiceProvider
    extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->bind("group.emitter", function()
        {
            return new EventEmitter();
        });

        $this->app->bind("group.group", function()
        {
            return new Group(
                $this->app->make("group.emitter")
            );
        });

        $this->app->bind("group.user", function()
        {
            return new \Karma\Entities\User();
        });

        $this->app->bind("group.command.serve", function()
        {
            return new Command\Serve(
                $this->app->make("group.group")
            );
        });

        $this->commands("group.command.serve");
    }

    public function provides()
    {
        return [
            "group.chat",
            "group.command.serve",
            "group.emitter",
            "group.server"
        ];
    }
}