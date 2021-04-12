<?php


namespace App\Classes\Admin\User\UserAdmin\Save;


class SyncAdmin
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
        // SYNC ADMIN
        if ($this->action == "create") {
            $this->userAdmin->Roles()->sync([0 => 1]);
        }

        return $this->userAdmin;
    }
}