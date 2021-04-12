<?php


namespace App\Classes\Admin\Product\Product;


use App\Classes\Utilities\DBStatus;
use App\Models\ProductCategory;
use App\Models\ProductDiscount;
use App\Models\ProductGlobalOption;
use App\Models\ProductManufacture;
use App\Models\ProductSubCategory;

class LoadFormOptions
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
                        'status'               =>  DBStatus::getAll() ,
                        'category'             =>  ProductCategory::pluck('title', 'id')->toArray() ,
                        'sub_category'         =>  ProductSubCategory::pluck('title', 'id')->toArray() ,
                        'discount'             =>  ProductDiscount::pluck('title', 'id')->toArray() ,
                        'manufacture'          =>  ProductManufacture::pluck('title', 'id')->toArray()  ,
                        'global_option'        =>  ProductGlobalOption::pluck('title', 'id')->toArray()
                      ]);

    }

}
