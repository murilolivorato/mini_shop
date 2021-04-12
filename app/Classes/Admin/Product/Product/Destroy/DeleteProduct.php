<?php


namespace App\Classes\Admin\Product\Product\Destroy;


class DeleteProduct
{
    protected $product;
    protected $request;

    public function __construct($product){
        $this->product         = $product->destroy();
    }

    public function request(){
        return  $this->request;
    }


    public function destroy()
    {
        if($this->product){
            $this->product->delete();
        }

        return true;
    }
}
