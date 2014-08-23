<?php

class SocialsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('socials')->delete();

        \Karma\Entities\Social::create(array('name' => 'fb', 'title' => 'Facebook'));
        \Karma\Entities\Social::create(array('name' => 'vk', 'title' => 'ВКонтакте'));
        \Karma\Entities\Social::create(array('name' => 'ok', 'title' => 'Одноклассники'));
    }
}