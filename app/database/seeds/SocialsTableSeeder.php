<?php

use \Karma\Entities\Social;

class SocialsTableSeeder extends Seeder 
{
    public function run()
    {
        DB::table('socials')->delete();

        Social::create(array('name' => 'fb', 'title' => 'Facebook'));
        Social::create(array('name' => 'vk', 'title' => 'ВКонтакте'));
        Social::create(array('name' => 'ok', 'title' => 'Одноклассники'));

        $this->command->info('Socials table seeded!');
    }
}