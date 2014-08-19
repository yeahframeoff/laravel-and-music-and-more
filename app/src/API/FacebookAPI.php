<?php

namespace Karma\API;

use \Karma\Entities\User;
use \Karma\Entities\Credential;
use \Session;
use \Config;
use \Karma\Util\MusicInfo;

class FacebookAPI extends API implements InterfaceAPI
{

    public function __construct()
    {
        $this->apiLink = 'https://graph.facebook.com/';
        $this->applicationKey =  Config::get('app.FBClientId');
        $this->privateKey = Config::get('app.FBClientSecret');
        $this->accessToken = Config::get('app.FBClientToken');
    }

    public function getUserId()
    {        
        $result = $this->APImethodGet(array(), "debug_token?input_token="
                                      . $this->getToken()
                                      . '&access_token=' . $this->accessToken);
        
        return $result['data']['user_id'];
    }

    public function getUserInfo()
    {
        $params = array(
            'access_token' => $this->getToken()
        );

        $info = $this->APImethodGet($params, 'me');
        $result['photo'] = $this->getUserAvatar();
        $result['first_name'] = $info['first_name'];
        $result['last_name'] = $info['last_name'];
        
        return $result;
    }

    public function getUserAudio()
    {
        $credential = Credential::bySocialAndId('fb', 
                                                Session::get('user_id'));
        
        $params = array(
            'access_token' => $this->getToken(),
        );
            
        $info = $this->APImethodGet($params, 'me/likes');
        
        $albums = MusicInfo::getArtistAlbums('Noize MC');
        dd($albums);
        
    }
    
    protected function getToken()
    {
        $result;
        
        if(\Session::has('user_id')){
            $userId = \Session::get('user_id');
            $credential = \Karma\Entities\Credential::bySocialAndId('fb', $userId);
            
            if($credential != NULL)
                $result = $credential->access_token;
            else
                $result = \Session::get('accessToken');
        }
        else
            $result = \Session::get('accessToken');
        
        return $result;
    }

    private function getUserAvatar()
    {
        $params = array(
            'access_token' => $this->getToken(),
            'type' => 'large',
            'redirect' => 0
        );

        $result = $this->APImethodGet($params, 'me/picture');
        
        return $result['data']['url'];
    }
    
}

?>