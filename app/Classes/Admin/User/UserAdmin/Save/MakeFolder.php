<?php


namespace App\Classes\Admin\User\UserAdmin\Save;

use App\Classes\Helper\Hash;
use File;

class MakeFolder
{
    protected $userAdmin;
    protected $request;
    protected $user;
    protected $action;

    public function __construct($userAdmin)
    {
        $this->userAdmin = $userAdmin->publish();
        $this->request   = $userAdmin->request();
        $this->user      = $userAdmin->user();
        $this->action    = $userAdmin->action();
    }

    public function request()
    {
        return $this->request;
    }

    public function user()
    {
        return $this->user;
    }

    public function action()
    {
        return $this->action;
    }

    public function publish()
    {
        // IS NOT UPDATING
        if ($this->action == "create") {
            $this->create_folder();
        }

        return $this->userAdmin;

    }

    protected function create_folder()
    {
        // IF IS EMPTY FOLDER
        $this->userAdmin->folder =  Hash::folder($this->userAdmin->id);
        $this->userAdmin->save();

       /* $this->makeFolderDirectory($this->userAdmin->PathURL);*/
    }


}
