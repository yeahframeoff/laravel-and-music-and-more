<?php

class RatePlaylistCommand extends AbstractRateObjectCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'rate:playlist';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        parent::toFire('\Karma\Entities\Playlist');
    }

    public function modelNotFoundMessage(ModelNotFoundException $e)
    {
        return "Playlist {$e->id} not found";
    }

}
