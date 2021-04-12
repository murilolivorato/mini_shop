<?php


namespace App\Classes\Admin\Product\Product\Destroy;


use App\Models\ProductOption;

class DeleteProductOptionItems
{
    protected $product;
    protected $request;

    public function __construct($product){
        $this->product         = $product->destroy();
    }

    public function request(){
        return  $this->request;
    }



    public function destroy()
    {
        // IF HAS GALLERY
        if($this->product->ProductOption){
            // CREATE IMAGES
            foreach($this->product->ProductOption as $option) {

          /*      $option = ProductOption::find($option->id);*/
                // DELETE OPTION ITEMS
                foreach($option->OptionItem as $optionItem) {
                    $optionItem->delete();
                }

                // DELETE OPTIONS
                $option->delete();

            }
        }

        return $this->product;
    }


}
