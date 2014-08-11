<?php

namespace Karma\Auth;

class VkontakteOAuth extends OAuth
{
    public function __construct(\Karma\API\InterfaceAPI $interfaceAPI)
    {
        $this->dataArray = array(
            'APIUrl' => 'https://oauth.vk.com/access_token',
            'client_id' => \Config::get('app.VKClientId'),
            'client_secret' => \Config::get('app.VKClientSecret'),
            'social_id' => \Karma\Entities\Social::byName('vk')->id,
            'redirect' =>'vk',
            'token_key' => 'access_token',
            'key_user_id' => 'user_id'
        );
        
        $this->interfaceAPI = $interfaceAPI;
    }

    public static function getAuthLink()
    {
        $cliendId = \Config::get('app.VKClientId');
        
        $fullLink = "https://oauth.vk.com/authorize?client_id={$cliendId}&scope=audio"
            . '&response_type=code&v=5.23'
            . '&redirect_uri='
            . \URL::to('login/vk/callback');
        
        return $fullLink;
    }
}