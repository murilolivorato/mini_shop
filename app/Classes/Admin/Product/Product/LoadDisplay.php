<?php


namespace App\Classes\Admin\Product\Product;

use App\Classes\Helper\SetQuery;
use App\Models\Product;


class LoadDisplay
{
    protected $request;
    protected $user;
    protected $paginateNumber = 20;
    protected $page = null;


    public static function load($request){

        return   (new static)->handle($request);
    }

    private function handle($request){
        return   $this->setRequest($request)
                      ->processQuery();
    }

    private function setRequest($request){

        $this->request = $request;
        return $this;
    }


    // PROCESSING FORM
    public function processQuery()
    {
        $title                 = $this->request->input('title');
        $category_id           = $this->request->input('category');
        $sub_category_id       = $this->request->input('sub_category');
        $in_stock_id           = $this->request->input('in_stock');
        $product_tag_id        = $this->request->input('product_tag');
        $product_discount      = $this->request->input('product_discount');
        $manufacture           = $this->request->input('manufacture');

        $result  = Product::select([ 'id' , 'status', 'category_id' , 'sub_category_id' , 'manufacture_id' , 'in_stock' , 'title' , 'description' , 'meta_tag_title' , 'meta_tag_description' , 'meta_key_words' , 'number_qty_unity' , 'min_quantity' , 'max_quantity' , 'ship_by_company' , 'ship_price' , 'dimension_length' , 'dimension_width' , 'dimension_height' , 'weight_unity' , 'weight' , 'sku' , 'upc' , 'qty_stock' , 'action_out_stock' , 'subtract_stock' , 'out_stock_send_product_days' , 'folder' , 'code'  , 'user_id' , 'created_at'])

            // QUANDO NOME
           ->when($title, function ($query) use ($title) {
                return $query->where('title', 'like' , '%' .  $title .'%'  );
            })

            // WHEN HAS CATEGORY ID
            ->when($category_id , function ($query) use ($category_id) {
                return $query->whereIn('category_id' , SetQuery::convertArray($category_id ));
            })

            // WHEN HAS SUB CATEGORY ID
            ->when($sub_category_id , function ($query) use ($sub_category_id) {
                return $query->whereIn('sub_category_id' , SetQuery::convertArray($sub_category_id ));
            })

            // WHEN HAS SUB CATEGORY ID
            ->when($in_stock_id , function ($query) use ($in_stock_id) {
                return $query->whereIn('in_stock' , SetQuery::convertArray($in_stock_id ));
            })

            // MANUFACTORY ID
            ->when($manufacture , function ($query) use ($manufacture) {
                return $query->whereIn('manufacture_id' , SetQuery::convertArray($manufacture ));
            })

            // WHEN HAS POST USER
            ->when($product_tag_id , function ($query) use ($product_tag_id) {
                // HAS NO DISTANCE
                $query->whereHas('ProductTags', function ($query) use ($product_tag_id) {
                    return $query->whereIn('id', addArrayElement($product_tag_id));
                });
            })

            // PRODUCT CATEGORY
            ->with([ 'ProductCategory' => function($query) {
                $query->select('id','title');
            } ])

            // PRODUCT SUB CATEGORY
            ->with([ 'ProductSubCategory' => function($query) {
                $query->select('id','title');
            } ])

            // PRODUCT MANUFACTORY
            ->with([ 'ProductManufactore' => function($query) {
                $query->select('id','title');
            } ])

            // PRODUCT DISCOUNT
            ->with([ 'ProductPrice' => function($query) {
                $query->select('id',  'product_id' , 'discount_id' , 'price' , 'old_price' , 'show_old_price' , 'highlight_discount' )
                // HAS NO DISTANCE
                ->whereHas('ProductDiscount', function ($query)  {
                    $query->select('id','title');
                });
            } ])


            // GALLERY OPTIONS
            ->with([ 'ProductOption' => function($query) {
                $query->select('id', 'product_id' ,'title' , 'required')
                    // HAS NO DISTANCE
                      ->with('OptionItem', function ($query)  {
                        return $query->select('id',  'option_id' ,  'title' , 'url_title' , 'change_price' , 'change_price_type' , 'change_price_value' );
                    });
            } ])

                    // GALLERY IMAGE
            ->with([ 'ImageGallery' => function($query) {
                $query->select('id', 'product_id')
                   // HAS NO DISTANCE
                      ->with('MainImage', function ($query)  {
                        return $query->select('id', 'gallery_id', 'image',   'title', 'order');
                    });
            } ])



            // GALLERY OPTIONS
            ->with([ 'ProductTags' => function($query) {
                $query->select('id','title');
            } ])


           ->orderBy('created_at', 'DESC')
           ->paginate($this->paginateNumber , ['*'], 'page', $this->page );


        return  [
            'pagination' => [
                'total'         => $result->total(),
                'per_page'      => $result->perPage(),
                'current_page'  => $result->currentPage(),
                'last_page'     => $result->lastPage(),
                'from'          => $result->firstItem(),
                'to'            => $result->lastItem()
            ],
            'data'             => self::makeCollection($result->items())
        ];




    }

    protected static function makeCollection($result){

        $collection =  collect($result);

        return  $collection->map(function ($item, $key) {
            return [
                'id'                   => $item->id,
                'status'               => $item->status,
                'title'                => $item->title,
                'product_category'     => $item->productCategory ? $item->productCategory->title : null ,
                'product_manufactore'  => $item->productManufactore ? $item->productManufactore->title : null ,
                'product_price'        => $item->productPrice,
                'product_option'       => $item->ProductOption ,
                'product_sub_category' => $item->productSubCategory ? $item->productSubCategory->title : null,
                'image'                => self::makeImageCollection($item->imageGallery) ,
                'folder'               => $item->folder
            ];
        });
    }

    protected static function makeImageCollection($imageGallery){
        if(! $imageGallery){
            return null;
        }

        if(! $imageGallery->mainImage){
            return null;
        }

        return $imageGallery->mainImage->image;

    }


}
