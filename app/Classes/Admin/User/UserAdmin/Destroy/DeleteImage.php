<?php


namespace App\Classes\Admin\User\UserAdmin\Destroy;
use App\Models\UserAdmin;
use File;

class DeleteImage
{
    protected $userAdmin;

    public function __construct(UserAdmin $userAdmin){
        $this->userAdmin            = $userAdmin;
    }


    public function destroy()
    {
        // DELETE IMAGE IF EXISTS
        if($this->userAdmin->ImageProfile()->exists()){
            File::delete(public_path( $this->userAdmin->ImageProfile->ImagePathUrl));
        }


        return UserAdmin::find($this->userAdmin->id);

    }
}
