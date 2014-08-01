<?php

namespace VkAuth;

interface AuthInterface
{    
    public function getCode();
    
    public function isAuth();
    
    public function logIn($response);
    
    public function logOut();
    
    public function accessTokenRequest($code);
    
    public function getAuthorizationUrl();
    
    public function doo($method, array $params, $json = true);
    
    public function getUserId();
    
    public function getToken();
}