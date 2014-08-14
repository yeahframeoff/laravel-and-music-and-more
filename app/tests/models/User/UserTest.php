<?php

use \Karma\Entities\User;
use \Karma\Entities\Credential;
use \Karma\Entities\Social;

class UserTest extends TestCase
{
    protected $alex;
    
    public function testCredentials()
    {
        $params = array(
            'user_id' => $this->alex->id,
            'social_id' => 1,
            'external_id' => 12345,
            'refresh_token' => 'refresh',
            'access_token' => 'access'
        );
        Credential::create($params);
        $params['social_id'] = 2;
        $params['external_id'] = 54321;
        Credential::create($params);
        
        $this->assertCount(2, $this->alex->credentials);
        $this->assertEquals(12345, $this->alex->credentials[0]->external_id);
    }
    
    public function setUp()
    {
        parent::setUp();
        
        $alex = new User;
        $alex->first_name = 'Alex';
        $alex->last_name = 'Podlesniy';
        $alex->photo = 'photo';
        $alex->save();
        $this->alex = $alex;
        
        Social::create(array('name' => 'fb'));
        Social::create(array('name' => 'vk'));
        Social::create(array('name' => 'ok'));        
    }
}

?>