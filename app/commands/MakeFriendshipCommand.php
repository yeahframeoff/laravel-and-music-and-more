<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Karma\Entities\User;

class MakeFriendshipCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'friendship:make';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Add friendship for friends view test.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$userIds = $this->retrieveUsers();
        if ($userIds === false)
            return;
        
        $user1 = User::findOrFail($userIds[0]);
        $user1->forceFriendshipTo($userIds[1]);
	}
    
    private function retrieveUsers()
    {
        $users = $this->option('user');
        if (count($users) == 1)
        {
            $this->error('You should specify two users');
            $users = [];
        }
        
        if (count ($users) >= 2)
        {
            $users = array_slice($users, 0, 2);
            if (!is_int($users[0]) || $users[0] == 0 || !is_int($users[1]) || $users[1] == 0)
                $users = [];
        }
        
        if (count($users) == 0)
        {
            do {
                $uid1 = $this->ask('ID of the user 1: ');
                if ($uid1 == 'q') break;
                $uid1 = (integer) $uid1;
            }
            while (!is_int($uid1) || $uid1 == 0);
            if ($uid1 == 'q') return false;
            
            do {
                $uid2 = $this->ask("ID of the user 2 (different from $uid1): ");    
                if ($uid2 == 'q') break;
                $uid2 = (integer) $uid2;
            }
            while (!is_int($uid2) || $uid2 == 0 || $uid2 == $uid1);
            if ($uid1 == 'q') return false;
            $users = [$uid1, $uid2];
        }
        
        return $users;
    }

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
            ['user', 'user', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'User to be a friend']
        ];
	}

}
