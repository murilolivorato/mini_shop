<?php


namespace App\Classes\Admin\Product\Product\Save;


use App\Models\ProductPrice;

class ProducPrice
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
        if($this->request['price']){

            $this->savePrice($this->request['price']);
        }

        return $this->product;
    }

    //OPTION ITEMS
    protected function savePrice($price){
        if($price['id'] == "temp") {
            $product_price = new ProductPrice();
            $this->save_price($product_price, $price);
            return;
        }

        $product_price =  ProductPrice::where('id', $price['id'] )->first();
        $this->save_price($product_price, $price);

    }

    protected function save_price( $product_price ,$obj  ){

        $product_price->product_id           = $this->product->id;
        $product_price->discount_id          = $obj['discount_id'];
        $product_price->price                = $obj['price'];
        $product_price->old_price	         = $obj['old_price'];
        $product_price->show_old_price       = $obj['show_old_price'];
        $product_price->highlight_discount   = $obj['highlight_discount'];
        $product_price->offer                = $obj['offer'];
        $product_price->user_id              = $this->product->user_id;
        $product_price->user_ip              = ip2long($_SERVER['REMOTE_ADDR']);
        $product_price->save();

    }

}
