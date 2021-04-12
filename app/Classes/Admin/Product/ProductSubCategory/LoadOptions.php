<?php


namespace App\Classes\Admin\Product\ProductSubCategory;


use App\Models\ProductCategory;

class LoadOptions
{
    protected $request;
    protected $result;


    public static function load($request)
    {
        return (new static)->handle($request);
    }

    private function handle($request)
    {
        return $this->setRequest($request)
                    ->process();
    }

    private function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    private function process()
    {
        return response()->json([
                     'category'             =>  ProductCategory::select(['id', 'title' , 'url_title'])->orderBy('id', 'ASC')->get()  ,
            ]);
    }
}
