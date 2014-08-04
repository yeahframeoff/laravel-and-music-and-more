<?php

namespace Karma\API;

use \User;

class VkontakteAPI extends API implements InterfaceAPI
{
    
    public function __construct()
    {
        $this->apiLink = 'https://api.vk.com/method/';
        $this->accessToken = $this->getToken();
        $this->applicationKey = \Config::get('app.VKClientId');
        $this->privateKey = \Config::get('app.VKClientSecret');
    }
    
    public function getUserId()
    {
        $params = array(
            'access_token' => $this->accessToken,
            'user_ids'
        );

        $result = $this->APImethod($params);
        return $result['uid'];
    }
    
    public function getUserInfo()
    {
        $userId = \Session::get('user_id');
        $credential = \Karma\Entities\Credential::whereRaw(
            'user_id = ? and social_id = 2', array($userId)
        )->first();
                
        $params = array(
            'user_ids' => $credential->external_id,
            'fields' => implode(',', array(
                'city',
                'country',
                'photo_max_orig'
            )),
            'access_token' => $this->getToken()
        );
        
        $result = $this->APImethod($params, 'users.get')['response'][0];
        $result['photo'] = $result['photo_max_orig'];
        $result['id'] = $result['uid'];
        return $result;
    }
    
    protected function getToken()
    {
        return \Session::get('accessToken');
    }
}

?>