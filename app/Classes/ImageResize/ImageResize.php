<?php
/**
 * Created by PhpStorm.
 * UserPub: murilo
 * Date: 07/05/2019
 * Time: 13:47
 */

namespace App\Classes\ImageResize;
use Image;

class ImageResize
{
    public static function process($oldlocation , $newlocation , $horizontal_size , $vertical_size ){

        Image::make($oldlocation)
             ->resize($horizontal_size, $vertical_size )
             ->save($newlocation);

    }
}
