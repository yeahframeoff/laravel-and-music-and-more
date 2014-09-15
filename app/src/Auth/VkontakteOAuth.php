<?php

namespace Karma\Auth;

use \Config;

class VkontakteOAuth extends OAuth
{
    public function __construct(\Karma\API\InterfaceAPI $interfaceAPI)
    {
        $this->dataArray = array(
            'APIUrl' => 'https://oauth.vk.com/access_token',
            'client_id' => Config::get('app.VKClientId'),
            'client_secret' => Config::get('app.VKClientSecret'),
            'social_id' => \Karma\Entities\Social::byName('vk')->id,
            'redirect' =>'vk',
            'token_key' => 'access_token',
            'key_user_id' => 'user_id'
        );
        
        $this->interfaceAPI = $interfaceAPI;
    }

    public static function getAuthLink($connect = false)
    {
        $cliendId = Config::get('app.VKClientId');
        
        $full_link = "https://oauth.vk.com/authorize?client_id={$cliendId}&scope=audio"
            . '&response_type=code&v=5.23'
            . '&redirect_uri=';
        
        $redirect = 'login';
        
        if($connect)
        {
            $redirect = 'connect';
        }
        
        return $full_link.\URL::to($redirect.'/vk/callback');
    }
}