<?php
namespace App\Classes\Auth;

use App\Models\UserPub;
use App\Models\UserPasswordReset;

use App\Classes\Auth\RecoverPassword\SaveNewPassword;
use App\Classes\Auth\RecoverPassword\DeletePassWordReset;


use App\Models\UserPubPasswordReset;
use Illuminate\Http\Request;

//use App\Classes\Customer\MakePropertyDescription;

class ProcessRecoverPassword
{

    protected $request;
    protected $userPassowrdReset;
    protected $result;


    public static function process($request){

        return   (new static)->handle($request);
    }

    private function handle($request){
        return   $this->setRequest($request)
                      ->setUserPasswordRequest()
                      ->save()
                      ->result();
    }


    private function setRequest($request){
        $this->request = $request;
        return $this;
    }


    public function setUserPasswordRequest(){
        $this->userPassowrdReset = UserPubPasswordReset::where('token', $this->request['token'] )->first();
        return $this;
    }


    private function save()
    {

        // SAVE IMAGE INTO GALLERY
        $result =   new DeletePassWordReset(
                            new SaveNewPassword(
                                        $this->request ,
                                        $this->userPassowrdReset
                            )

        );


        // PUBLISH PROP
        $this->result = $result->publish();
        return $this;

    }


    public function result(){

        if(! $this->result ){
            return response()->json(['sucess'  =>  false ] ,  400);
        }

        // success
        return response()->json(['success'  =>  true ] , 200);

    }


}
