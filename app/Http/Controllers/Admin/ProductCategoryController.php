<?php

namespace App\Http\Controllers\admin;

use App\Classes\Admin\Product\ProductCategory\LoadForm;
use App\Classes\Admin\Product\ProductCategory\LoadDisplay;
use App\Classes\Admin\Product\ProductCategory\ProcessDestroy;
use App\Classes\Admin\Product\ProductCategory\ProcessSave;
use App\Classes\Admin\Product\ProductCategory\UploadImage;
use App\Http\Requests\Admin\ProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;



class ProductCategoryController extends Controller
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
    LOAD FORM
     ***********************************************************************************/
    public function load_form(Request $request , $id)
    {
        return LoadForm::load($request , $id );
    }


    /**********************************************************************************
    STORE
     ***********************************************************************************/
    public function store(ProductCategoryRequest $request)
    {
        // FILIAL
        $postCategory = new ProductCategory($request->all());
        return  ProcessSave::process($request ,  $postCategory , $this->user );
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
    public function update(ProductCategoryRequest $request , $id)
    {

        // FILIAL
        $postCategory = ProductCategory::find($id);

        if($postCategory){
            return  ProcessSave::process($request ,  $postCategory  , $this->user );

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
