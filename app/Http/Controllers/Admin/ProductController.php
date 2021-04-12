<?php

namespace App\Http\Controllers\admin;

use App\Classes\Admin\Gallery\GalleryImage\UploadImages;
use App\Classes\Admin\Product\Product\LoadDisplay;
use App\Classes\Admin\Product\Product\LoadForm;
use App\Classes\Admin\Product\Product\LoadOptions;
use App\Classes\Admin\Product\Product\ProcessDestroy;
use App\Classes\Admin\Product\Product\ProcessSave;
use App\Classes\Admin\Product\Product\LoadSubCategory;
use App\Http\Requests\Admin\GalleryImageUploadRequest;


use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class ProductController extends Controller
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
    UPLOAD IMAGE / FILE
     ***********************************************************************************/
    public function upload_image(GalleryImageUploadRequest $request )
    {
        $uploadImage =   new UploadImages($request);
        $uploadImage->start();
        return $uploadImage->returnMessage();
    }


    /**********************************************************************************
    LOAD FORM
     ***********************************************************************************/
    public function load_form(Request $request , $id)
    {
        return LoadForm::load($request , $id );
    }

    /**********************************************************************************
    LOAD FORM
     ***********************************************************************************/
    public function load_sub_category(Request $request , $id)
    {
        return LoadSubCategory::load($request , $id  );
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
    public function store(ProductRequest $request)
    {
        // FILIAL
        $product = new Product($request->all());
        return  ProcessSave::process($request ,  $product , $this->user );
    }



    /**********************************************************************************
    UPDATE
     ***********************************************************************************/
    public function update(ProductRequest $request , $id)
    {

        // FILIAL
        $product = Product::find($id);

        if($product){
            return  ProcessSave::process($request ,  $product  , $this->user );

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
