<?php

use \Karma\Entities\Social;

class SocialsTableSeeder extends Seeder 
{
    public function run()
    {
        DB::table('socials')->delete();

        Social::create(['name' => 'fb', 'title' => 'Facebook']);
        Social::create(['name' => 'vk', 'title' => 'ВКонтакте']);
        Social::create(['name' => 'ok', 'title' => 'Одноклассники']);

        $this->command->info('Socials table seeded!');
    }
}