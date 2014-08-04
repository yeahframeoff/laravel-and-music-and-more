<?php

namespace Karma\Auth;

use \Jyggen\Curl\Curl;
use \Karma\API;

abstract class OAuth implements OAuthInterface{

    protected $dataArray;
    protected $interfaceAPI;

    private $error_msg;

    public function auth()
    {
        $result = false;
        if (\Input::has('code')) {
            $code = \Input::get('code');

            $redirectUrl = \URL::route($this->dataArray['redirect']);
            $url = $this->dataArray['APIUrl'];
            $requestData = array(
                'code' => $code,
                'client_id' => $this->dataArray['client_id'],
                'client_secret' => $this->dataArray['client_secret'],
                'redirect_uri' => $redirectUrl
            );
            if (isset($this->dataArray['grant_type']))
                $requestData['grant_type'] = $this->dataArray['grant_type'];

            $response = Curl::post($url, $requestData)[0];
            $response = $response->getContent();
            $responseTmp = json_decode($response, true);
            if ($responseTmp == NULL){
                parse_str($response, $responseTmp);
            }
            $response = $responseTmp;
            
            if(isset($response['access_token'])){
                \Session::put('accessToken', $response['access_token']);
                
                
                if (isset($this->dataArray['key_user_id']))
                    $uid = $response[$this->dataArray['key_user_id']];
                else
                    $uid = $this->interfaceAPI->getUserId();
                
                $credential = \Karma\Entities\Credential::firstOrNew(array(
                    'social_id' => $this->dataArray['social_id'],
                    'external_id' => $uid,
                ));
                if(!isset($credential->id)){
                    if(\Session::has('user_id'))
                        $user = \Karma\Entities\User::find(\Session::get('user_id'));
                    else
                        $user = new \Karma\Entities\User;
                    $user->save();
                    $credential->user_id = $user->id;
                }
                $credential->token = $response[$this->dataArray['token_key']];
                $credential->save();
                \Session::put('user_id', $credential->user_id);
            }

        }
        return $result;
    }

    public static function getUserId()
    {
        return \Session::get('user_id');
    }

    public static function logout()
    {
        \Session::forget('user_id');
        \Session::forget('accessToken');
        \Session::forget('auth');
    }

    public function getLastError()
    {

    }

}

?>