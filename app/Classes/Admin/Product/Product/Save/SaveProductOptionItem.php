<?php


namespace App\Classes\Admin\Product\Product\Save;


use App\Models\ProductOptionItem;

class SaveProductOptionItem
{
    public function __construct($product){

        $this->product               = $product->publish();
        $this->request               = $product->request();
        $this->user                  = $product->user();
        $this->action                = $product->action();

    }

    public function action(){
        return  $this->action;
    }


    public function request(){
        return  $this->request;
    }

    public function user(){
        return  $this->user;
    }

    public function publish(){
        // SAVE IMAGES IN THE GALLERY
        if($this->request['product_option_items']){
            $this->saveOptionItems($this->request['product_option_items']);
        }

        return $this->product;
    }


    //OPTION ITEMS
    protected function saveOptionItems($options){

        // CREATE IMAGES
        foreach($options as $obj) {

            //   CREATE
            if($obj['id'] == "temp"){
                $product_option                     = new ProductOptionItem();
                $this->save_option($product_option , $obj);
                continue;
            }


            // UPDATE
            $product_option = ProductOptionItem::where('product_id', $this->product->id )->where('id', $obj['id'] )->first();
            if($product_option){
                $this->saveOptionDB($product_option , $obj);
            }


        }
    }

    protected function save_option( $product_option ,$obj  ){

        $product_option->option_id         = $obj['option_id'];
        $product_option->title             = $obj['title'];
        $product_option->change_price      = $obj['change_price'];
        $product_option->change_price_type = $obj['change_price_type'];
        $product_option->new_price         = $obj['new_price'];
        $product_option->user_id           = $this->product->user_id;
        $product_option->user_ip           = ip2long($_SERVER['REMOTE_ADDR']);
        $product_option->save();


    }
}
