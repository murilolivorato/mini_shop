<?php


namespace App\Classes\Admin\Product\Product\Save;


use App\Models\ProductFile;

class SaveFileGallery
{
    protected $product;
    protected $request;
    protected $gallery;
    protected $user;
    protected $action;

    public function __construct($product){
        $this->product = $product->publish();
        $this->request = $product->request();
        $this->gallery = $product->gallery();
        $this->user    = $product->user();
        $this->action  = $product->action();
    }

    public function request(){
        return  $this->request;
    }

    public function gallery(){
        return $this->gallery;
    }

    public function user(){
        return  $this->user;
    }

    public function action(){
        return  $this->action;
    }

    public function publish()
    {
        // SAVE IMAGES IN THE GALLERY
        if($this->request['file_gallery']['files']){
            $this->saveFiles($this->request['file_gallery']['files']);
        }


        return $this->product;
    }

    protected function saveFiles($files){
        // CREATE IMAGES
        foreach($files as $obj) {

            //  if photo exists is UPDATE otherwise is CREATE
            if($obj['id'] == "temp"){

                $this->create_file($obj);
                continue;
            }


            //VERIFY IF HAS THIS IMAGE SAVED
            $image = ProductFile::where('gallery_id', $this->gallery->id )->where('file', $obj['file'] )->first();
            if($image){
                $this->saveDBImage($image , $obj);
            }


        }
    }




    protected function create_file( $obj  ){


        $oldlocation = public_path($this->product->PathURLTemp . "/" . $obj['file']);
        $newlocation = public_path($this->product->PathURL ."/".$obj['file']);


        // RELOCATE , THEN SAVE IN DB
        if (File::move($oldlocation, $newlocation)) {


            // SAVE RELOCATE THE FILE
            $file                     = new ProductFile();

            // SAVE IN DB
            $this->saveDBImage($file , $obj );

        }


    }

    protected function saveDBImage($file , $obj ){

        //$gallery     = PropImageGallery::where('id' , $this->gallery->id )->first();
        $file->file               = $obj['file'];
        $file->title              = $obj['title'];
        $file->gallery_id         = $this->gallery->id;
        $file->user_id            = $this->gallery->user_id;
        $file->user_ip            = ip2long($_SERVER['REMOTE_ADDR']);
        $file->save();
    }



}
