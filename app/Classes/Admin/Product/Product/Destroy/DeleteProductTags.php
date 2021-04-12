<?php


namespace App\Classes\Admin\Product\Product\Destroy;


class DeleteProductTags
{
    protected $product;
    protected $request;

    public function __construct($product){
        $this->product         = $product->destroy();
        $this->request         = $product->request();
    }

    public function request(){
        return  $this->request;
    }


    public function destroy()
    {
        // PRODUCT TAGS
        $this->product->ProductTags()->detach();
        return $this->product;
    }
}
