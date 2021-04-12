<?php

namespace App\Models;

use App\Http\Controllers\Traits\UserAdminTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImageGallery extends Model
{
    use UserAdminTable;
    use HasFactory;

    protected $table    =  'product_gallery_images';
    protected $guarded  = ['id' , 'created_at' , 'updated_at'];
    protected $fillable = [
        'product_id',
        'user_id' ,
        'user_ip'

    ];

    /**********************************************************************************
    RELATIONS
     ***********************************************************************************/
    public function Image(){
        return $this->hasMany(ProductImage::class , 'gallery_id');
    }


    public function MainImage() {
        return $this->hasOne(ProductImage::class , 'gallery_id');
        /*return $this->belongsToMany(ProductImage::class , 'product_image_mains', 'gallery_id'  , 'image_id');*/
    }

    public function Product(){
        return $this->belongsTo(Product::class , 'product_id' );
    }

    /**********************************************************************************
    GALELRY PATH
     ***********************************************************************************/
    public function getPathGalleryAttribute()
    {
        return  "/assets/fotos/products/" . $this->product->folder;

    }


    /**********************************************************************************
    VERIFY EXISTS GALLERIES
     ***********************************************************************************/
    public function getimageExistsAttribute(){

        return count($this->Image) ? true : false ;
    }

}
