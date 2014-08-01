<?php

/*
 * To change this template use Tools | Templates.
 */

/**
 * Description of newPHPClass
 *
 * @author yeahframeoff
 */
class VkAuth implements AuthInterface
{
    const APP_ID = '4484087';
    const SECRET = 'Q8sHnIlcnvF13GK2ptEx';
    const V_API  = '5.23';
    
    const HTTP_API = 'https://api.vk.com/method/';
    
    const KEY_CODE   = 'vk_code';
    const KEY_TOKEN  = 'vk_access_token';
    const KEY_USERID = 'user_id';
    
    private $userRepository;
    
    public function __construct(UserRepository $repository)
    {
        $this->userRepository = $repository;
    }
    
    public function getCode()
    {
        if (Input::has('code'))
        {
            $code = Input::get('code');
            Session::put(self::KEY_CODE, $code);
        }
            
        elseif (Session::has(self::KEY_CODE))
            $code = Session::get(self::KEY_CODE);
        elseif (Session::has('user_id'))
        {
            $uid = Session::has('user_id');
            $user = $this->userRepository->find($uid);
            $code = $user->credentials()->token;
        }
        
        // TODO: make decisions about cookies
        else
            $code = null;
            
        returnn $code;
    }
    
    public function accessTokenRequest($code)
    {
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
        
    }
    
    public function logIn()
    {
//         Session::put('access_token', $response['access_token']);
//             Session::put('vk_user_id', $response['user_id']);
    }
    
    public function getAuthorizationUrl()
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

        return $this->generateGetRequest($url, $urlData);
    }

    public function doo($method, array $params, $json = true)
    {
        $url = $this->method($method);
        $response = Curl::post($url, $params)[0];
        $response = $response->getContent();
        if ($json) $response = json_decode($response, true);
        return $response;
    }
    
    public function getUserId()
    {
        
    }
    
    public function getToken()
    {
        
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

