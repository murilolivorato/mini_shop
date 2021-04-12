<?php

namespace App\Models;

use App\Http\Controllers\Traits\UserAdminTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use UserAdminTable;
    use HasFactory;

    protected $table    =  'products';
    protected $guarded  = ['id' , 'created_at' , 'updated_at'];
    protected $fillable = [
        'category_id' ,
        'sub_category_id' ,
        'manufacture_id' ,
        'title' ,
        'url_title',
        'description' ,
        'meta_tag_title' ,
        'meta_tag_description' ,
        'meta_key_words' ,
        'number_qty_unity' ,
        'min_quantity' ,
        'max_quantity' ,
        'ship_by_company' ,
        'ship_price' ,
        'dimension_length' ,
        'dimension_width' ,
        'dimension_height' ,
        'weight_unity' ,
        'weight' ,
        'sku' ,
        'upc' ,
        'qty_stock' ,
        'folder' ,
        'code' ,

        'user_id' ,
        'user_ip'
    ];

    // relation
    public function ProductCategory() {

        return $this->belongsTo(ProductCategory::class ,  'category_id');
    }

    public function ProductSubCategory() {

        return $this->belongsTo(ProductSubCategory::class , 'sub_category_id');
    }

    public function ImageGallery(){
        return $this->hasOne(ProductImageGallery::class , 'product_id');
    }


    /**********************************************************************************
    VERIFY IMAGE GALLERIES EXISTS
     ***********************************************************************************/
    public function getimageGalleryExistsAttribute(){

        return $this->ImageGallery ? true : false ;
    }

    public function getimageExistsAttribute(){

        if(! $this->imageGalleryExists){
            return false;
        }else{
            return $this->ImageGallery->imageExists? true : false ;

        }

    }


    /**********************************************************************************
    PATH
     ***********************************************************************************/

    public function getPathURLAttribute()
    {
        return "/assets/arquivos/product/" . $this['folder'];
    }

    public function getPathURLTempAttribute()
    {
        return "/assets/temp";
    }

}


