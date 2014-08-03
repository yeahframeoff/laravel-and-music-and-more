<?php

namespace VkAuth;

use \Input;
use \Session;
use \URL;
use Jyggen\Curl\Curl;
use Karma\Entities\Credential;
use Karma\Entities\Social;
use Karma\Entities\User;

class VkAuth implements AuthInterface
{
    const APP_ID = '4484087';
    const SECRET = 'Q8sHnIlcnvF13GK2ptEx';
    const V_API  = '5.23';
    
    const HTTP_API = 'https://api.vk.com/method/';
    
    const KEY_CODE   = 'vk_code';
    const KEY_TOKEN  = 'vk_access_token';
    const KEY_USERID = 'user_id';
    const KEY_EXT_USERID = 'external_user_id';
    
    //private $userRepository;
    
    //public function __construct(UserRepository $repository)
    //{
    //    $this->userRepository = $repository;
    //}
    
    public function getCode()
    {
        if (Input::has('code'))
        {
            $code = Input::get('code');
            Session::put(self::KEY_CODE, $code);
        }
            
//         elseif (Session::has(self::KEY_CODE))
//             $code = Session::get(self::KEY_CODE);
//         elseif (Session::has(self::KEY_EXT_USERID))
//         {
//             $uid = Session::has(self::KEY_EXT_USERID);
//             $cr = Credential::first([
//                 'external_id' => $uid,
//                 'social_id'   => $this->getVkSocialId(),
//             ]);
//             if ($cr === null)
//                 $code = null;
//             else
//                 $code = $user->credentials()->token;
//         }
        
        // TODO: make decisions about cookies
        else
            $code = null;
            
        return $code;
    }
    
    public function accessTokenRequest($code)
    {
        $redirect_url = URL::route('vkIndex');
        $url = 'https://oauth.vk.com/access_token';
        $urlData = [
            'client_id'     => self::APP_ID,
            'client_secret' => self::SECRET,
            'code'          => $code,
            'redirect_uri'  => $redirect_url,
        ];

        $response = Curl::post($url, $urlData)[0];
        $response = $response->getContent();
        return json_decode($response, true);
    }
    
    public function isAuth()
    {
        return Session::has(self::KEY_USERID) && Session::has(self::KEY_TOKEN);
    }
    
    public function hasCode()
    {
        return Input::has('code')/* && Input::has(self::KEY_EXT_USERID)*/;
    }
    
    public function logIn($response)
    {
        $token   = $response['access_token'];
        $user_id = $response['user_id'];
        Session::put(self::KEY_TOKEN, $token);
        Session::put(self::KEY_EXT_USERID, $user_id);
        $cr = Credential::firstOrNew([
            'external_id' => $user_id,
            'social_id'   => $this->getVkSocialId(),
        ]);
        if (!isset($cr->user_id))
        {
            $user = User::create([]);
            $cr->user_id = $user->id;
        }
            
        $cr->token = Session::get(self::KEY_CODE);
        $cr->push();
        Session::put(self::KEY_USERID, $cr->user_id);
    }
    
    private function getVkSocialId()
    {
        $social = Social::firstOrCreate(['name' => 'vk']);
        return $social->id;
    }
    
    public function resolveError($error)
    {
        return 'Error occured: '.json_encode($error);
    }
    
    public function getAuthorizationUrl()
    {
        $redirect_url = URL::route('vkIndex');
        $url = 'https://oauth.vk.com/authorize';
        $urlData = [
            'client_id'     => self::APP_ID,
            'scope'         => implode(',', ['audio']),
            'redirect_uri'  => urlencode($redirect_url),
            'response_type' => 'code',
            'v'             => self::V_API,
        ];

        return $this->generateGetRequest($url, $urlData);
    }
    
    public function logOut()
    {
        Session::forget(self::KEY_CODE);
        Session::forget(self::KEY_TOKEN);
        Session::forget(self::KEY_USERID);
        Session::forget(self::KEY_EXT_USERID);
    }

    public function doo($method, array $params, $json = true)
    {
        $url = $this->method($method);
        $params = array_add($params, 'v', SELF::V_API);
        $response = Curl::post($url, $params)[0];
        $response = $response->getContent();
        if ($json) $response = json_decode($response, true);
        return $response;
    }
    
    public function getUserId()
    {
        return Session::get(self::KEY_EXT_USERID);
    }
    
    public function getToken()
    {
        return Session::get(self::KEY_TOKEN);
    }
    
    private function generateGetRequest($url, $params)
    {
        $paramsList = array();
        foreach($params as $key => $value)
            $paramsList[] = "$key=$value";
        return $url.'?'.implode('&', $paramsList);
    }
    
    private function method($method)
    {
        return self::HTTP_API.$method;
    }
}

