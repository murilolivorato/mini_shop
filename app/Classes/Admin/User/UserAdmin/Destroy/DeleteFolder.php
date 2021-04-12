<?php


namespace App\Classes\Admin\User\UserAdmin\Destroy;
use File;

class DeleteFolder
{
    protected $userAdmin;
    protected $request;

    public function __construct($userAdmin){
        $this->userAdmin            = $userAdmin->destroy();
        $this->request              = $userAdmin->request();
    }

    public function request(){
        return  $this->request;
    }


    public function destroy()
    {
        if($this->userAdmin->PathURL){

            if($this->userAdmin->ImageProfile){
                // DELETE USER IMAGE
                File::deleteDirectory(public_path($this->userAdmin->PathURL  ."/". $this->userAdmin->ImageProfile->image ));
            }

        }

        return $this->userAdmin;

    }
}
