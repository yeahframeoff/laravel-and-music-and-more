<?php

use VkAuth\AuthInterface;

/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 30.07.14
 * Time: 18:29
 */

class VkAuthController extends Controller
{
    private $auth;
    
    public function __construct (AuthInterface $auth)
    {
        $this->auth = $auth;
    }
    
    public function getToken()
    {
        
    }
    
    public function index()
    {
        if($this->auth->hasCode())
        {
            $code = $this->auth->getCode();
            $response = $this->auth->accessTokenRequest($code);
            if (isset($response['error']))
                return $this->auth->resolveError($response/*['error']*/);

            $this->auth->logIn($response);
            return Redirect::route('vkIndex');
        }
        
        if (!$this->auth->isAuth())
        {
            $url = $this->auth->getAuthorizationUrl();
            return View::make('vk.auth')->with('vk_url', $url);
        }        
        
        $token = $this->auth->getToken();
        if ($token === null)
            return Redirect::route('vkGetToken');

        $user_id = $this->auth->getUserId();
        $response = $this->api( 'users.get', [
            'user_ids' => $user_id,
            'fields'   => implode(',', [
                'city',
                'country',
                'photo_400_orig',
                'timezone',
                'occupation'
            ]),
            'access_token' => $token,
            'lang'         => 'en',
        ]);

        if (isset($result['error']))
            return $this->auth->resolveError($response['error']);
        
        return View::make('vk.view')->with('user_data', $result[0]);
    }
    
    public function logOut()
    {
        $this->auth->logOut();
        return Redirect::route('vkIndex');
    }
    
    private function api($method, array $params, $json = true)
    {
        return $this->auth->doo($method, $params, $json);
    }
        

}
