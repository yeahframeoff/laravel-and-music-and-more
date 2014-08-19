<?php

class SocialsTableSeeder extends Seeder 
{
    public function run()
    {
        DB::table('socials')->delete();

        \Karma\Entities\Social::create(array('name' => 'fb'));
        \Karma\Entities\Social::create(array('name' => 'vk'));
        \Karma\Entities\Social::create(array('name' => 'ok'));
        
        $this->command->info('Socials table seeded!');
    }
}