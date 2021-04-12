<?php


namespace App\Classes\Admin\User\UserAdmin;


use App\Classes\Admin\User\UserAdmin\Save\MakeFolder;
use App\Classes\Admin\User\UserAdmin\Save\SaveProductManufacture;
use App\Classes\Admin\User\UserAdmin\Save\SaveUser;
use App\Classes\Admin\User\UserAdmin\Save\SaveUserAdmin;
use App\Classes\Admin\User\UserAdmin\Save\SyncAdmin;
use App\Classes\Admin\User\UserAdmin\Save\SaveImages;
use App\Models\UserAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcessSave
{
    protected $request;
    protected $result;
    protected $user;
    protected $userIsTheSameIsChanging = false;

    public static function process(Request $request , UserAdmin $userAdmin  ,  $user){

        return  (new static)->handle($request , $userAdmin , $user );
    }

    private function handle($request , $userAdmin , $user){
        return   $this->setRequest($request)
                      ->setUser($user)
                      ->save($userAdmin)
                      ->getResult();
    }

    // SET REQUEST
    private function setRequest($request){

        $this->request = $request;
        return $this;
    }

    // SET USER
    private function setUser($user){


        $this->user = $user != null ? UserAdmin::find($user->id) : null;
        return $this;
    }

    // SAVE BOOK
    private function save($userAdmin)
    {
        // START TRANSACTION
        DB::beginTransaction();

        // IS EDITING
        if($userAdmin->exists) {
            $this->userIsTheSameIsChanging = $this->user->id == $userAdmin->id ? true : false;
        }

        $userAdmin  =   // SAVE IMAGES
            new SaveImages(
            // SAVE POST TAG
                new SaveUserAdmin(
                // ATTACH ADMIN
                    new SyncAdmin(
                    // MAKE FOLDER
                        new MakeFolder(
                        // SALVA A FILIAL
                            new SaveUser($userAdmin ,
                                         $this->request ,
                                         $this->user
                            )
                        )
                    )
                )
            );

        $this->result = $userAdmin->publish();


        // END TRANSACTION
        DB::commit();

        return $this;

    }
    public function getResult(){

        // ERRO
        if(! $this->result ){
            return response()->json(null , 400);

        }

        // SUCESSO
        return response()->json(null ,  200 );
    }
}
