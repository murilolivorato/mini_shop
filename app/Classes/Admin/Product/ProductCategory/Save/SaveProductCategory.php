<?php


namespace App\Classes\Admin\Product\ProductCategory\Save;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Models\UserAdmin;
use App\Classes\Helper\SetCharacter;

class SaveProductCategory
{
    protected $productCategory;
    protected $request;
    protected $action;
    protected $user;


    public function __construct(ProductCategory $productCategory, Request $request , UserAdmin $user)
    {
        $this->productCategory      = $productCategory;
        $this->request            = $request;
        $this->user               = $user;
        $this->action             = $this->productCategory->exists ? "isUpdating" : "isCreating";
    }

    public function request(){
        return  $this->request;
    }

    public function action(){
        return  $this->action;
    }

    public function user(){
        return  $this->user;
    }


    public function publish(){

        $this->productCategory->title                = $this->request['title'];
        $this->productCategory->url_title            = SetCharacter::makeUrlTitle($this->request['title']);
        $this->productCategory->meta_tag_description = $this->request['meta_tag_description'];
        $this->productCategory->meta_key_words       = $this->request['meta_key_words'];
        $this->productCategory->user_id              = $this->user->id;
        $this->productCategory->user_ip              = ip2long($_SERVER['REMOTE_ADDR']);
        $this->productCategory->save();


        return ProductCategory::find($this->productCategory->id);


    }
}
