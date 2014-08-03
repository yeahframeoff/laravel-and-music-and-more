<?php

namespace Karma\API;

class OdnoklassnikiAPI extends API implements InterfaceAPI
{
    
    public function __construct()
    {
        $this->apiLink = 'http://api.odnoklassniki.ru/fb.do';
        $this->applicationKey = 'CBALOCGCEBABABABA';
        $this->privateKey = '93D9DB4E54B94F8A8F76DDFD';
    }
    
    public function getUserId()
    {        
        $sign = md5("application_key=" . $this->applicationKey . "method=users.getCurrentUser"
                    . md5($this->getToken() . $this->privateKey));
        
        $params = array(
            'method' => 'users.getCurrentUser',
            'access_token' => $this->getToken(),
            'application_key' => $this->applicationKey,
            'sig' => $sign
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