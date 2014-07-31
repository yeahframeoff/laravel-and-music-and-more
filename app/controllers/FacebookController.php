<?php

session_start();
class FacebookController extends BaseController
{
    public $name;
    public function index()
    {
        $this->name = 'Roman';
        $id = '1446675095605125';
        $secret = '3d70f6d6e1f6f6f7e813b96cf4b28210';
        \Facebook\FacebookSession::setDefaultApplication($id, $secret);
        $helper = new Facebook\FacebookRedirectLoginHelper('http://localhost/my_projects/bitly/bitly_laravel/public/fb');
        try {
            $session = $helper->getSessionFromRedirect();
        } catch(Exception $e) {
            echo $e->getMessage();
        }
        if(isset($_SESSION['token'])) {
            $session = new \Facebook\FacebookSession($_SESSION['token']);
            try {
                $session->validate($id, $secret);
            } catch (\Facebook\FacebookAuthorizationException $ex) {
//                $session = '';
                session_destroy();
            }
        }
        if(isset($session)) {
            $_SESSION['token'] = $session->getToken();
            echo "Login successful<br>";
            try {
                $request = new Facebook\FacebookRequest($session, 'GET', '/me');
                $response = $request->execute();
                $graph = $response->getGraphObject(Facebook\GraphUser::className());
                $graph_location = $response->getGraphObject(Facebook\GraphLocation::className());
                echo "Hi " . $graph->getName();
                echo "<br>";
                echo "Id " . $graph->getId(); 
                echo "<br>";
                echo "Link " . $graph->getLink(); 
//                echo "<br>Hi " . $graph->getLocation(); 
//                echo "Hi " . $graph->get; 
//                print_r($_SESSION);
            } catch(\Facebook\FacebookRequestException $e) {
                echo "Exception occured, code: " . $e->getCode();
                echo " with message: " . $e->getMessage();
            }
        } else {
            echo "<a href='".$helper->getLoginUrl()."'>Login with Facebook</a>";
        }
    }
    public function success()
    {
        
    }
    
}

