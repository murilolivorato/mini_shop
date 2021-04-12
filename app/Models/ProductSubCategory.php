<?php

namespace App\Models;

use App\Http\Controllers\Traits\UserAdminTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSubCategory extends Model
{
    use UserAdminTable;
    use HasFactory;

    protected $table    =  'product_sub_categories';
    protected $guarded  = ['id' , 'created_at' , 'updated_at'];
    protected $fillable = [
        'category_id' ,
        'title',
        'url_title' ,
        'meta_tag_description' ,
        'meta_key_words' ,

        'user_ip' ,
        'user_id'
    ];

    // RELATION SHIP
    public function Products()
    {
        return $this->hasMany(Product::class , 'sub_category_id' );
    }

    public function ProductsCategory()
    {
        return $this->belongsTo(ProductCategory::class , 'category_id' );
    }


    public function Image() {
        return $this->hasOne(ProductSubCategoryImage::class , 'sub_category_id');
    }


    /**********************************************************************************
    VERIFY EXISTS IMAGE
     ***********************************************************************************/
    public function getimageExistsAttribute(){

        return count($this->Image) ? true : false;
    }

    /**********************************************************************************
    PATH URL
     ***********************************************************************************/
    public function getPathURLAttribute()
    {
        return "/assets/arquivos/product_sub_category";
    }

    public function getPathURLTempAttribute()
    {
        return "/assets/temp";
    }


}

