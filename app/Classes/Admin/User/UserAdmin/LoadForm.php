<?php


namespace App\Classes\Admin\User\UserAdmin;
use App\Classes\Helper\SetArrayValue;
use App\Models\Post;
use App\Models\User;
use App\Models\UserAdmin;

class LoadForm
{
    protected $request;
    protected $user;


    public static function load($request, $id)
    {
        return (new static)->handle($request, $id);
    }

    private function handle($request, $id)
    {
        return $this->setRequest($request)
                    ->getResult($id);
    }

    private function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    private function getResult($id)
    {
        $admin_user  = UserAdmin::findOrFail($id);

        if(! $admin_user->isAdmin){
            return;
        }

        return[
            'id'            => $admin_user->id ,
            'status'        => $admin_user->status ,
            'email'         => $admin_user->email ,
            'folder'        => $admin_user->folder ,
            'name'          => ! $admin_user->AdminInfo ?: $admin_user->AdminInfo->name ,
            'last_name'     => ! $admin_user->AdminInfo ?: $admin_user->AdminInfo->last_name ,
            'image'         => $this->setImageGalleryDisplay($admin_user)
        ];

    }

    private function setImageGalleryDisplay(UserAdmin $admin_user){
        // if has image
        if($admin_user->ImageProfile()->exists()){
            return [
                'id'          => $admin_user->ImageProfile->id ,
                'image'       => $admin_user->ImageProfile->image
            ];
        }

        return [
            'id'          => "temp" ,
            'image'       => ""
        ];
    }


}
