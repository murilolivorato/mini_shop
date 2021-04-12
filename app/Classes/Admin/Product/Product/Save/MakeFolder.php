<?php


namespace App\Classes\Admin\Product\Product\Save;

use App\Classes\Helper\Hash;
use File;

class MakeFolder
{
    protected $product;
    protected $request;
    protected $user;
    protected $action;

    public function __construct($product){
        $this->product        = $product->publish();
        $this->request        = $product->request();
        $this->user           = $product->user();
        $this->action         = $product->action();
    }

    public function request(){
        return  $this->request;
    }

    public function user(){
        return  $this->user;
    }

    public function action(){
        return  $this->action;
    }

    public function publish()
    {
        // IS NOT UPDATING
        if($this->action == "create"){
            $this->create_folder();
        }

        return $this->product;

    }

    protected function create_folder(){
        // IF IS EMPTY FOLDER
        $code = Hash::folder($this->product->id);
        $this->product->folder            = $code;
        $this->product->code              = $code;
        $this->product->save();

        $this->makeFolderDirectory($this->product->PathURL);
    }

    // CREATE ACTION
    protected function makeFolderDirectory($folder_path_url){
        // create directory
        File::makeDirectory( public_path($folder_path_url) , 0755, true);
    }
}
