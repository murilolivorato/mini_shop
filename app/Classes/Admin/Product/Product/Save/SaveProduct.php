<?php


namespace App\Classes\Admin\Product\Product\Save;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\UserAdmin;
use App\Classes\Helper\SetCharacter;

class SaveProduct
{
    protected $product;
    protected $request;
    protected $action;
    protected $user;


    public function __construct(Product $product, Request $request , UserAdmin $user)
    {
        $this->product            = $product;
        $this->request            = $request;
        $this->user               = $user;
        $this->action             = $this->product->exists ? "update" : "create";
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


        if($this->action == "create"){
            $code = $this->makeTempCode();
            $this->product->code              = $code;
            $this->product->folder            = $code;
        }

        $this->product->title                       = $this->request['title'];
        $this->product->url_title                   = SetCharacter::makeUrlTitle($this->request['title']);
        $this->product->status                      = $this->request['status'];
        $this->product->category_id                 = $this->request['category_id'];
        $this->product->sub_category_id             = $this->request['sub_category_id'];
        $this->product->manufacture_id              = $this->request['manufacture_id'];
        $this->product->title                       = $this->request['title'];
        $this->product->description                 = $this->request['description'];
        $this->product->meta_tag_title              = $this->request['meta_tag_title'];
        $this->product->meta_tag_description        = $this->request['meta_tag_description'];
        $this->product->meta_key_words              = $this->request['meta_key_words'];
        $this->product->number_qty_unity            = $this->request['number_qty_unity'];
        $this->product->min_quantity                = $this->request['min_quantity'];
        $this->product->max_quantity                = $this->request['max_quantity'];
        $this->product->ship_by_company             = $this->request['ship_by_company'];
        $this->product->ship_price                  = $this->request['ship_price'];
        $this->product->dimension_length            = $this->request['dimension_length'];
        $this->product->dimension_width             = $this->request['dimension_width'];
        $this->product->dimension_height            = $this->request['dimension_height'];
        $this->product->weight_unity                = $this->request['weight_unity'];
        $this->product->weight                      = $this->request['weight'];
        $this->product->sku                         = $this->request['sku'];
        $this->product->upc                         = $this->request['upc'];
        $this->product->user_id                     = $this->user->id;
        $this->product->user_ip                     = ip2long($_SERVER['REMOTE_ADDR']);
        $this->product->save();

        return Product::find($this->product->id);


    }

    protected function makeTempCode(){
        return "temp_" . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 8);
    }
}
