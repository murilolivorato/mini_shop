<?php

namespace App\Http\Controllers\admin;


use App\Models\UserAdmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Admin\User\UserAdmin\LoadDisplay;
use App\Classes\Admin\User\UserAdmin\LoadOptions;
use App\Classes\Admin\User\UserAdmin\LoadForm;
use App\Classes\Admin\User\UserAdmin\ProcessSave;
use App\Classes\Admin\User\UserAdmin\ProcessSavePassword;
use App\Http\Requests\Admin\CreateUserAdminRequest;
use App\Http\Requests\Admin\UpdateUserAdminRequest;
use App\Http\Requests\Admin\UpdatePasswordUserAdminRequest;
use App\Classes\Admin\User\UserAdmin\ProcessDestroy;
use App\Classes\Admin\User\UserAdmin\UploadImage;

class AdminUserController extends Controller
{

    /**********************************************************************************
    LOAD DISPLAY
     ***********************************************************************************/
    public function load_display(Request $request)
    {
        // COMECA  A DUSCA
        return LoadDisplay::load($request);
    }

    /**********************************************************************************
    FORM OTIONS
     ***********************************************************************************/
    public function load_form_options(Request $request)
    {
        return LoadOptions::load($request);
    }

    /**********************************************************************************
    STORE
     ***********************************************************************************/
    public function store(CreateUserAdminRequest $request)
    {
        // FILIAL
        $userAdmin = new UserAdmin($request->all());
        return  ProcessSave::process($request ,  $userAdmin , $this->user );
    }



    /**********************************************************************************
    LOAD FORM
     ***********************************************************************************/
    public function load_form(Request $request , $id)
    {
        return LoadForm::load($request , $id  );
    }


    /**********************************************************************************
    UPLOAD IMAGE / FILE
     ***********************************************************************************/
    public function upload_images(Request $request )
    {
        return UploadImage::processImage($request);
    }


    /**********************************************************************************
    UPDATE
     ***********************************************************************************/
    public function update(UpdateUserAdminRequest $request , $id)
    {
        // FILIAL
        $userAdmin = UserAdmin::find($id);

        if($userAdmin){
            return  ProcessSave::process($request ,  $userAdmin  , $this->user  );
        }
    }


    /**********************************************************************************
    UPDATE
     ***********************************************************************************/
    public function update_password(UpdatePasswordUserAdminRequest $request , $id)
    {
        // FILIAL
        $userAdmin = UserAdmin::find($id);

        if($userAdmin){
            return  ProcessSavePassword::process($request ,  $userAdmin  , $this->user   );
        }
    }

    /**********************************************************************************
    DELETE
     ***********************************************************************************/
    public function destroy(Request $request)
    {
        return  ProcessDestroy::process($request);
    }

}
