<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ProductCategoryImage extends Model
{
    protected $table    =  'product_category_images';
    protected $guarded  = ['id' , 'created_at' , 'updated_at'];
    protected $fillable = [
        'category_id',
        'image',
        'title',

        'user_id' ,
        'user_ip'

    ];

    // RELATION SHIP
    public function ProductCategory()
    {
        return $this->belongsTo(ProductCategory::class ,'category_id' );
    }

    public function getImagePathUrlAttribute(){
        return $this->ProductCategory->PathURL ."/" . $this->image;;
    }

}
