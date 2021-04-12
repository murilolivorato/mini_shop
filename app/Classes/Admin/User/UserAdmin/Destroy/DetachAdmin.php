<?php


namespace App\Classes\Admin\User\UserAdmin\Destroy;
use Illuminate\Http\Request;

class DetachAdmin
{
    protected $userAdmin;
    protected $request;

    public function __construct($userAdmin){
        $this->userAdmin            = $userAdmin->destroy();
    }


    public function destroy()
    {
        $this->userAdmin->Roles()->detach();

        return $this->userAdmin;

    }
}
