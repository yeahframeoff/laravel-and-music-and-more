<?php

use \Karma\Entities\User;

class FriendsTest extends TestCase
{
    public function testFriend()
    {
        $alex = new User;
        $alex->first_name = 'Alex';
        $alex->last_name = 'Podlesniy';
        $alex->photo = 'photo';
        $alex->save();
        
        $tmpUser = new User;
        $tmpUser->first_name = 'first';
        $tmpUser->last_name = 'last';
        $tmpUser->photo = 'photo_tmp';
        $tmpUser->save();
                
        $this->assertFalse($alex->isFriend($tmpUser->id));
        
        $alex->sendRequest($tmpUser->id);
        $this->assertFalse($alex->isFriend($tmpUser->id));
        
        $tmpUser->confirmFriend($alex->id);
        $this->assertTrue($alex->isFriend($tmpUser->id));
        $this->assertTrue($tmpUser->isFriend($alex->id));
        
        $alex->deleteFriend($tmpUser->id);
        $this->assertFalse($alex->isFriend($tmpUser->id));
        $this->assertFalse($alex->isFriend($tmpUser->id));
    }
    
    public function testGetsFriends()
    {
        $alex = new User;
        $alex->first_name = 'Alex';
        $alex->last_name = 'Podlesniy';
        $alex->photo = 'photo';
        $alex->save();
        
        $tmpUser = new User;
        $tmpUser->first_name = 'first';
        $tmpUser->last_name = 'last';
        $tmpUser->photo = 'photo_tmp';
        $tmpUser->save();
        
        $third = new User;
        $third->first_name = 'third';
        $third->last_name = 'tlast';
        $third->photo = 'photo3';
        $third->save();
        
        $this->assertCount(0, $alex->friends());
        $this->assertCount(0, $alex->friendshipRequests());
        
        $alex->sendRequest($tmpUser->id);
        $alex->sendRequest($third->id);
        $this->assertCount(1, $tmpUser->friendshipRequests());
        $this->assertCount(2, $alex->sentFriendshipRequests());
        
        $tmpUser->confirmFriend($alex->id);
        $third->confirmFriend($alex->id);
        $this->assertCount(2, $alex->friends());
        $this->assertEquals($tmpUser->first_name, $alex->friends()[0]->first_name);        
    }
}

?>