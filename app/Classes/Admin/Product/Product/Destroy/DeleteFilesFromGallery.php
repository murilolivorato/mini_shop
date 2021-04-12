<?php


namespace App\Classes\Admin\Product\Product\Destroy;


class DeleteFilesFromGallery
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
        // IF HAS GALLERY
        if($this->product->Images){
            // CREATE IMAGES
            foreach($this->product->Files as $file) {

                // DELETE THUMB FILE
                File::delete(public_path($file->ImageUrl));

                // DELETE DB
                $file->delete();

            }
        }

        return $this->product;
    }
}
