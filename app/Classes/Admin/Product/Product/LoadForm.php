<?php


namespace App\Classes\Admin\Product\Product;
use App\Classes\Helper\SetArrayValue;

use App\Models\Product;
use App\Models\ProductImage;

class LoadForm
{
    protected $request;
    protected $user;
    protected $post;


    public static function load($request, $id)
    {
        return (new static)->handle($request, $id);
    }

    private function handle($request, $id)
    {
        return $this->setRequest($request)
                    ->getResult($id);
    }

    private function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }


    private function getResult($id)
    {
        $product  = Product::select(['id' , 'status' , 'category_id' , 'sub_category_id' , 'manufacture_id' , 'in_stock', 'title' , 'description' , 'meta_tag_title' , 'meta_tag_description' , 'meta_key_words' , 'number_qty_unity' , 'min_quantity' , 'max_quantity' , 'ship_by_company' , 'ship_price' , 'dimension_length' , 'dimension_width' , 'dimension_height' , 'weight_unity' , 'weight' , 'sku' , 'upc' , 'qty_stock' , 'action_out_stock' , 'subtract_stock' , 'out_stock_send_product_days' , 'folder' , 'code' ,  'created_at'])

            ->where('id' , $id )

            // GALLERY IMAGE
            ->with([ 'ImageGallery' => function($query) {
                $query->select('id', 'product_id')
                    // GALLERY TAG
                    ->with([ 'Image' => function($query) {
                        $query->select('id','gallery_id', 'image' , 'title');
                    } ]);
            } ])

            // PRODUCT CATEGORY
            ->with([ 'ProductCategory' => function($query) {
                $query->select('id','title');
            } ])

            // PRODUCT SUB CATEGORY
            ->with([ 'ProductSubCategory' => function($query) {
                $query->select('id','title');
            } ])

            // PRODUCT SUB MANUFACTURE
            ->with([ 'ProductManufactore' => function($query) {
                $query->select('id','title');
            } ])

            // GALLERY TAG
            ->with([ 'ProductTags' => function($query) {
                $query->select('id','title');
            } ])

            // PRODUCT PRICE
            ->with([ 'ProductPrice' => function($query) {
                $query->select('id','product_id' , 'discount_id' , 'price' , 'old_price' , 'show_old_price' , 'highlight_discount' , 'offer' );
              } ])


            // PRODUCT OPTION
            ->with([ 'ProductOption' => function($query) {
                $query->select('id','status' , 'required' , 'product_id' , 'title' , 'url_title' , 'description' , 'user_ip' , 'user_id' )
                    // GALLERY TAG
                      ->with([ 'OptionItem' => function($query) {
                        $query->select('id','option_id' , 'title' , 'url_title' , 'change_price' , 'change_price_type' , 'change_price_value');
                    } ]);
            } ])


            ->first();


        return [
            'id'                          => $product->id,
            'status'                      => $product->status ,
            'category_id'                 => $product->category_id,
            'sub_category_id'             => $product->sub_category_id,
            'manufacture_id'              => $product->manufacture_id,
            'product_tag_id'              => SetArrayValue::returnIds($product->ProductTags) ,
            'title'                       => $product->title,
            'description'                 => $product->description,
            'meta_tag_title'              => $product->meta_tag_title,
            'meta_tag_description'        => $product->meta_tag_description,
            'meta_key_words'              => $product->meta_key_words,
            'number_qty_unity'            => $product->number_qty_unity,
            'min_quantity'                => $product->min_quantity,
            'max_quantity'                => $product->max_quantity,
            'ship_by_company'             => $product->ship_by_company,
            'in_stock'                    => $product->in_stock,
            'ship_price'                  => $product->ship_price,
            'dimension_length'            => $product->dimension_length,
            'dimension_width'             => $product->dimension_width,
            'dimension_height'            => $product->dimension_height,
            'weight_unity'                => $product->weight_unity,
            'weight'                      => $product->weight,
            'sku'                         => $product->sku,
            'upc'                         => $product->upc,
            'qty_stock'                   => $product->qty_stock,
            'action_out_stock'            => $product->action_out_stock,
            'subtract_stock'              => $product->subtract_stock,
            'out_stock_send_product_days' => $product->out_stock_send_product_days,
            'folder'                      => $product->folder,
            'code'                        => $product->code,
            'options'                     => $this->setProductOptionDisplay($product->ProductOption) ,
            'images'                      => $this->setImageGalleryDisplay($product->ImageGallery->id) ,
            'price'                       => $this->setPriceDisplay($product->ProductPrice) ,
            'video_gallery'               => $this->setVideoDisplay($product->Videos)

        ];

    }


    protected function setVideoDisplay($videos){
        $collection =  collect($videos);
        return  $collection->map(function ($item, $key) {
            return [
                    'id'                => $item->id ,
                    'video_website_id'  => $item->video_website_id ,
                    'title'             => $item->title ,
                    'description'       => $item->description ,
                    'reference'         => $item->reference
                ];
        });

    }

    protected function setProductOptionDisplay($option){

        $collection =  collect($option);

        return  $collection->map(function ($item, $key) {
            return [
                'id'           => $item->id ,
                'status'       => $item->status,
                'required'     => $item->required,
                'product_id'   => $item->product_id,
                'title'        => $item->title,
                'url_title'    => $item->url_title,
                'description'  => $item->description,
                'option_items' => self::setProductOptionItemDisplay($item->OptionItem)
            ];
        });

    }

    protected static function setProductOptionItemDisplay($option_item){
        return $option_item;
        $collection =  collect($option_item);

        return  $collection->map(function ($item, $key) {
            return [
                'id'                 => $item->id,
                'option_id'          => $item->option_id,
                'title'              => $item->title,
                'url_title'          => $item->url_title,
                'change_price'       => $item->change_price,
                'change_price_type'  => $item->change_price_type,
                'change_price_value' => $item->change_price_value
            ];
        });
    }

    protected function setImageGalleryDisplay($galleryId){


        $imageGallery = ProductImage::select('id' , 'image' , 'title' ,'order')
                                    ->where('gallery_id' , $galleryId)->orderBy('order')->get();

        $collection =  collect($imageGallery);


        return  $collection->map(function ($item, $key) {
            return [
                'id'          => $item->id,
                'image'       => $item->image,
                'title'       => $item->title ,
            ];
        });

       /* $collection =  collect($imageGallery);


        $data =  $collection->map(function ($item, $key) {
            return [
                'id'          => $item->id,
                'image'       => $item->image,
                'title'       => $item->title ,
                'order'       => $item->order
            ];
        });

        return $data->sortBy('order');*/



    }

    protected function setPriceDisplay($item){
        return [
            'id'                 => $item->id,
            'product_id'         => $item->product_id,
            'discount_id'        => $item->discount_id,
            'price'              => $item->price,
            'old_price'          => $item->old_price,
            'show_old_price'     => SetArrayValue::convertBooleanValue($item->show_old_price),
            'highlight_discount' => $item->highlight_discount,
            'offer'              => $item->offer
        ];
    }
}
