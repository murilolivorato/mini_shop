<?php


namespace App\Classes\Admin\Product\Product\Save;

use App\Models\ProductImageGallery;


class SaveImageGallery
{
    protected $product;
    protected $request;
    protected $gallery;
    protected $user;
    protected $action;

    public function __construct($product){
        $this->product = $product->publish();
        $this->request = $product->request();
        $this->user    = $product->user();
        $this->action  = $product->action();
    }

    public function request(){
        return  $this->request;
    }

    public function gallery(){
        return $this->gallery;
    }

    public function user(){
        return  $this->user;
    }

    public function action(){
        return  $this->action;
    }

    public function publish()
    {
        // SET GALLERY
        $this->gallery = $this->setGallery();

        return $this->product;
    }

    protected function setGallery(){
        // IF GALLERY DOES NOT EXIST CREATE IT
        if(! $this->product->ImageGallery){
            return $this->gallery =  $this->create_gallery();
        }

        return $this->product->ImageGallery;
    }

    //ImageGallery
    protected function create_gallery(){

        $gallery                   = new ProductImageGallery();
        $gallery->product_id       = $this->product->id;
        $gallery->user_id          = $this->user->id;
        $gallery->user_ip          = ip2long($_SERVER['REMOTE_ADDR']);

        $gallery->save();

        return $gallery;


    }
}
