<?php


namespace App\Classes\Admin\Product\ProductSubCategory\Destroy;
class DestroyProductSubCategory
{
    protected $productSubCategory;

    public function __construct($productSubCategory)
    {
        $this->productSubCategory       = $productSubCategory->destroy();
    }

    public function destroy()
    {
        // DELETE ASSOCIATED
        $this->productSubCategory->delete();

        return true;
    }
}
