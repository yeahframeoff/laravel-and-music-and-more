<?php

class NetworkDatabaseSeeder extends Seeder {

    public function run()
    {
        DB::table('socials')->delete();

        Karma\Entities\Social::create(array('name' => 'FB'));
        Karma\Entities\Social::create(array('name' => 'VK'));
        Karma\Entities\Social::create(array('name' => 'OK'));
    }

}

?>
