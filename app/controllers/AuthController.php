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

    public function index()
    {
        \App::register('Karma\API\APIServiceProvider');

        if(\Karma\Auth\OAuth::getUserId() == false){
            return View::make('auth.main')
                ->with('full_link', \Karma\Auth\OdnoklassnikiOAuth::getAuthLink())
                ->with('full_VK', \Karma\Auth\VkontakteOAuth::getAuthLink())
                ->with('full_FB', \Karma\Auth\FacebookOAuth::getAuthLink());
        }
        else{

            /*
             * TODO: REFACTORING
             */

            $links = array(
                'OK' => \Karma\Auth\OdnoklassnikiOAuth::getAuthLink(),
                'VK' => \Karma\Auth\VkontakteOAuth::getAuthLink(),
                'FB' => \Karma\Auth\FacebookOAuth::getAuthLink()
            );

            $socials = array(
                '1' => 'FB',
                '2' => 'VK',
                '3' => 'OK'
            );

            /*
             * TODO: add this part to model/repo
             */

            $credentials = \Karma\Entities\Credential::where('user_id', '=', \Session::get('user_id'))->get();
            foreach($credentials as $credential){
                $socTmp = $socials[$credential->social_id];
                $socials[$credential->social_id] = array(true, $socTmp);
            }

            $API = App::make('Karma\API\InterfaceAPI');
            return View::make('auth.view')
                ->with('userInfo', $API->getUserInfo())
                ->with('socials', $socials)
                ->with('links', $links);
        }
    }

    public function successOK()
    {
        \App::bind('Karma\API\InterfaceAPI', 'Karma\API\OdnoklassnikiAPI');

        $OAuth = App::make('\Karma\Auth\OdnoklassnikiOAuth');
        $OAuth->auth();
        \Session::put('auth', 'OK');

        return Redirect::route('authIndex');
    }

    public function successVK()
    {

        \App::bind('Karma\API\InterfaceAPI', 'Karma\API\VkontakteAPI');

        $OAuth = App::make('\Karma\Auth\VkontakteOAuth');
        $OAuth->auth();
        \Session::put('auth', 'VK');

        return Redirect::route('authIndex');
    }

    public function successFB()
    {
        \App::bind('Karma\API\InterfaceAPI', 'Karma\API\FacebookAPI');

        $OAuth = App::make('Karma\Auth\FacebookOAuth');
        $OAuth->auth();
        \Session::put('auth', 'FB');

        return Redirect::route('authIndex');
    }

    public function loadProfile($socialId)
    {

        $API = \Karma\API\API::getAPI($socialId);
        $profile = $API->getUserInfo();
        $user = \Karma\Entities\User::find(\Session::get('user_id'));
        $user->first_name = $profile['first_name'];
        $user->last_name = $profile['last_name'];
        $user->photo = $profile['photo'];
        $user->save();
        return View::make('auth.profile')->with('user', $user);
    }

    public function logout()
    {
        \Karma\Auth\OAuth::logout();
        return Redirect::route('authIndex');
    }


}
?>
