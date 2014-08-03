<?php

namespace Karma\Auth;

class VkontakteOAuth extends OAuth
{

    public function __construct(\Karma\API\InterfaceAPI $interfaceAPI)
    {
        $this->dataArray = array(
            'APIUrl' => 'https://oauth.vk.com/access_token',
            'client_id' => '4484087',
            'client_secret' => 'Q8sHnIlcnvF13GK2ptEx',
            'social_id' => 1,
            'redirect' =>'successAuthVK',
            'token_key' => 'access_token',
            'key_user_id' => 'user_id'
        );
        $this->interfaceAPI = $interfaceAPI;
    }

    public static function getAuthLink()
    {
        $fullLink = 'https://oauth.vk.com/authorize?client_id=4484087&scope=audio'
            . '&response_type=code&v=5.23'
            . '&redirect_uri=http://target-green.codio.io:3000/successAuthVK';
        return $fullLink;
    }

}

?>