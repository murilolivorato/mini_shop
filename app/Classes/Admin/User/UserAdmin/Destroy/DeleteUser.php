<?php


namespace App\Classes\Admin\User\UserAdmin\Destroy;


class DeleteUser
{
    protected $userAdmin;
    protected $request;

    public function __construct($userAdmin){
        $this->userAdmin            = $userAdmin->destroy();
    }


    public function destroy()
    {
        $this->userAdmin->delete();

        return true;

    }
}
