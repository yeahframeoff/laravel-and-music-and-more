<?php

interface AuthInterface {
    public static function auth();
    public static function getAuthLink();
    public static function success();
    public static function logout();
    public static function getUserId();
}
?>