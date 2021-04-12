<?php


namespace App\Classes\Admin\Product\Product;


use App\Models\ProductSubCategory;

class LoadSubCategory
{
    protected $request;
    protected $user;
    protected $post;


    public static function load($request, $category_id)
    {
        return (new static)->handle($request, $category_id);
    }

    private function handle($request, $category_id)
    {
        return $this->setRequest($request)
                    ->getResult($category_id);
    }

    private function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }


    private function getResult($category_id)
    {
        return [
            'sub_category'                          => ProductSubCategory::where('category_id' , $category_id)->get() ,
        ];
    }
}
