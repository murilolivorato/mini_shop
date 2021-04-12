<?php
namespace App\Classes\Upload;

use App\Classes\Helper\MakeFileName;
use App\Classes\ImageResize\SquareImage;
use Image;
use File;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\HttpFoundation\File\UploadedFile;




class MoveOneImage {

    protected  $newImage;
    protected  $oldImage;
    protected  $folder;
    protected  $tempFolder;


    public function setNewImage($newImage){
            $this->newImage = $newImage;
            return $this;
    }

    public function setOldImage($oldImage){
        $this->oldImage = $oldImage;
        return $this;
    }

    public function setFolder($folder){
        $this->folder = $folder;
        return $this;
    }

    public function setTempFolder($tempFolder){
        $this->tempFolder = $tempFolder;
        return $this;
    }

    public function hasThumb($hasThumb = false){
        $this->hasThumb = $hasThumb;
        return $this;
    }



    public function save()
    {

        $tempImageURL       = public_path($this->tempFolder . '/' . $this->newImage);

        $newImageURL        = public_path($this->folder . '/' . $this->newImage);
        $newThumbImageUrl   = public_path($this->folder. "/" . MakeFileName::makeThumb($this->newImage));

        $oldImageURL        = public_path($this->folder . '/' . $this->oldImage);
        $oldThumbImageURL   = public_path($this->folder . '/' . MakeFileName::makeThumb($this->oldImage));



        // UPLOAD
        if($this->newImage != null &&  $this->newImage != $this->oldImage){

                if (File::move( $tempImageURL , $newImageURL )) {

                    // MAKE THUMB
                    if($this->hasThumb){
                        SquareImage::process($newImageURL , $newThumbImageUrl , 280);
                    }


                    $this->deleteOldImageIfExists($oldImageURL , $oldThumbImageURL );


                }

                return true;
        }


        // DELETE
        $this->deleteOldImageIfExists($oldImageURL , $oldThumbImageURL);
        return false;


    }


    protected function deleteOldImageIfExists($oldImageURL , $oldThumbImageURL){


        if($this->oldImage != null){
            // DELETE OLD IMAGE
            File::delete($oldImageURL);

            if($this->hasThumb) {
                // DELETE OLD IMAGE THUMB
                File::delete($oldThumbImageURL);
            }
        }
    }









}
