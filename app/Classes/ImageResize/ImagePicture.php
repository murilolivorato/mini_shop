<?php
/**
 * Created by PhpStorm.
 * UserPub: murilo
 * Date: 07/03/2019
 * Time: 01:19
 */

namespace App\Classes\ImageResize;
use Image;

class ImagePicture
{
    public static function process($oldlocation , $newlocation , $horizontal_size , $vertical_size ){
        // create new image with transparent background color
        $background = Image::canvas($horizontal_size , $vertical_size);

        $image = Image::make($oldlocation)->fit( $horizontal_size , $vertical_size , function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });

        // insert resized image centered into background
        $background->insert($image, 'center');

        // save or do whatever you like
        $background->save($newlocation);
    }
}