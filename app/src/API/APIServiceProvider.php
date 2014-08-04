<?php

namespace Karma\API;

use \Illuminate\Support\ServiceProvider;

class APIServiceProvider extends ServiceProvider {

    public function register()
    {
        switch(\Session::get('auth'))
        {
            case 'VK':
                \App::bind('Karma\API\InterfaceAPI', 'Karma\API\VkontakteAPI');
                break;
            case 'OK':
                \App::bind('Karma\API\InterfaceAPI', 'Karma\API\OdnoklassnikiAPI');
                break;
            case 'FB':
                \App::bind('Karma\API\InterfaceAPI', 'Karma\API\FacebookAPI');
                break;
        }
    }

}

?>