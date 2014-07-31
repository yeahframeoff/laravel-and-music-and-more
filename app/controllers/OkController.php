<?php

use Jyggen\Curl\Curl;

class OkController extends BaseController
{

    public function index()
    {
        //dd(OdnoklassnikiAuth::getAuthLink());
        return View::make('OK.main')
            ->with('full_link', OdnoklassnikiAuth::getAuthLink());
    }

}
?>
