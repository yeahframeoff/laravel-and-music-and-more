<?php

namespace Karma\Auth;

class OdnoklassnikiOAuth extends OAuth
{

    public function __construct(\Karma\API\InterfaceAPI $interfaceAPI)
    {
        $this->dataArray = array(
            'APIUrl' => 'http://api.odnoklassniki.ru/oauth/token.do',
            'client_id' => \Config::get('app.OKAppId'),
            'client_secret' => \Config::get('app.OKClientSecret'),
            'token_key' => 'refresh_token',
            'social_id' => 3,
            'redirect' => 'successAuthOK',
            'grant_type' => 'authorization_code'
        );
        $this->interfaceAPI = $interfaceAPI;
    }

    public static function getAuthLink()
    {
        $appId = \Config::get('app.OKAppId');
        
        $full_link = 'http://www.odnoklassniki.ru/oauth/authorize?'
            . "client_id={$appId}&response_type=code"
            . '&redirect_uri=http://target-green.codio.io:3000/successAuthOK';
        return $full_link;
    }

}

?>