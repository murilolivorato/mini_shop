<?php


namespace App\Classes\Admin\Product\ProductSubCategory\Save;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Illuminate\Http\Request;
use App\Models\UserAdmin;
use App\Classes\Helper\SetCharacter;

class SaveProductSubCategory
{
    protected $productSubCategory;
    protected $request;
    protected $action;
    protected $user;


    public function __construct(ProductSubCategory $productSubCategory, Request $request , UserAdmin $user)
    {
        $this->productSubCategory      = $productSubCategory;
        $this->request                 = $request;
        $this->user                    = $user;
        $this->action                  = $this->productSubCategory->exists ? "isUpdating" : "isCreating";
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

        $this->productSubCategory->title                = $this->request['title'];
        $this->productSubCategory->url_title            = SetCharacter::makeUrlTitle($this->request['title']);
        $this->productSubCategory->category_id          = $this->request['category_id'];
        $this->productSubCategory->meta_tag_description = $this->request['meta_tag_description'];
        $this->productSubCategory->meta_key_words       = $this->request['meta_key_words'];
        $this->productSubCategory->user_id              = $this->user->id;
        $this->productSubCategory->user_ip              = ip2long($_SERVER['REMOTE_ADDR']);
        $this->productSubCategory->save();

        return ProductSubCategory::find($this->productSubCategory->id);


    }
}
