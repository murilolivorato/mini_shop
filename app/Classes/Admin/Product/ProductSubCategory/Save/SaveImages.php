<?php


namespace App\Classes\Admin\Product\ProductSubCategory\Save;
use Image;
use File;

class SaveImages
{
    protected $productSubCategory;
    protected $request;
    protected $user;
    protected $action;

    public function __construct($productSubCategory){
        $this->productSubCategory = $productSubCategory->publish();
        $this->request            = $productSubCategory->request();
        $this->user               = $productSubCategory->user();
        $this->action             = $productSubCategory->action();
    }

    public function request(){
        return  $this->request;
    }

    public function user(){
        return  $this->user;
    }

    public function action(){
        return  $this->action;
    }

    public function publish()
    {

        $new_image = $this->request['image'];
        $old_image = $this->productSubCategory->Image()->exists()  ? $this->productSubCategory->Image :
            null;
        // HAS NEW IMAGE
        if (!empty($new_image)) {
            $this->makeUploadImage($new_image, $old_image);
        }


        return true;
    }

    /**********************************************************************************
    MAKE UPLOAD
     ***********************************************************************************/
    protected function makeUploadImage($new_image , $old_image){
        // IF ALREADY HAS THIS IMAGE , UPDATE IT

        if($old_image){

            // UPDATE IMAGE
            $this->updateImage($new_image , $old_image->image );


            return;
        }

        //CREATE IMAGE
        $this->createImage($new_image);
    }


    /**********************************************************************************
    CREATE IMAGE
     ***********************************************************************************/
    public function createImage($new_image)
    {
        // IMAGE IS NULL
        if($new_image['image'] != ""){
            // IF IS NOT NULL ADD IMAGE
            if($this->makeUpload($new_image['image'])){
                // CREATE IMAGE
                $this->createImageDB($new_image);
            }
        }

    }

    protected function makeUpload($new_image){
        $oldlocation = public_path($this->productSubCategory->PathURLTemp . "/" . $new_image);
        $newlocation = public_path($this->productSubCategory->PathURL ."/". $new_image);


        // RELOCATE , THEN SAVE IN DB
        if (File::move($oldlocation, $newlocation)) {
            return true;
        }
    }


    /**********************************************************************************
    UPDATE IMAGE
     ***********************************************************************************/
    public function updateImage($new_image , $old_image){

        // FEZ UPLOAD
        if($new_image['image'] != $old_image){

            if($new_image['image'] != "") {
                // FEZ UPLOAD NOVO
                if ($this->makeUpload($new_image['image'])) {
                    // CREATE THE IMAGE
                    $this->updateImageDB($new_image);
                }
                return;
            }


            if($old_image){
                // DELETE THE IMAGE
                $this->deleteImage($old_image);
            }

        }
    }




    /**********************************************************************************
    DELETE IMAGE DISPLAY
     ***********************************************************************************/
    protected function deleteImage($old_image){

        // old image
        $old_image_url = $this->productSubCategory->PathURL ."/" .$old_image;

        // delete image
        File::delete(public_path($old_image_url));

        // delete image from DB
        $this->deleteImageDB();

    }



    /**********************************************************************************
    ADD IMAGE
     ***********************************************************************************/
    public function createImageDB($image_obj){

        // create image
        $this->productSubCategory->Image()->create(['image'       => $image_obj['image'] ,
                                                     'title'      => $image_obj['title'] ,
                                                     'user_id'    => $this->user->id ,
                                                     'user_ip'    => ip2long($_SERVER['REMOTE_ADDR']) ]);


    }



    /**********************************************************************************
    UPDATE IMAGE
     ***********************************************************************************/

    public function updateImageDB($image_obj){

        // create image
        $this->productSubCategory->Image()->update(['image'      => $image_obj['image'] ,
                                                    'title'      => $image_obj['title'] ,
                                                    'user_id'    => $this->user->id ,
                                                    'user_ip'    => ip2long($_SERVER['REMOTE_ADDR']) ]);
        }


    /**********************************************************************************
    DELETE IMAGE
     ***********************************************************************************/

    public function deleteImageDB(){
        // create image
        $this->productSubCategory->Image()->delete();
    }
}
