<?php


namespace App\Classes\Admin\Product\Product\Destroy;


use App\Models\Product;

class DeleteVideoGallery
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product         = $product;
    }

    public function request()
    {
        return $this->request;
    }


    public function destroy()
    {
        // DELETE VIDEO IF EXISTS
        if($this->product->Videos()->exists()){
            $this->product->Videos()->delete();
        }

        return $this->product;
    }
}
