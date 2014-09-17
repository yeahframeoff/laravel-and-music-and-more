<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


abstract class AbstractRateObjectCommand extends Command
{
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('id', InputArgument::REQUIRED, 'Id of the object'),
            array('value', InputArgument::REQUIRED, 'Rate for the object.'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array();
    }

    public function toFire($className)
    {
        try {
            $value = $this->argument('value');
            $id = $this->argument('id');
            $object = $className::findOrFail($id);
            \Karma\Entities\User::with('rates')->orderByRaw('RAND()')->chunk(50,
                function($users) use ($object, $className, $id)
                {
                    foreach ($users as $user)
                    {
                        $user->rate($object, rand(1, 5));
                        $this->info("User  $user rated $className #$id");
                    }
                }
            );


        }
        catch (ModelNotFoundException $e)
        {
            $this->error($this->modelNotFoundMessage($e));
        }
    }

    abstract function modelNotFoundMessage(ModelNotFoundException $e);
} 