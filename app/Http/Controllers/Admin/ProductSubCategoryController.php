<?php

namespace App\Http\Controllers\admin;

use App\Classes\Admin\Product\ProductSubCategory\UploadImage;
use App\Classes\Admin\Product\ProductSubCategory\LoadForm;
use App\Classes\Admin\Product\ProductSubCategory\LoadOptions;
use App\Classes\Admin\Product\ProductSubCategory\ProcessDestroy;
use App\Classes\Admin\Product\ProductSubCategory\ProcessSave;
use App\Classes\Admin\Product\ProductSubCategory\LoadDisplay;
use App\Http\Requests\Admin\ProductSubCategoryRequest;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\ProductSubCategory;



class ProductSubCategoryController extends Controller
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
        return LoadForm::load($request , $id  );
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
    public function store(ProductSubCategoryRequest $request)
    {
        // FILIAL
        $postCategory = new ProductSubCategory($request->all());
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
    public function update(ProductSubCategoryRequest $request , $id)
    {
        // FILIAL
        $postCategory = ProductSubCategory::find($id);

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
