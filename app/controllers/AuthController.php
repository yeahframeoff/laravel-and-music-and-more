<?php

namespace Karma\Controllers;

use \Karma\Auth;
use \Karma\API;
use \Karma\Entities\Credential;
use \View;
use \App;
use \Redirect;

class AuthController extends BaseController
{
    // $API = App::make('Karma\API\InterfaceAPI');, $API->getUserInfo()
    protected $providers;
    protected $links;
    
    public function __construct()
    {
        $this->providers['ok'] = 'Odnoklassniki';
        $this->providers['vk'] = 'Vkontakte';
        $this->providers['fb'] = 'Facebook';
        
        $this->links = array(
            'ok' => \Karma\Auth\OdnoklassnikiOAuth::getAuthLink(),
            'vk' => \Karma\Auth\VkontakteOAuth::getAuthLink(),
            'fb' => \Karma\Auth\FacebookOAuth::getAuthLink()
        );
    }
    
    public static function logged()
    {
        return \Karma\Auth\OAuth::getUserId() != false;
    }
    
    public function login($provider)
    {
        if(!isset($this->providers[$provider]))
        {
            return App::abort(404);
        }
        
        return Redirect::to($this->links[$provider]);
    }
    
    public function callback($provider)
    {
        if(!isset($this->providers[$provider]))
        {
            return App::abort(404);
        }
        
        \App::bind('Karma\API\InterfaceAPI', 'Karma\API\\' . $this->providers[$provider] . 'API');
        
        $OAuth = App::make('Karma\Auth\\' . $this->providers[$provider] . 'OAuth');
        $OAuth->auth();
        
        \Session::put('auth', $provider);
        
        return Redirect::route('import');
    }
    
    public function logout()
    {
        \Karma\Auth\OAuth::logout();
        return Redirect::route('home');
    }
    
    public function loadProfile($social)
    {
        $API = \Karma\API\API::getAPI($social);
        $profile = $API->getUserInfo();
        $user = \Karma\Entities\User::find(\Session::get('user_id'));
        $user->first_name = $profile['first_name'];
        $user->last_name = $profile['last_name'];
        $user->photo = $profile['photo'];
        $user->save();
        return View::make('auth.profile')->with('user', $user);
    }
}