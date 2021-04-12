<?php

namespace App\Classes\Upload;


use App\Models\UserAdmin;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\HttpFoundation\File\UploadedFile;


use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\UserPub;
use App\Classes\Helper\MakeFileName;



abstract class UploadOneImage
{


    protected $request;
    protected $image;
    protected $user;
    protected $newImageName;
    protected $oldLocation;
    protected $newLocation;
    protected $tempPath = '/assets/temp';

    // RESIZE IMAGE
    public abstract function resizeImage();

    public static function processImage(Request $request){

        return  (new static)->handle($request);
    }


    private function handle($request){
        return   $this->setRequest($request)
                      ->setImageName()
                      ->setNewImageName()
                      ->setOldLocation()
                      ->setNewLocation()
                      ->uploadImage();
    }

    // SET IMAGE
    private function setRequest($request){
        $this->request = $request;
        return $this;
    }


    private function setImageName(){
        $this->image   = $this->request->file('image')[0];
        return $this;
    }

    private function setNewImageName(){
        $this->newImageName = MakeFileName::create($this->image);
        return $this;
    }

    private function setOldLocation(){
        $this->oldLocation = public_path($this->tempPath) . "/" . $this->newImageName;
        return $this;
    }

    private function setNewLocation(){
        $this->newLocation = public_path($this->tempPath) . "/" . $this->newImageName;
        return $this;
    }


    private  function uploadImage(){

        // UPLOAD IMAGE
        $this->image->move(public_path($this->tempPath), $this->newImageName);

        // RESIZE IMAGE
        $this->resizeImage();

        return [ 'index' => $this->request->index  , 'image' => $this->newImageName ];
    }



}


