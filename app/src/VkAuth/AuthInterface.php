<?php

interface AuthInterface
{    
    public function getCode();
    
    public function isAuth();
    
    public function accessTokenRequest($code);
    
    public function getAuthorizationUrl();
    
    public function doo($method, array $params, $json = true);
    
    public function getUserId();
    
    public function getToken();
}