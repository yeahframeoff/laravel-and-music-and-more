<?php

namespace Karma\Auth;

class FacebookOAuth extends OAuth
{
    public function __construct(\Karma\API\InterfaceAPI $interfaceAPI)
    {
        $this->dataArray = array(
            'APIUrl' => 'https://graph.facebook.com/oauth/access_token',
            'client_id' => '1446675095605125',
            'client_secret' => 'e98bafaf60c6c78104df3de28339acdb',
            'social_id' => Social::byName('fb')->id,
            'redirect' => 'login/fb/callback',
            'token_key' => 'access_token'
        );
        
        $this->interfaceAPI = $interfaceAPI;
    }

    public static function getAuthLink()
    {
        $full_link = 'https://www.facebook.com/dialog/oauth?'
            . 'client_id=1446675095605125'
            . '&redirect_uri='
            . \URL::to('login/fb/callback');
        
        return $full_link;
    }
}