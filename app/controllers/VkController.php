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

    const HTTP_API = 'https://api.vk.com/method/';
    
    private function method($method)
    {
        return self::HTTP_API.$method;
    }

    public function index()
    {
        if (Input::has('code') && !Session::has('access_token'))
        {
            $redirect_url = URL::route('vkindex');
            $code = Input::get('code');
            $url = 'https://oauth.vk.com/access_token';
            $urlData = [
                'client_id' => self::APP_ID,
                'client_secret' => self::SECRET,
                'code' => $code,
                'redirect_uri' => $redirect_url,
            ];

            $response = Curl::post($url, $urlData)[0];
            $response = $response->getContent();
            $response = json_decode($response, true);
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
                'client_id'     => self::APP_ID,
                'scope'         => implode(',', ['audio', 'email']),
                'redirect_uri'  => urlencode($redirect_url),
                'response_type' => 'code',
                'v'             => self::V_API,
            ];

            return Redirect::to(
                $this->generateGetRequest($url, $urlData)
            );
        }
        else
        {
            $result = $this->doo('audio.get', [
                'owner_id'     => Session::get('user_id'),
                'need_user'    => 1,
                'count'        => 6000,
                'access_token' => Session::get('access_token'),
                'lang'         => 'ua'
            ]);
            
            if (isset($result['error']))
            {
                Session::forget('access_token');
                Session::forget('user_id');
                return Redirect::route('vkindex');
            }
            
            return $result;
        }
    }
    
    public function editSound($song_id, $new_artist)
    {
        $result = $this->doo('audio.edit', [
            'owner_id'     => Session::get('user_id'),
            'audio_id'     => $song_id,
            'artist'       => $new_artist,
            'access_token' => Session::get('access_token'),
            'lang'         => 'ua'
        ]);

        if (isset($result['error']))
            return $result;
        return Redirect::to('https://vk.com/audios'.Session::get('user_id'));
    }
    
    private function doo($method, array $params, $json = true)
    {
        $url = $this->method($method);
        $response = Curl::post($url, $params)[0];
        $response = $response->getContent();
        if ($json) $response = json_decode($response, true);
        return $response;
    }

    public function generateGetRequest($url, $params)
    {
        $paramsList = array();
        foreach($params as $key => $value)
            $paramsList[] = "$key=$value";
        return $url.'?'.implode('&', $paramsList);
    }

}
