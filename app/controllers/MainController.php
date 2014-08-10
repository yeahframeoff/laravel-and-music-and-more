<?php

namespace Karma\Controllers;

use \View;

class MainController extends BaseController
{
    public function index()
    {
        $links = array(
            'OK' => \Karma\Auth\OdnoklassnikiOAuth::getAuthLink(),
            'VK' => \Karma\Auth\VkontakteOAuth::getAuthLink(),
            'FB' => \Karma\Auth\FacebookOAuth::getAuthLink()
        );
        return View::make('index')
            ->with('links', $links);
    }
}

?>