<?php

use \Karma\Entities\User;

class FriendsTest extends TestCase
{
    protected $alex;
    protected $tmpUser;
    protected $third;
       
    public function testIsFriend()
    {
        $this->assertFalse($this->alex->isFriend($this->tmpUser->id));
        $this->assertFalse($this->tmpUser->isFriend($this->alex->id));
    }        
     
    public function testSendRequest()
    {
        $this->alex->sendRequest($this->tmpUser->id);
        
        $this->assertCount(1, $this->alex->sentFriendshipRequests());
        $this->assertCount(1, $this->tmpUser->friendshipRequests());        
    }
    
    public function testRemoveRequest()
    {
        $this->alex->sendRequest($this->tmpUser->id);
        $this->alex->removeRequest($this->tmpUser->id);
        
        $this->assertCount(0, $this->alex->sentFriendshipRequests());
        $this->assertCount(0, $this->tmpUser->friendshipRequests());
    }
    
    public function testConfirmFriend()
    {
        $this->alex->sendRequest($this->tmpUser->id);
        $this->tmpUser->confirmFriend($this->alex->id);
        
        $this->assertTrue($this->alex->isFriend($this->tmpUser->id));
        $this->assertTrue($this->tmpUser->isFriend($this->alex->id));
    }
    
    public function testDeleteFriend()
    {
        $this->alex->sendRequest($this->tmpUser->id);
        $this->tmpUser->confirmFriend($this->alex->id);
        $this->alex->deleteFriend($this->tmpUser->id);
        
        $this->assertFalse($this->alex->isFriend($this->tmpUser->id));
        $this->assertFalse($this->tmpUser->isFriend($this->alex->id));
    }
    
    public function testGetFriends()
    {
        $this->alex->sendRequest($this->tmpUser->id);
        $this->alex->sendRequest($this->third->id);
        $this->tmpUser->confirmFriend($this->alex->id);
        $this->third->confirmFriend($this->alex->id);
        
        $this->assertCount(2, $this->alex->friends());
        $this->assertEquals($this->tmpUser->first_name, $this->alex->friends()[0]->first_name);
    }
    
    public function testEmptyFriends()
    {
        $this->assertCount(0, $this->alex->friends());
    }
    
    public function testEmptyFriendshipRequests()
    {
        $this->assertCount(0, $this->alex->friendshipRequests());
    }
    
    public function testEmptySentFriendshipRequests()
    {
        $this->assertCount(0, $this->alex->sentFriendshipRequests());
    }
    
    public function setUp()
    {
        parent::setUp();
        
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
        
        $this->alex = $alex;
        $this->tmpUser = $tmpUser;
        $this->third = $third;
    }
}

?>