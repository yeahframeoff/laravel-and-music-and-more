<?php

namespace Karma\Auth;

class OdnoklassnikiOAuth extends OAuth
{

    public function __construct(\Karma\API\InterfaceAPI $interfaceAPI)
    {
        $this->dataArray = array(
            'APIUrl' => 'http://api.odnoklassniki.ru/oauth/token.do',
            'client_id' => '1096935936',
            'client_secret' => '93D9DB4E54B94F8A8F76DDFD',
            'token_key' => 'refresh_token',
            'social_id' => 2,
            'redirect' => 'successAuthOK',
            'grant_type' => 'authorization_code'
        );
        $this->interfaceAPI = $interfaceAPI;
    }

    public static function getAuthLink()
    {
        $full_link = 'http://www.odnoklassniki.ru/oauth/authorize?'
            . 'client_id=1096935936&response_type=code'
            . '&redirect_uri=http://target-green.codio.io:3000/successAuthOK';
        return $full_link;
    }

}

?>