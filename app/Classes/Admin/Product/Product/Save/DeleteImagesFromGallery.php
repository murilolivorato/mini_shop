<?php


namespace App\Classes\Admin\Product\Product\Save;
use Image;
use File;
use App\Models\ProductImage;

class DeleteImagesFromGallery
{
    protected $request;
    protected $product;
    protected $user;
    protected $action;


    public function __construct($product){

        $this->product            = $product->publish();
        $this->request            = $product->request();
        $this->user               = $product->user();
        $this->action             = $product->action();

    }

    public function action(){
        return  $this->action;
    }


    public function request(){
        return  $this->request;
    }

    public function user(){
        return  $this->user;
    }

    public function publish(){

        $deleted_images = $this->request['deleted_images'];
        // IF HAS DELETED IMAGES , DELETE IT
        if(is_array($deleted_images)){
            if(! empty ($deleted_images)){
                $this->deleteImages($deleted_images);

            }
        }

        return $this->product;
    }

    /**********************************************************************************
    DELETE IMAGES
     ***********************************************************************************/
    protected function deleteImages($images){

        // CREATE IMAGES
        foreach($images as $image_id) {

            $productGlImage = ProductImage::find($image_id);

            if(! $productGlImage){
                continue;
            }

            if(! $productGlImage->ownedBy($this->user)){
                continue;
            }


            // DELETE IMAGE
            File::delete(public_path($productGlImage->UrlImage));

            // DELETE IMAGE THUMB
            File::delete(public_path($productGlImage->UrlImageThumb));

            //DELETE THE IMAGE FROM DB
            $productGlImage->delete();

        }
    }

}
