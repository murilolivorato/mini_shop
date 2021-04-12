<?php


namespace App\Classes\Admin\User\UserAdmin;
use App\Classes\Upload\UploadOneImage;
use App\Classes\ImageResize\ImageResize;

class UploadImage extends UploadOneImage
{
    public function resizeImage(){

            // RESIZE IMAGE
            ImageResize::process($this->oldLocation , $this->newLocation , 400 , 460 );

    }

}
