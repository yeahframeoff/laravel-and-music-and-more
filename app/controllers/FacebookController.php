<?php

session_start();

use \Facebook\FacebookSession;
use \Facebook\FacebookRedirectLoginHelper;
use \Facebook\FacebookRequest;
use \Facebook\GraphUser;
use \Facebook\GraphLocation;

use \Facebook\FacebookAuthorizationException;
use \Facebook\FacebookRequestException


class FacebookController extends BaseController
{
    public $name;
    
    const APP_ID = '1446675095605125';
    const SECRET = 'e98bafaf60c6c78104df3de28339acdb';
    
    public function index()
    {
        FacebookSession::setDefaultApplication(self::APP_ID, self::SECRET);
        $helper = new FacebookRedirectLoginHelper(URL::to('fb'));
        $mainResponse = '';
        
        try
        {
            $session = $helper->getSessionFromRedirect();
        }
        catch(Exception $e)
        {
            $mainResponse .= $e->getMessage();
        }
        
        if (Session::has('token'))
        {
            $session = new FacebookSession(Session::get('token'));
            try
            {
                $session->validate(self::APP_ID, self::SECRET);
            }
            catch (FacebookAuthorizationException $ex)
            {
                Session::remove('token');
            }
        }
        
        if(isset($session)) {
            Session::put('token', $session->getToken());
            $mainResponse .= "Login successful<br>";
            try
            {
                $request = new FacebookRequest($session, 'GET', '/me');
                $response = $request->execute();
                $graph = $response->getGraphObject(GraphUser::className());
                $graph_location = $response->getGraphObject(GraphLocation::className())
                $mainResponse .= sprintf (
                    "Hi %s<br>" .
                    "Id %s<br>" .
                    "Link %s",
                    $graph->getName(), $graph->getId(), $graph->getLink()); 
//                echo "<br>Hi " . $graph->getLocation(); 
//                echo "Hi " . $graph->get; 
//                print_r($_SESSION);
            }
            catch(FacebookRequestException $e)
            {
                $mainResponse .= "Exception occured, code: " . $e->getCode();
                $mainResponse .= " with message: " . $e->getMessage();
            }
        }
        
        else
            $mainResponse .= "<a href='".$helper->getLoginUrl()."'>Login with Facebook</a>";
        
        return $mainResponse;
    }
    
}

