<?php


namespace App\Classes\Admin\Product\Product\Save;


use App\Models\ProductFile;

class SaveFiles
{
    protected $gallery;
    protected $request;
    protected $product;
    protected $user;
    protected $action;


    public function __construct($product){

        $this->product           = $product->publish();
        $this->request           = $product->request();
        $this->user              = $product->user();
        $this->action            = $product->action();

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
        if($this->request['files']){
            $this->saveFiles($this->request['files']);
        }

        return $this->product;
    }


    /**********************************************************************************
    SAVE
     ***********************************************************************************/
    protected function saveFiles($files){

        // CREATE IMAGES
        foreach($files as $obj) {

            //  if photo exists is UPDATE otherwise is CREATE
            if($obj['id'] == "temp"){
                $this->create_image($obj);
                continue;
            }


            //VERIFY IF HAS THIS IMAGE SAVED
            $file = ProductFile::where('gallery_id', $this->product->id )->where('file', $obj['file'] )->first();
            if($file){
                $this->saveDBImage($file , $obj);
            }

        }

    }


    protected function create_image( $obj  ){


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

    protected function saveDBImage($image , $obj ){

        $image->file               = $obj['file'];
        $image->title              = $obj['title'];
        $image->gallery_id         = $this->product->id;
        $image->user_id            = $this->product->user_id;
        $image->user_ip            = ip2long($_SERVER['REMOTE_ADDR']);
        $image->save();
    }


}
