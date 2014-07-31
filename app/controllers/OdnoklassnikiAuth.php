<?php

use Karma\Entities;
use Karma\Entities\Credential;
use Jyggen\Curl\Curl;

class OdnoklassnikiAuth implements AuthInterface
{
    const APP_ID = '1096935936';
    const PUBLIC_KEY = 'CBALOCGCEBABABABA';
    const PRIVATE_KEY = '93D9DB4E54B94F8A8F76DDFD';
    const AUTH_LINK = 'http://www.odnoklassniki.ru/oauth/authorize';
    const SUCCES_REDIRECT = 'http://target-green.codio.io:3000/successAuth';
    const SOCIAL_ID = 2;

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
            //dd($response);

            if (isset($response['access_token'])) {
                //md5('application_key=' . $AUTH['application_key'] . 'method=users.getCurrentUser' . md5($auth['access_token'] . $AUTH['client_secret'])));
                $sign = md5("application_key=" . self::PUBLIC_KEY . "method=users.getCurrentUser"
                            . md5($response['access_token'] . self::PRIVATE_KEY));
                $refreshToken = $response['refresh_token'];

                $params = array(
                    'method' => 'users.getCurrentUser',
                    'access_token' => $response['access_token'],
                    'application_key' => self::PUBLIC_KEY,
                    'sig' => $sign
                );

                $response = Curl::post('http://api.odnoklassniki.ru/fb.do', $params)[0];
                $userInfo = $response->getContent();
                $userInfo = json_decode($userInfo, true);
                //dd($userInfo);

                if (isset($userInfo['uid'])) {
                    $odnoklassnikiId = $userInfo['uid'];
                    //$credential = Karma\Entities\Credential::find(1);
                    //dd($credential);
                    
                    
                    $credential = Karma\Entities\Credential::firstOrNew(array(
                        'social_id' => self::SOCIAL_ID,
                        'external_id' => $odnoklassnikiId,
                    ));
                    if(!isset($credential->id)){
                        $user = new Karma\Entities\User;
                        $user->save();
                        $credential->user_id = $user->id;
                    }
                    $credential->token = $refreshToken;
                    $credential->save();
                    //dd($credential);
                    Session::put('user_id', $credential->user_id);
                    $result = true;
                }
            }
        }
        return $result;
    }

    public static function getUserId()
    {
        //dd(Session::get('user_id'));
        return Session::get('user_id');
    }
    
    public static function logout()
    {
        Session::forget('user_id');
    }
    
    private static function refreshToken($id)
    {
        $refreshToken = Credential::where(array(
            'user_id' => $id,
            'social_id' => self::SOCIAL_ID        
        ))->first()->token;
        
        $response = Curl::post('http://api.odnoklassniki.ru/oauth/token.do', 
                               array(
                                   'refresh_token' => $refreshToken,
                                   'grant_type' => 'refresh_token',
                                   'client_id' => self::APP_ID,
                                   'client_secret' => self::PRIVATE_KEY
                               ))[0];
        $content = $response->getContent();
        $response = json_decode($content, true);
        dd($response);
    }
}

?>