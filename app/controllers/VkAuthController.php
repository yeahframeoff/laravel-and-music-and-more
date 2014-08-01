<?php

use Jyggen\Curl\Curl;

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
        $code = $this->auth->getCode();
        $response = $this->auth->accessTokenRequest($code);
        if (!isset($response['error']))
        {
            $this->auth->logIn();
            return Redirect::route('vkindex');
        }
        else
            return $this->auth->resolveError($response['error']);
    }
    
    public function index()
    {
        if (!$this->auth->isAuth())
        {
            $url = $this->auth->getAuthorizeUrl();
            return View::make('vk.auth')->where('vk_url', $url);
        }
        else
        {
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
            {
                Session::forget('access_token');
                Session::forget('user_id');
                return Redirect::route('vkindex');
            }
            
            return $result;
        }
    }
    
    private function api($method, array $params, $json = true)
    {
        return $this->auth->doo($method, $params, $json);
    }
        

}
