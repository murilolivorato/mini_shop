<?php

namespace App\Classes\Upload;

use Illuminate\Http\Request;
use Image;
use File;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadManyFile
{

    protected $request;


    public function __construct(Request $request ){

        $this->request        = $request;
    }

    /**********************************************************************************
    CREATE
     ***********************************************************************************/
    public function create()
    {

        $gallery_files = array();

        /*
        * Validate the request
        */


        if (!empty($this->files)):

            $count = 1;
            foreach ($this->files as $file):

                /*$main_image_filename = $this->makeFileName($file);



                $file->move(public_path('/assets/temp'), $main_image_filename);*/


                /* make insert inside the array */
                array_push($gallery_files, $main_image_filename);

                $count++;

            endforeach;

            return $gallery_files;



        endif;
    }




    /**********************************************************************************
    MAKE FILE NAME
     ***********************************************************************************/
    protected function makeFileName($file) {

        $image = sha1(
            time(). $file->getClientOriginalName()
        );

        $extension = $file->getClientOriginalExtension();

        return "{$image}.{$extension}";


    }
}
