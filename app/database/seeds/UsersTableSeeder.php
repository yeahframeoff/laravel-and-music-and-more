<?php

use Karma\Entities\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('friends')->whereBetween('user_id', array(100, 103))
                            ->orWhereBetween('friend_id', array(100, 103))->delete();
        
        User::whereBetween('id', array(100, 103))->delete();
        
        User::create(array('id' => 100, 'first_name' => 'Василий', 'last_name' => 'Пупкин', 'photo' => 'http://w00t.com.au/wp-content/uploads/2013/12/evil-raccoon-300x300.jpg'));
        User::create(array('id' => 101, 'first_name' => 'Петр', 'last_name' => 'Петров', 'photo' => 'http://www.polyvore.com/cgi/img-thing?.out=jpg&size=l&tid=15159172'));
        User::create(array('id' => 102, 'first_name' => 'Иван', 'last_name' => 'Иванов', 'photo' => 'http://www.treatment4addiction.com/blog/wp-content/uploads/raccoon-300x300.jpg'));
        User::create(array('id' => 103, 'first_name' => 'Сергей', 'last_name' => 'Сергеев', 'photo' => 'http://cs9640.vk.me/g16252384/a_fcbbb788.jpg'));
        
        $first = User::find(1);
        
        if ($first === null) return;
        
        $first->sendRequest(100);
        $first->sendRequest(101);
        $first->sendRequest(102);
        $first->sendRequest(103);
        
        User::find(100)->confirmFriend(1);
        User::find(101)->confirmFriend(1);
        User::find(102)->confirmFriend(1);
        User::find(103)->confirmFriend(1);
    }
}