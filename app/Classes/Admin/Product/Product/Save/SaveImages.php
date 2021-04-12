<?php


namespace App\Classes\Admin\Product\Product\Save;


use App\Classes\ImageResize\ImagePicture;
use App\Models\ProductImage;
use File;

class SaveImages
{
    protected $gallery;
    protected $request;
    protected $product;
    protected $user;
    protected $action;


    public function __construct($product){

        $this->product            = $product->publish();
        $this->request            = $product->request();
        $this->gallery            = $product->gallery();
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

        // SAVE IMAGES IN THE GALLERY
        if($this->request['images']){
            $this->saveImages($this->request['images']);
        }


        return $this->product;
    }


    /**********************************************************************************
    SAVE
     ***********************************************************************************/
    protected function saveImages($images){

        // CREATE IMAGES
        foreach($images as  $key => $obj) {

            //  if photo exists is UPDATE otherwise is CREATE
            if($obj['id'] == "temp"){
                // UPLOAD IMAGE
                $this->create_image($obj);

                // SAVE RELOCATE THE FILE
                $image                     = new ProductImage();
                // SAVE IN DB
                $this->saveDBImage($image , $obj , $key);
                continue;
            }


            //VERIFY IF HAS THIS IMAGE SAVED
            $image = ProductImage::where('gallery_id', $this->gallery->id )->where('image', $obj['image'] )->first();
            if($image){
                $this->saveDBImage($image , $obj , $key);
            }


        }


    }


    protected function create_image( $obj){


        $oldlocation = public_path($this->product->PathURLTemp . "/" . $obj['image']);
        $newlocation = public_path($this->product->PathURL ."/".$obj['image']);


        // RELOCATE , THEN SAVE IN DB
        if (File::move($oldlocation, $newlocation)) {

            // SAVE THUMB
            $this->makeThumbImage($newlocation , $obj);



        }


    }

    protected function makeThumbImage($newlocation , $obj ){
        // GET THE URL DIRECTION OF THE THUMB
        $thumb_name_location = public_path($this->product->PathURL. "/" . $this->makeThumbName($obj['image']) );

        // MAKE THE THUMB
        ImagePicture::process($newlocation , $thumb_name_location , 300 , 216 );

    }

    protected function saveDBImage($image , $obj , $index ){

        $image->image              = $obj['image'];
        $image->title              = $obj['title'];
        $image->order              = $index;
        $image->gallery_id         = $this->gallery->id;
        $image->user_id            = $this->gallery->user_id;
        $image->user_ip            = ip2long($_SERVER['REMOTE_ADDR']);
        $image->save();
    }




    protected function makeThumbName($image) {

        $image_thumb    = explode(".", $image  );

        return $image_thumb[0]."_thumb.".$image_thumb[1];
    }
}
