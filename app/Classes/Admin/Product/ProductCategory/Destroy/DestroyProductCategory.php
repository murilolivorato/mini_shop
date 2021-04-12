<?php


namespace App\Classes\Admin\Product\ProductCategory\Destroy;
use App\Models\ProductCategory;

class DestroyProductCategory
{
    protected $productCategory;
    protected $index;

    public function __construct($productCategory)
    {
        $this->productCategory       = $productCategory->destroy();
    }

    public function index(){
        return  $this->index;
    }

    public function destroy()
    {
        // DELETE ASSOCIATED
        $this->productCategory->delete();

        return true;
    }
}
