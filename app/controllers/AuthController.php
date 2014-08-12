<?php

namespace Karma\Controllers;

use \Karma\Auth;
use \Karma\API;
use \Karma\Entities\Credential;
use \View;
use \App;
use \Redirect;
use \Session;

class AuthController extends BaseController
{
    protected $providers;
    protected $links;
	protected $links_connect;
    
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
        
        $this->links_connect = array(
            'ok' => \Karma\Auth\OdnoklassnikiOAuth::getAuthLink(true),
            'vk' => \Karma\Auth\VkontakteOAuth::getAuthLink(true),
            'fb' => \Karma\Auth\FacebookOAuth::getAuthLink(true)
        );
    }
    
    public static function logged()
    {
        return !is_null(\Karma\Auth\OAuth::getUserId());
    }
    
    public function login($provider)
    {
        if(!isset($this->providers[$provider]))
        {
            return App::abort(404);
        }
        
        return Redirect::to($this->links[$provider]);
    }
    
    public function connect($provider)
    {
        if(!isset($this->providers[$provider]))
        {
            return App::abort(404);
        }
        
        if(Session::get('auth') == $provider)
        {
            return Redirect::route('home')->with('warnings', array('Этот аккаунт уже подключен!'));
        }
        
        return Redirect::to($this->links_connect[$provider]);
    }
    
    public function callback($provider, $connect = false)
    {
        $with = array();
        
        if(!isset($this->providers[$provider]))
        {
            return App::abort(404);
        }
        
        if($connect)
        {
            
            $with = array('info' => array('Аккаунт успешно подключен.'));
        }
        else
        {
            \App::bind('Karma\API\InterfaceAPI', 'Karma\API\\' . $this->providers[$provider] . 'API');
        }
        
        $OAuth = App::make('Karma\Auth\\' . $this->providers[$provider] . 'OAuth');
        $OAuth->auth($connect);
        
        if(!$connect)
        {	                 
            Session::put('auth', $provider);
        }
        
        return Redirect::route('import')->with($with);
    }
    
    public function callbackConnect($provider)
    {
        return $this->callback($provider, true);
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
        $user = \Karma\Entities\User::find(Session::get('user_id'));
        $user->first_name = $profile['first_name'];
        $user->last_name = $profile['last_name'];
        $user->photo = $profile['photo'];
        $user->save();
        return View::make('auth.profile')->with('user', $user);
    }
}