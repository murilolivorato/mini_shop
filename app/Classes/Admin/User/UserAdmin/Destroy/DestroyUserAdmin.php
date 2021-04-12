<?php


namespace App\Classes\Admin\User\UserAdmin\Destroy;

use App\Models\UserAdmin;
use Illuminate\Http\Request;

class DestroyUserAdmin
{
    protected $userAdmin;

    public function __construct($userAdmin)
    {
        $this->userAdmin    =  $userAdmin->destroy();
    }


    public function destroy()
    {
        if($this->userAdmin->AdminInfo){
              $this->userAdmin->AdminInfo->delete();
        }
        return UserAdmin::find($this->userAdmin->id);
    }
}
