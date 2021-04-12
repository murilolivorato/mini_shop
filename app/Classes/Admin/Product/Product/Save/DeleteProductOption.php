<?php


namespace App\Classes\Admin\Product\Product\Save;


use App\Models\ProductOption;

class DeleteProductOption
{

    public function __construct($prop){

        $this->prop               = $prop->publish();
        $this->request            = $prop->request();
        $this->user               = $prop->user();
        $this->action             = $prop->action();

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

        $deleted_options = $this->request['deleted_options'];
        // IF HAS DELETED IMAGES , DELETE IT
        if(is_array($deleted_options)){
            if(! empty ($deleted_options)){
                $this->deleteOptions($deleted_options);

            }
        }

        return $this->prop;
    }

    /**********************************************************************************
    DELETE IMAGES
     ***********************************************************************************/
    protected function deleteOptions($options){

        // CREATE IMAGES
        foreach($options as $option_id) {

            $productOption = ProductOption::find($option_id);


            if(! $productOption){
                continue;
            }

            // DELETE OPTION ITEMS
            foreach($productOption->OptionItem as $optionItem) {
                $optionItem->delete();
            }

            //DELETE THE IMAGE FROM DB
            $productOption->delete();

        }
    }
}
