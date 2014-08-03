<?php
use \Karma\Auth;
use \Karma\API;
use \Karma\Entities\Credential;

class AuthController extends BaseController
{

    public function index()
    {
        if(\Karma\Auth\OAuth::getUserId() == false){
            return View::make('OK.main')
                ->with('full_link', \Karma\Auth\OdnoklassnikiOAuth::getAuthLink())
                ->with('full_VK', \Karma\Auth\VkontakteOAuth::getAuthLink())
                ->with('full_FB', \Karma\Auth\FacebookOAuth::getAuthLink());
        }
        else{
            return View::make('OK.logout');
        }
    }

    public function successOK()
    {       
        App::bind('Karma\API\InterfaceAPI', 'Karma\API\OdnoklassnikiAPI');

        $OAuth = App::make('\Karma\Auth\OdnoklassnikiOAuth');
        $OAuth->auth();
        
        return Redirect::route('authIndex');
    }

    public function successVK()
    {

        App::bind('Karma\API\InterfaceAPI', 'Karma\API\VkontakteAPI');

        $OAuth = App::make('\Karma\Auth\VkontakteOAuth');
        $OAuth->auth();
        return Redirect::route('authIndex');
    }
    
    public function logout()
    {
        \Karma\Auth\OAuth::logout();
        return Redirect::route('authIndex');
    }

    public function info()
    {
        echo phpinfo();
    }

}
?>
