<?php


namespace App\Classes\Admin\Product\Product\Destroy;
use App\Models\Product;
use File;

class DeleteImagesFromGallery
{
    protected $product;
    protected $request;

    public function __construct(Product $product){
        $this->product         = $product;
    }


    public function destroy()
    {
        // IF HAS GALLERY

            // CREATE IMAGES
            foreach($this->product->ImageGallery->Image as $image) {


                    // DELETE THUMB FILE
                    File::delete(public_path($image->ImageUrl));

                    // DELETE IMAGE FILE
                    File::delete(public_path($image->ImageThumbUrl));

                    // DELETE DB
                    $image->delete();


            }


        return $this->product;
    }
}
