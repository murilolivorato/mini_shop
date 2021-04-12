<?php

namespace App\Classes\Upload;

use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Illuminate\Http\Request;
use App\Http\Requests;




abstract class UploadManyImage
{

    protected $request;
    protected $max_number_images_uploaded = 20;


    public function __construct(Request $request)
    {
        $this->request        = $request;
    }


    public abstract function processImage($file);
    public abstract function getReturnMessage();



    /**********************************************************************************
    CREATE
     ***********************************************************************************/
    public  function start()
    {

        if (!empty($this->request->file($this->inputName))):

            $count = 1;
            foreach ($this->request->file($this->inputName) as $file):

                // IF HAS LESS THAN 20 IMAGES ADDED
                if($count < $this->max_number_images_uploaded ) {


                    // process image
                    $this->processImage($file);

                    $count++;

                    continue;
                }

                $this->limit_alert = true;

            endforeach;
        endif;


    }



    /**********************************************************************************
    RETURN MESSAGE
     ***********************************************************************************/
    public function returnMessage(){
        return $this->getReturnMessage();

    }



}


