<?php


namespace App\Classes\Admin\Gallery\GalleryImage;

use App\Classes\Upload\UploadManyImage;
use App\Classes\Helper\MakeFileName;
use Image;
use File;
use App\Classes\ImageResize\ImageResize;

class UploadImages extends UploadManyImage
{
    protected $max_number_images_uploaded    = 20;
    protected $limit_alert                   = false;
    protected $created_images                = [];
    protected $path = '/assets/temp';
    protected $inputName                     =  "image";



    public function processImage($file){

        $fileName = MakeFileName::create($file);

        $file->move(public_path($this->path), $fileName);

        $oldlocation = public_path($this->path) . "/" . $fileName;
        $newlocation = public_path($this->path) . "/" . $fileName;

        ImageResize::process($oldlocation , $newlocation , 990 , 680 );

        /* make insert inside the array */
        array_push($this->created_images, $fileName);


    }

    public function getReturnMessage(){
        return response()->json(['all_files'   => $this->created_images  ,
                                 'limit_alert' => $this->limit_alert ]);

    }




}
