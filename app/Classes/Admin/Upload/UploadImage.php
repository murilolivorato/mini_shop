<?php
namespace App\Classes\Upload;

use Image;
use File;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Classes\Upload\MakeThumbnail;

class UploadImage
{

    protected $file;
    protected $selected_image;

    public function __construct($file , $selected_image , $action_image){

        $this->file                 = $file;
        $this->selected_image       = $selected_image;
        $this->action_image         = $action_image;

    }


    public function create(){

        $photos = array();

        if (!empty($this->file)):


            $main_image_filename = $this->makeFileName($this->file);

            /*  $main_image_filename = $file->getClientOriginalName(); */
            $this->file->move(public_path('assets/temp'), $main_image_filename);


            $this->makeUpload($main_image_filename);

            /* make insert inside the array */
            array_push( $photos , $main_image_filename );

            return [ 'selected_image' => $this->selected_image  , 'image' => $main_image_filename ];

        endif;


    }




    /**********************************************************************************
    MAKE FILE NAME
     ***********************************************************************************/
    protected function makeUpload($main_image_filename){

        foreach($this->action_image as $key => $action){

                if($key == $this->selected_image) {

                    (new  MakeThumbnail(public_path('/assets/temp') . "/" . $main_image_filename, public_path('/assets/temp') . "/" . $main_image_filename))->create_image_resize($action);
                   // $this->makeUploadAction($action , $main_image_filename);
                }
        }



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