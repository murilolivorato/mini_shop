<?php


namespace App\Classes\Admin\User\UserAdmin;
use App\Classes\Admin\User\UserAdmin\Destroy\DeleteFolder;
use App\Classes\Admin\User\UserAdmin\Destroy\DeleteUser;
use App\Classes\Admin\User\UserAdmin\Destroy\DeleteImage;
use App\Classes\Admin\User\UserAdmin\Destroy\DestroyUserAdmin;
use App\Classes\Admin\User\UserAdmin\Destroy\DetachAdmin;
use App\Models\UserAdmin;
use Illuminate\Support\Facades\DB;

class ProcessDestroy
{
    protected $request;
    protected $user;
    protected $list_index = [];


    public static function process($request){

        return  (new static)->handle($request);
    }

    private function handle($request){
        return   $this->setRequest($request)
                      ->destroyBook()
                      ->result();
    }

    // SET REQUEST
    private function setRequest($request){
        $this->request = $request;
        return $this;
    }

    // DESTROY BOOK
    private function destroyBook(){

        // START TRANSACTION
        DB::beginTransaction();

        foreach($this->request['delete'] as $deleteItem) {

            $userAdmin = UserAdmin::find($deleteItem['id']);

            // DELETE USER
            $userAdmin =  new DeleteUser(
                               // DETATCH ADMIN
                                new DetachAdmin(
                                            // DESTROY USER ADMIN
                                            new DestroyUserAdmin(
                                                    // DELETE IMAGE
                                                    new DeleteImage(
                                                         $userAdmin
                                                    )
                                                )
                                           )
                          );


            if($userAdmin->destroy() == true ){
                // push index into index , to make VUE effect to delete
                array_push($this->list_index , $deleteItem['index']);
            }
        }

        // END TRANSACTION
        DB::commit();

        return $this;
    }

    private function result(){

        if(empty($this->list_index)){

            return response()->json(['message' => 'Erro, Comunique o Suporte' ] , 400);
        }

        // success
        return response()->json(['index'   => $this->list_index  ] , 200);
    }
}
