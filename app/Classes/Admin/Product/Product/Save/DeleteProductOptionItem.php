<?php


namespace App\Classes\Admin\Product\Product\Save;


use App\Models\ProductOption;
use App\Models\ProductOptionItem;

class DeleteProductOptionItem
{
    public function __construct($product){

        $this->product            = $product->publish();
        $this->request            = $product->request();
        $this->user               = $product->user();
        $this->action             = $product->action();

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

        $deleted_option_items = $this->request['deleted_option_items'];
        // IF HAS DELETED IMAGES , DELETE IT
        if(is_array($deleted_option_items)){
            if(! empty ($deleted_option_items)){
                $this->deleteOptionItems($deleted_option_items);

            }
        }

        return $this->product;
    }

    /**********************************************************************************
    DELETE IMAGES
     ***********************************************************************************/
    protected function deleteOptionItems($option_items){

        // CREATE IMAGES
        foreach($option_items as $option_item_id) {

            $productOptionItem = ProductOptionItem::find($option_item_id);

            if(! $productOptionItem){
                continue;
            }

            //DELETE THE IMAGE FROM DB
            $productOptionItem->delete();

        }
    }
}
