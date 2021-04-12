<?php
namespace App\Classes\Auth\SaveLinkResetPassword;



use App\Classes\Helper\SetCharacter;

// MAIL
use Mail;

use App\Mail\SendResetUserPassword;


class SendEmail
{
    protected $passwordReset;
    protected $request;
    protected $user;

    public function __construct($passwordReset){
        $this->passwordReset         = $passwordReset->publish();
        $this->request               = $passwordReset->request();
        $this->user                  = $passwordReset->user();

    }


    public function publish()
    {

        // SED E-MAIL
        Mail::to(SetCharacter::makeLowercase($this->request['email']))->send(new SendResetUserPassword($this->passwordReset, $this->user));

        if (Mail::failures()) {
            return false;
        }else{
            return true;
        }



    }





}




