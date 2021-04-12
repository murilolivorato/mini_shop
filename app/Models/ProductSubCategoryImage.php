<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSubCategoryImage extends Model
{
    use HasFactory;

    protected $table    =  'product_sub_category_images';
    protected $guarded  = ['id' , 'created_at' , 'updated_at'];
    protected $fillable = [
        'sub_category_id',
        'image',
        'title',

        'user_id' ,
        'user_ip'
    ];

    // RELATION SHIP
    public function ProductSubCategory()
    {
        return $this->belongsTo(ProductSubCategory::class ,'sub_category_id' );
    }

    public function getImagePathUrlAttribute(){
        return $this->ProductSubCategory->PathURL ."/" . $this->image;;
    }
}
