<?php


namespace App\Classes\ImageResize;
use Image;

class ImageResizeRatio
{
    public static function process($oldlocation , $newlocation , $horizontal_size , $vertical_size ){

        Image::make($oldlocation)
             ->resize($horizontal_size, $vertical_size , function ($constraint) {
                 $constraint->aspectRatio();
             })
             ->save($newlocation);

    }
}
