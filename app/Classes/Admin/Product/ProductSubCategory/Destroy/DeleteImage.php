<?php


namespace App\Classes\Admin\Product\ProductSubCategory\Destroy;
use App\Models\ProductSubCategory;
use File;

class DeleteImage
{
    protected $productSubCategory;

    public function __construct(ProductSubCategory $productSubCategory){
        $this->productSubCategory            = $productSubCategory;
    }


    public function destroy()
    {
        // DELETE IMAGE IF EXISTS
        if($this->productSubCategory->Image()->exists()){
            File::delete(public_path( $this->productSubCategory->Image->ImagePathUrl));
        }

        return ProductSubCategory::find($this->productSubCategory->id);

    }
}
