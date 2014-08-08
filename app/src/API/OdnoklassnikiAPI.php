<?php

namespace Karma\API;

class OdnoklassnikiAPI extends API implements InterfaceAPI
{
    
    public function __construct()
    {
        $this->apiLink = 'http://api.odnoklassniki.ru/fb.do';
        $this->applicationKey = \Config::get('app.OKClientId');
        $this->privateKey = \Config::get('app.OKClientSecret');
    }
    
    public function getUserId($fullInfo = false)
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
        if ($fullInfo)
            return $result;
        else
            return $result['uid'];
    }
    
    public function getUserInfo()
    {
        $userData = $this->getUserId(true);
        $userInfo = array(
            'id' => $userData['uid'],
            'photo' => $userData['pic_1'],
            'city' => $userData['location']['city'],
            'country' => $userData['location']['country'],
            'first_name' => $userData['first_name'],
            'last_name' => $userData['last_name']
        );
        return $userInfo;
    }
    
    protected function getToken()
    {
        $result;
        if(\Session::has('user_id')){
            $userId = \Session::get('user_id');
            $credential = \Karma\Entities\Credential::whereRaw(
                'user_id = ? and social_id = 3', array($userId)
            )->first();
            if($credential != NULL)
                $result = $credential->token;
            else
                $result = \Session::get('accessToken');
        }
        else
            $result = \Session::get('accessToken');
        return $result;
    }
}

?>