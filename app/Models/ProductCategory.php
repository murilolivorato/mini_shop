<?php

namespace App\Models;

use App\Http\Controllers\Traits\UserAdminTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use UserAdminTable;
    use HasFactory;

    protected $table    =  'product_categories';
    protected $guarded  = ['id' , 'created_at' , 'updated_at'];
    protected $fillable = [
        'title',
        'url_title' ,
        'meta_tag_description' ,
        'meta_key_words' ,

        'user_id' ,
        'user_ip'

    ];

    // RELATION SHIP
    public function Products()
    {
        return $this->hasMany(Product::class , 'category_id' );
    }

    public function SubCategory()
    {
        return $this->hasMany(ProductSubCategory::class , 'category_id' );
    }


    public function Image() {
        return $this->hasOne(ProductCategoryImage::class , 'category_id');
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
        return "/assets/arquivos/product_category";
    }

    public function getPathURLTempAttribute()
    {
        return "/assets/temp";
    }
}


