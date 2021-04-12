<?php


namespace App\Classes\Auth;
use App\Classes\Auth\VerifyTokenValid;

use App\Models\UserAdminPasswordReset;

class RecoverPasswordLink
{
    protected $userPassowrdReset;
    protected $result;

    public static function process($token){
        return   (new static)->handle($token);
    }

    private function handle($token){
        return   $this->setUserPassowrdReset($token)
                      ->result();
    }

    private function setUserPassowrdReset($token){
        $this->userPassowrdReset = UserAdminPasswordReset::where('token', $token)->first();
        return $this;
    }

    private function result(){
        if($this->userPassowrdReset){
            return view('/auth/recover_password' ,[ 'userPassowrdReset'     => $this->userPassowrdReset ,
                                                         'token_valid'           => VerifyTokenValid::process($this->userPassowrdReset->created_at , "24 hours") ? true : false ,
                                                         'pg'                    => 'recover-pass' ,
                                                         'username'              =>  $this->userPassowrdReset->User->UserInfo('name') ]);
        }
    }



}
