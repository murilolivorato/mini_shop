<?php


namespace App\Classes\Auth;
use App\Classes\Auth\VerifyTokenValid;
use App\Models\UserAdminPasswordReset;




class LoadFormPasswordReset
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
        if(! $this->userPassowrdReset){
            return response()->json(401);
        }

        return response()->json([ 'token_valid'           => VerifyTokenValid::process($this->userPassowrdReset->created_at , "24 hours") ? true : false ,
                                  'user_info'             =>  ['name' =>$this->userPassowrdReset->User->UserInfo('name') ] ]);
    }
}
