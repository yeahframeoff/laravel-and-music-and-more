<?php

class GenresTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('genres')->delete();

        \Karma\Entities\Genre::create(array('name' => 'unknown'));
    }
}