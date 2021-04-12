<?php


namespace App\Classes\Auth;


use App\Models\UserAdmin;
use Auth;

class VerifyAuthRequest
{
    public static function verifyAdmin(){
        if(! auth('user_admin')->user()){
            return false;
        }

        return UserAdmin::where([
                               'id'          => auth('user_admin')->user()->id
                           ])->exists();
    }
}
