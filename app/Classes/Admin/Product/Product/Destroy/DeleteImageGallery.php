<?php


namespace App\Classes\Admin\Product\Product\Destroy;


class DeleteImageGallery
{
    protected $product;
    protected $request;

    public function __construct($product){
        $this->product          = $product->destroy();
        $this->request          = $product->request();
    }

    public function request(){
        return  $this->request;
    }


    public function destroy()
    {
        if($this->product->ImageGallery){
            $this->product->ImageGallery->delete();
        }

        return $this->product;
    }
}
