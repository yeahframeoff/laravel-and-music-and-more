<?php

namespace Karma\API;

use \Jyggen\Curl\Curl;

abstract class API 
{
    protected $apiLink;
    protected $accessToken;
    protected $applicationKey;
    protected $privateKey;
    
    public static function getAPI($social){
        switch($social)
        {
            case 'fb':
                $API = \App::make('\Karma\API\FacebookAPI');
                break;
            case 'vk':
                $API = \App::make('\Karma\API\VkontakteAPI');
                break;
            case 'ok':
                $API = \App::make('\Karma\API\OdnoklassnikiAPI');
                break;
        }
        
        return $API;
    }
    
    protected function APImethod($params, $addToUrl = '')
    {
        $url = $this->apiLink . $addToUrl;
        $response = Curl::post($url, $params)[0];
        $response = $response->getContent();
        $response = json_decode($response, true);
        
        return $this->checkError($response);
    }
        
    protected function APImethodGet($params, $addToUrl = '')
    {
        $url = $this->apiLink . $addToUrl;
        
        if (!empty($params))
        {
            foreach($params as $key => $value)
                $paramsList[] = "$key=$value";
            $url = $url . '?' . implode('&', $paramsList);
        }
        
        $response = Curl::get($url, $params)[0];
        $response = $response->getContent();
        $response = json_decode($response, true);
        
        return $this->checkError($response);
    }
    
    private function checkError($response)
    {
        if(isset($response['error']) || isset($response['error_msg']))
            dd($response);
        else
            return $response;
    }
        
    protected abstract function getToken();   
}