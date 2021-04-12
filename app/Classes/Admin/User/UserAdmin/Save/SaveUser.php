<?php


namespace App\Classes\Admin\User\UserAdmin\Save;

use App\Classes\Helper\SetCharacter;
use App\Models\UserAdmin;
use Illuminate\Http\Request;

class SaveUser
{
    public function __construct(UserAdmin $userAdmin, Request $request, UserAdmin $user )
    {
        $this->userAdmin   = $userAdmin;
        $this->request     = $request;
        $this->user        = $user;
        $this->action      = ! $this->userAdmin->exists  ? "create" : "update";
    }

    public function request(){
        return  $this->request;
    }

    public function user(){
        return  $this->user;
    }

    public function action(){
        return  $this->action;
    }

    public function publish(){
        $this->userAdmin->status          = $this->request['status'];
        $this->userAdmin->email           = $this->request['email'];

        // IF IS UPDATE
        if($this->action == "create") {
            $this->userAdmin->password = bcrypt($this->request['password']);
        }

        $this->userAdmin->remember_token  = $this->request->_token;
        $this->userAdmin->folder          = $this->makeTempCode();

        $this->userAdmin->save();

        return UserAdmin::find($this->userAdmin->id);

    }


    protected function makeTempCode(){
        return "temp_" . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 8);
    }

}
