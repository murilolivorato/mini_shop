<?php


namespace App\Classes\Admin\User\UserAdmin\Save;


class SaveUserAdmin
{
    protected $userAdmin;
    protected $request;
    protected $user;
    protected $action;

    public function __construct($userAdmin){
        $this->userAdmin      = $userAdmin->publish();
        $this->request        = $userAdmin->request();
        $this->user           = $userAdmin->user();
        $this->action         = $userAdmin->action();
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

    public function publish()
    {

        $this->saveAdminInfo($this->action);

        return $this->userAdmin;

    }


    /**********************************************************************************
    ADMIN INFO
     ***********************************************************************************/
    public function saveAdminInfo($action){

        // action : CREATE ? UPDATE
        $this->userAdmin->AdminInfo()->$action(['name'      => $this->request['name'],
                                                'last_name' => $this->request['last_name'] ,
                                                'user_id'   => $this->user->id   ]);


    }
}
