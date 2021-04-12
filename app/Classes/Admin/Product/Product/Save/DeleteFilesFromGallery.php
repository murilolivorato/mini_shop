<?php


namespace App\Classes\Admin\Product\Product\Save;

use App\Models\ProductFile;
use App\Models\ProductImage;

class DeleteFilesFromGallery
{
    protected $request;
    protected $prop;
    protected $user;
    protected $action;


    public function __construct($prop){

        $this->prop               = $prop->publish();
        $this->request            = $prop->request();
        $this->user               = $prop->user();
        $this->action             = $prop->action();

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

        $deleted_files = $this->request['deleted_files_from_gallery'];
        // IF HAS DELETED IMAGES , DELETE IT
        if(is_array($deleted_files)){
            if(! empty ($deleted_files)){
                $this->deleteFiles($deleted_files);

            }
        }

        return $this->prop;
    }

    /**********************************************************************************
    DELETE IMAGES
     ***********************************************************************************/
    protected function deleteFiles($images){

        // CREATE IMAGES
        foreach($images as $image_id) {

            $propFile = ProductFile::find($image_id);

            if(! $propFile){
                continue;
            }

            if(! $propFile->ownedBy($this->user)){
                continue;
            }


            // DELETE IMAGE
            File::delete(public_path($propFile->UrlFile));



            //DELETE THE IMAGE FROM DB
            $propFile->delete();

        }
    }
}
