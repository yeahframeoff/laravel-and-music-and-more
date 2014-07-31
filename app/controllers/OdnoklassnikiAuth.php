<?php

use Karma\Entities;
use Jyggen\Curl\Curl;

class OdnoklassnikiAuth implements AuthInterface
{
    const APP_ID = '1096935936';
    const PUBLIC_KEY = 'CBALOCGCEBABABABA';
    const PRIVATE_KEY = '93D9DB4E54B94F8A8F76DDFD';
    const AUTH_LINK = 'http://www.odnoklassniki.ru/oauth/authorize';
    const SUCCES_REDIRECT = 'http://target-green.codio.io:3000/successAuth';

    public static function auth()
    {

    }

    public static function getAuthLink(){
        $full_link = self::AUTH_LINK . '?client_id=' .  self::APP_ID
            . '&response_type=code&redirect_uri=' . self::SUCCES_REDIRECT;
        return $full_link;
    }

    public static function success()
    {

        $result = false;
        if (Input::has('code')) {

            $response = Curl::post('http://api.odnoklassniki.ru/oauth/token.do', 
                                   array(
                                       'code' => Input::get('code'),
                                       'redirect_uri' => self::SUCCES_REDIRECT,
                                       'grant_type' => 'authorization_code',
                                       'client_id' => self::APP_ID,
                                       'client_secret' => self::PRIVATE_KEY
                                   ))[0];
            $content = $response->getContent();
            $response = json_decode($content, true);

            if (isset($response['access_token'])) {
                //md5('application_key=' . $AUTH['application_key'] . 'method=users.getCurrentUser' . md5($auth['access_token'] . $AUTH['client_secret'])));
                $sign = md5("application_key=" . self::PUBLIC_KEY . "method=users.getCurrentUser"
                            . md5($response['access_token'] . self::PRIVATE_KEY));

                $params = array(
                    'method' => 'users.getCurrentUser',
                    'access_token' => $response['access_token'],
                    'application_key' => self::PUBLIC_KEY,
                    'sig' => $sign
                );

                $response = Curl::post('http://api.odnoklassniki.ru/fb.do', $params)[0];
                $userInfo = $response->getContent();
                dd($userInfo);

                if (isset($userInfo['uid'])) {
                    $OdnoklassnikiId = $userInfo['uid'];
                    //$credential = Credential::firstOrNew(array(''))
                    $result = true;
                }
            }
        }
        return $result;
    }
}

?>