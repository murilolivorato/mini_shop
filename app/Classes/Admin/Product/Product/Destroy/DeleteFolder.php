<?php


namespace App\Classes\Admin\Product\Product\Destroy;
use File;

class DeleteFolder
{
    protected $product;
    protected $request;

    public function __construct($product){
        $this->product         = $product->destroy();
        $this->request              = $product->request();
    }

    public function request(){
        return  $this->request;
    }


    public function destroy()
    {
        // DELETE FOLDER
        File::deleteDirectory(public_path($this->product->PathURL));

        return $this->product;
    }
}
