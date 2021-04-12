<?php
namespace App\Classes\Auth\SaveLinkResetPassword;

use App\Classes\Helper\Hash;
use App\Models\UserAdmin;
use App\Models\UserAdminPasswordReset;
use Illuminate\Http\Request;



class SavePasswordReset{

    protected $request;
    protected $user;


    public function __construct(Request $request , UserAdmin $user)
    {
        $this->request                 = $request;
        $this->user                    = $user;
    }


    public function request(){
        return  $this->request;
    }

    public function user(){
        return  $this->user;
    }


    public function publish(){

        // GET THE USER PASSWORD RESET
        $action = $this->user->PasswordReset == null ? "create"
                                                     : "update";

        // SAVE
        if($this->save($action)){

            return UserAdminPasswordReset::where('user_id' , $this->user->id)->first();
        }

    }


    protected function save($action){


        $this->user->PasswordReset()->{$action}([ 'token'                =>  Hash::token($this->user->id) ,
                                                  'user_ip'              =>  ip2long($_SERVER['REMOTE_ADDR']) ]);

        return true;
    }


}
