<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        $this->call('SocialsTableSeeder');
        $this->call('UsersTableSeeder');
        $this->call('NotificationTypesTableSeeder');
	}
}