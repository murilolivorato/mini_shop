<?php


namespace App\Classes\Admin\Product\Product\Save;
use app\Classes\Helper\SetCharacter;
use App\Models\ProductImageGallery;
use App\Models\ProductOption;

class SaveProductOption
{
    protected $product;
    protected $request;
    protected $gallery;
    protected $user;
    protected $action;

    public function __construct($product){
        $this->product = $product->publish();
        $this->request = $product->request();
        $this->user    = $product->user();
        $this->action  = $product->action();
    }

    public function request(){
        return  $this->request;
    }

    public function options(){
        return $this->gallery;
    }

    public function user(){
        return  $this->user;
    }

    public function action(){
        return  $this->action;
    }

    public function publish()
    {
        // SAVE IMAGES IN THE GALLERY
        if($this->request['options']){
            $this->saveOptions($this->request['options']);
        }

        return $this->product;
    }



    //ImageGallery
    protected function saveOptions($options){

        // CREATE IMAGES
        foreach($options as $obj) {
            //   CREATE
            if($obj['id'] == "temp"){
                $product_option                     = new ProductOption();
                // SAVE OPTION
                $data = $this->save_option($product_option , $obj);
                // SAVE OPTION ITEM
                $this->save_option_item($data , $obj['option_items']);
                continue;
            }


            // UPDATE
            $product_option = ProductOption::where('product_id', $this->product->id )->where('id', $obj['id'] )->first();
            if($product_option){
                // SAVE OPTION
                $data = $this->save_option($product_option , $obj);
                // SAVE OPTION ITEM
                $this->save_option_item($data , $obj['option_items']);
            }

        }

    }

    // SAVE OPTION
    protected function save_option( $product_option ,$obj  ){
        $product_option->product_id         = $this->product->id;
        $product_option->status             = $obj['status'];
        $product_option->required           = $obj['required'];
        $product_option->title              = $obj['title'];
        $product_option->url_title          = SetCharacter::makeUrlTitle($obj['title']);
        $product_option->user_id            = $this->product->user_id;
        $product_option->user_ip            = ip2long($_SERVER['REMOTE_ADDR']);
        $product_option->save();

        return $product_option::find($product_option->id);
    }

    // SAVE OPTION ITEM
    protected function save_option_item($product_option , $obj_items){
        // CREATE IMAGES
        foreach($obj_items as $obj) {

            // create
            if($obj['id'] == "temp"){
                $this->create_option_item($product_option , $obj);
                return;
            }

            // update
            $this->update_option_item($product_option , $obj , $obj['id']);
        }



    }

    // CREATE OPTION ITEM
    protected function create_option_item( $product_option ,$obj){

        $product_option->OptionItem()->create([
                                                  'option_id'          => $product_option->id,
                                                  'title'              => $obj['title'],
                                                  'url_title'          => SetCharacter::makeUrlTitle($obj['title']),
                                                  'change_price'       => $obj['change_price'],
                                                  'change_price_value' => $obj['change_price_value'],
                                                  'change_price_type'  => $obj['change_price_type'],
                                                  'user_id'            => $this->product->user_id,
                                                  'user_ip'            => ip2long($_SERVER['REMOTE_ADDR']),
                                            ]);


    }

    // UPDATE OPTION ITEM
    protected function update_option_item( $product_option ,$obj , $id){

        $product_option->OptionItem()->where('id' , $id)->update([
                                                                     'option_id'          => $obj['option_id'],
                                                                     'title'              => $obj['title'],
                                                                     'url_title'          => SetCharacter::makeUrlTitle($obj['title']),
                                                                     'change_price'       => $obj['change_price'],
                                                                     'change_price_type'  => $obj['change_price_type'],
                                                                     'change_price_value' => $obj['change_price_value'],
                                                                     'user_id'            => $this->product->user_id,
                                                                     'user_ip'            => ip2long($_SERVER['REMOTE_ADDR']),
                                            ]);


    }
}
