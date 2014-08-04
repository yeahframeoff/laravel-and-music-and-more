<?php

namespace Karma\API;

use \Jyggen\Curl\Curl;

abstract class API 
{
    
    protected $apiLink;
    protected $accessToken;
    protected $applicationKey;
    protected $privateKey;
    
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
        if(isset($response['error']))
            dd($response);
        else
            return $response;
    }
        
    protected abstract function getToken();
    
}
?>