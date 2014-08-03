<?php

namespace Karma\API;

class FacebookAPI extends API implements InterfaceAPI
{
    
    public function __construct()
    {
        $this->apiLink = 'http://api.odnoklassniki.ru/fb.do';
        $this->applicationKey = '1446675095605125';
        $this->privateKey = 'e98bafaf60c6c78104df3de28339acdb';
    }
    
    public function getUserId()
    {        
        $sign = md5("application_key=" . $this->applicationKey . "method=users.getCurrentUser"
                    . md5($this->getToken() . $this->privateKey));
        
        dd($this->getToken());
        
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