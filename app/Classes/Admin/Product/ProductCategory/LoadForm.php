<?php


namespace App\Classes\Admin\Product\ProductCategory;
use App\Models\ProductCategory;

class LoadForm
{
    protected $request;
    protected $user;


    public static function load($request, $id)
    {

        return (new static)->handle($request, $id );
    }

    private function handle($request, $id )
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
        $productCategory = ProductCategory::select(['id' , 'title' ,  'meta_tag_description' ,'meta_key_words' , 'user_id'])
                                        ->where('id' , $id)
                                        ->first();

        return response()->json([   'id'                      => $productCategory->id ,
                                    'title'                   => $productCategory->title ,
                                    'meta_tag_description'    => $productCategory->meta_tag_description ,
                                    'meta_key_words'          => $productCategory->meta_key_words ,
                                    'image'                   => $this->setImageGalleryDisplay($productCategory)
                                ]);
    }

    private function setImageGalleryDisplay(ProductCategory $product_category){
        // if has image
        if($product_category->Image()->exists()){
            return [
                'id'          => $product_category->Image->id ,
                'image'       => $product_category->Image->image ,
                'title'       => $product_category->Image->title ,
                'description' => $product_category->Image->description

            ];
        }

        return [
            'id'          => "temp" ,
            'image'       => ""
        ];
    }



}
