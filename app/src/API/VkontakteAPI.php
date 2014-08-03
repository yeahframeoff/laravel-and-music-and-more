<?php

namespace Karma\API;

class VkontakteAPI extends API implements InterfaceAPI
{
    
    public function __construct()
    {
        $this->apiLink = 'https://api.vk.com/method/';
        $this->accessToken = $this->getToken();
        $this->applicationKey = '4484087';
        $this->privateKey = 'Q8sHnIlcnvF13GK2ptEx';
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
    
    protected function getToken()
    {
        return \Session::get('accessToken');
    }
}

?>