<?php

namespace Karma\Auth;

class FacebookOAuth extends OAuth
{

    public function __construct(\Karma\API\InterfaceAPI $interfaceAPI)
    {
        $this->dataArray = array(
            'APIUrl' => 'https://graph.facebook.com/oauth/access_token',
            'client_id' => '855041994513449',
            'client_secret' => '506585f3c1004d81bb1c2a64631abbc2',
            'social_id' => 0,
            'redirect' => 'successAuthFB',
        );
        $this->interfaceAPI = $interfaceAPI;
    }

    public static function getAuthLink()
    {
        $full_link = 'https://www.facebook.com/dialog/oauth?'
            . 'client_id=1446675095605125'
            . '&redirect_uri=http://target-green.codio.io:3000/successAuthFB';
        return $full_link;
    }

}

?>