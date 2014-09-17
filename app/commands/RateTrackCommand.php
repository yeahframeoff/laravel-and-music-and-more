<?php

class RateTrackCommand extends AbstractRateObjectCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'rate:track';

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
        parent::toFire('\Karma\Entities\Track');
    }

    public function modelNotFoundMessage(ModelNotFoundException $e)
    {
        return "Track {$e->id} not found";
    }

}
