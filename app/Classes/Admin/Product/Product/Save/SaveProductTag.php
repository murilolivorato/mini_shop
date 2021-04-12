<?php


namespace App\Classes\Admin\Product\Product\Save;


class SaveProductTag
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
        // attach
        $this->product->ProductTags()->sync($this->request['product_tag_id']);

        return $this->product;
    }
}
