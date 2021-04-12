<?php
namespace App\Classes\Upload;

use Image;
use File;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\HttpFoundation\File\UploadedFile;


use App\Models\UserPub;


class AddPhoto1 {

    protected  $image_obj;
    protected  $user;
    protected  $url_image;
    protected  $old_image;


    public function __construct($image_obj , $url_image , UserPub $user , $old_image = Null ){

        $this->image_obj          = $image_obj;
        $this->url_image          = $url_image;
        $this->user               = $user;
        $this->old_image          = $old_image;

    }


    public function save(){

        /* verify if has image 1 to upload if has , delete the old one , upload the new one and Save  */
        $verify_has_image_upload = $this->verify_has_image_upload( $this->image_obj->image , $this->url_image , $this->old_image);


        return ['index' =>  $this->image_obj->index , 'image' => $verify_has_image_upload ,  'title' =>  $this->image_obj->title , 'position' => $this->image_obj->position ];


    }




    protected function verify_has_image_upload($image_name  , $url_image , $old_image = Null ){


        $oldlocation = "assets/temp/" . $image_name;
        $newlocation = "assets/photos/".$url_image."/".$image_name;

        // just gonna upload if has image been uploaded and if tje old image is diferente of the image that is been uploading
        if($image_name != Null &&  $old_image != $image_name ){


            File::move($oldlocation, $newlocation);

            // delete old image
            $old_image != Null ? File::delete(public_path('/assets/photos/'.$url_image.'/'.$old_image)) : "";


        }else{
            echo "entrou em branco";
        }



        return $image_name;


    }






}
