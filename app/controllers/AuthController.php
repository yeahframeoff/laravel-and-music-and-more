<?php

class AuthController extends BaseController
{

    public function index()
    {
        //dd(OdnoklassnikiAuth::getUserId());
        if(OdnoklassnikiAuth::getUserId() == false){
            return View::make('OK.main')
                ->with('full_link', OdnoklassnikiAuth::getAuthLink());
        }
        else{
            return View::make('OK.logout');
        }
    }

    public function success()
    {
        OdnoklassnikiAuth::success();
    }

    public function logout()
    {
        OdnoklassnikiAuth::logout();
    }
    
    public function info()
    {
        echo phpinfo();
    }
    
}
?>
