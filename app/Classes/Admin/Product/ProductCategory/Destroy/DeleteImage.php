<?php


namespace App\Classes\Admin\Product\ProductCategory\Destroy;
use App\Models\ProductCategory;
use File;

class DeleteImage
{
    protected $productCategory;

    public function __construct(ProductCategory $productCategory){
            $this->productCategory            = $productCategory;
    }


    public function destroy()
    {

        // DELETE IMAGE IF EXISTS
        if($this->productCategory->Image()->exists()){
            File::delete(public_path( $this->productCategory->Image->ImagePathUrl));
        }


        return ProductCategory::find($this->productCategory->id);

    }
}
