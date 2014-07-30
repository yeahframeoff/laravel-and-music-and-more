<?php

use Jyggen\Curl\Curl;

/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 30.07.14
 * Time: 18:29
 */

class VkController extends Controller {

    const APP_ID = 4484087;
    const SECRET = 'Q8sHnIlcnvF13GK2ptEx';
    const V_API  = '5.23';


    public function index()
    {
        if (Input::has('code'))
        {
            $redirect_url = URL::route('vkindex');
            $code = Input::get('code');
            $url = 'https://oauth.vk.com/access_token';
            $urlData = [
                'client_id' => self::APP_ID,
                'client_secret' => self::SECRET,
                'code' => $code,
                'redirect_uri' => urlencode($redirect_url),
            ];

            $response = Curl::post($url, $urlData);
            $response = $response->getContent();
            $response = json_decode($response);
            if (isset($response['access_token']))
            {
                Session::put('access_token', $response['access_token']);
                Session::put('user_id', $response['user_id']);
                return Redirect::route('vkindex');
            }
            else
                return 'Couldn\'t authenticate';

        }

        if (!Session::has('access_token'))
        {
            $redirect_url = URL::route('vkindex');
            $url = 'https://oauth.vk.com/authorize';
            $urlData = [
                'client_id' => self::APP_ID,
                'scope' => implode(',', ['audio', 'email']),
                'redirect_uri' => urlencode($redirect_url),
                'response_type' => 'code',
                'v' => self::V_API,
            ];

            return Redirect::to(
                $this->generateGetRequest($url, $urlData)
            );
        }
        else
        {
            $url = 'https://api.vk.com/method/audio.get';
            $urlData = [
                'owner_id' => Session::get('user_id'),
                'need_user' => 1,
                'count' => 20,
                'access_token' => Session::get('access_token')
            ];

            $response = Curl::post($url, $urlData);
            return $response->getContent();
        }
    }

    public function generateGetRequest($url, $params)
    {
        $paramsList = array();
        foreach($params as $key => $value)
            $paramsList[] = "$key=$value";
        return $url.'?'.implode('&', $paramsList);
    }
}