<?php
namespace App\Classes\Auth;

use GuzzleHttp\Client as Guzzle;



class VerifyUserPassword {



    public static function process($request , $type_access){
        return   (new static)->handle($request , $type_access );
    }

    private function handle($request , $type_access){
        return   $this->setToken($request , $type_access);
    }


    private  function  setToken($request , $type_access){


        $http = new Guzzle;
        try {
            $response = $http->post(config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $request->email ,
                    'password' => $request->password ,
                    'provider' => $type_access ,
                    'scope'    => '*'
                ]
            ]);

            return   $response->getBody();

        } catch (\GuzzleHttp\Exception\BadResponseException $e) {

            return response()->json(['errors' => [ 'password' => ['E-mail ou Senha Incorreta'] ]], 401);
        }

    }

}
