<?php


namespace App\Classes\Admin\Product\Product;


use App\Classes\Utilities\ChangePriceType;
use App\Classes\Utilities\DBActionOutStock;
use App\Classes\Utilities\DBHasInStock;
use App\Classes\Utilities\DBRequired;
use App\Classes\Utilities\DBStatus;
use App\Classes\Utilities\DBSubtractInStock;
use App\Models\ProductCategory;
use App\Models\ProductDiscount;
use App\Models\ProductGlobalOption;
use App\Models\ProductManufacture;
use App\Models\ProductSubCategory;
use App\Classes\Utilities\BolleanInfo;
use App\Classes\Utilities\DBHighlightDiscount;
use App\Classes\Utilities\DBProductOffer;
use App\Classes\Utilities\Boolean;
use App\Models\ProductTag;
use Illuminate\Database\Eloquent\Collection;

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
                    ->process()
            ;
    }

    private function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    private function process()
    {
        return response()->json(
            [
                'status'              => DBStatus::getAll(),
                'in_stock'            => DBHasInStock::getAll(),
                'subtract_stock'      => DBSubtractInStock::getAll(),
                'action_out_stock'    => DBActionOutStock::getAll(),
                'required'            => DBRequired::getAll(),
                'product_tag'         =>  ProductTag::select(['id', 'title', 'url_title'])->orderBy('id', 'ASC')->get()  ,
                'change_price_type'   => ChangePriceType::getAll(),
                'category'            => ProductCategory::select(['id', 'title', 'url_title'])->get(),
                'sub_category'        => ProductSubCategory::select(['id', 'title', 'url_title'])->get(),
                'discount'            => self::makePriceCollection(ProductDiscount::select(['id', 'title', 'type_change_price', 'amount_value_discount', 'percentage_discount', 'url_title'])->get()),
                'product_discount'    => ProductDiscount::select(['id', 'title',  'url_title'])->get(),
                'manufacture'         => ProductManufacture::select(['id', 'title', 'url_title'])->get(),
                'global_option'       => ProductGlobalOption::select(['id', 'title', 'url_title'])->get(),
                'bollean_info'        => BolleanInfo::getAll(),
                'bollean'             => Boolean::getAll(),
                'highlight_discount'  => DBHighlightDiscount::getAll(),
                'offer'               => DBProductOffer::getAll() ,

            ]
        );
    }

    private static function makePriceCollection($result)
    {
        $collection = collect($result);

        return $collection->map(
            function ($item, $key) {
                return [
                    'id'                  => $item->id,
                    'title'               => self::makeDiscountTitleCollection($item),
                    'type_change_price'   => $item->type_change_price,
                    'percentage_discount' => $item->percentage_discount,
                    'amount_value'        => $item->amount_value_discount,
                    'url_title'           => $item->url_title
                ];
            }
        );
    }

    private static function makeDiscountTitleCollection($item){
            // PORCENTAGEM
            if($item->type_change_price == "percentage"){
                    return $item->title . '/ ' .$item->percentage_discount . '% de desconto';
            }

            // VALOR EM REAIS
            if($item->type_change_price == "amount_value") {
                return $item->title . '/ R$ '  . $item->amount_value_discount . ' de desconto';
            }

            // FRETE GRÁTIS
            if($item->type_change_price == "free_shipping"){
                return $item->title . '/ ' . "frete grátis";
            }
   }
}
