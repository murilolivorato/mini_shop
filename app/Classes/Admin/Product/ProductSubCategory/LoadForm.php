<?php


namespace App\Classes\Admin\Product\ProductSubCategory;


use App\Models\ProductSubCategory;

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
        $productSubCategory = ProductSubCategory::select(['id',   'category_id' , 'title' ,  'meta_tag_description' ,'meta_key_words' , 'user_id'])
                                                      ->where('id' , $id)
                                                      ->first();

        return response()->json([   'id'                      => $productSubCategory->id ,
                                    'title'                   => $productSubCategory->title ,
                                    'category_id'             => $productSubCategory->category_id ,
                                    'meta_tag_description'    => $productSubCategory->meta_tag_description ,
                                    'meta_key_words'          => $productSubCategory->meta_key_words ,
                                    'image'                   => $this->setImageGalleryDisplay($productSubCategory)
                                ]);
    }

    private function setImageGalleryDisplay(ProductSubCategory $product_sub_category){
        // if has image
        if($product_sub_category->Image()->exists()){
            return [
                'id'          => $product_sub_category->Image->id ,
                'image'       => $product_sub_category->Image->image ,
                'title'       => $product_sub_category->Image->title ,
                'description' => $product_sub_category->Image->description

            ];
        }

        return [
            'id'          => "temp" ,
            'image'       => ""
        ];
    }

}
