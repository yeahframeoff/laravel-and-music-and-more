<?php

namespace Karma\API;

use \Jyggen\Curl\Curl;

abstract class API 
{
    const FB = 1;
    const VK = 2;
    const OK = 3;
    
    protected $apiLink;
    protected $accessToken;
    protected $applicationKey;
    protected $privateKey;
    
    public static function getAPI($socialId){
        switch($socialId){
            case self::FB:
                $API = \App::make('\Karma\API\FacebookAPI');
                break;
            case self::VK:
                $API = \App::make('\Karma\API\VkontakteAPI');
                break;
            case self::OK:
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
        if (!empty($params)){
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
?>