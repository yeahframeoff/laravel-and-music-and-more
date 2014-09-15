<?php

namespace Karma\API;

use \User;
use \Session;

class VkontakteAPI extends API implements InterfaceAPI
{    
    public function __construct()
    {
        $this->apiLink = 'https://api.vk.com/method/';
        $this->applicationKey = \Config::get('app.VKClientId');
        $this->privateKey = \Config::get('app.VKClientSecret');
    }
    
    public function getUserId()
    {
        $params = array(
            'access_token' => $this->getToken(),
            'user_ids'
        );

        $result = $this->APImethod($params);
        
        return $result['uid'];
    }
    
    public function getUserInfo()
    {
        $userId = \Session::get('user_id');
        $credential = \Karma\Entities\Credential::bySocialAndId('vk', $userId);
            
        $uid = \Session::get('external_id') or $credential->external_id;
        
        $params = array(
            'user_ids' => $uid,
            'fields' => implode(',', array(
                'city',
                'country',
                'photo_max_orig'
            )),
            'access_token' => $this->getToken()
        );
        
        $info = $this->APImethod($params, 'users.get')['response'][0];
        
        $result = array(
            'photo' => $info['photo_max_orig'],
            'first_name' => $info['first_name'],
            'last_name' => $info['last_name']
        );
        
        return $result;
    }
    
    public function getUserAudio()
    {
        $credential = \Karma\Entities\Credential::bySocialAndId('vk', 
                                                                Session::get('user_id'));
        
        $params = array(
            'owner_id' => $credential->external_id,
            'need_user' => 0,
            'access_token' => $this->getToken()
        );
        
        $result = $this->APImethod($params, 'audio.get')['response'];
        array_shift($result);
        $result = array_map(function($track){
            $track['title'] = str_replace(['[',']'], '', $track['title']);
            $track['artist'] = str_replace(['[',']'], '', $track['artist']);
            return $track;
        }, $result);
        return $result;
    }
    
    protected function getToken()
    {
        $result;
        
        if(\Session::has('user_id')){
            $userId = \Session::get('user_id');
            $credential = \Karma\Entities\Credential::bySocialAndId('vk', $userId);
            
            if($credential != NULL)
                $result = $credential->access_token;
            else
                $result = \Session::get('accessToken');
        }
        else
            $result = \Session::get('accessToken');
        
        return $result;
    }
}