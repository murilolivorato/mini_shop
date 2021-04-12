<?php

namespace App\Models;

use App\Http\Controllers\Traits\UserAdminTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use UserAdminTable;
    use HasFactory;

    protected $table    =  'product_images';
    protected $guarded  = ['id' , 'created_at' , 'updated_at'];
    protected $fillable = [
        'gallery_id',
        'image',
        'order' ,
        'title',

        'user_id' ,
        'user_ip'

    ];

    /**********************************************************************************
    RELATIONS
     ***********************************************************************************/

    public function gallery(){
        return $this->belongsTo(ProductImageGallery::class , 'gallery_id' );
    }

    /**********************************************************************************
    VERIFY EXISTS
     ***********************************************************************************/
    public static function verifyFileExists($image_name , $gallery_id) {

        return static::where('product_gallery_img_id', $gallery_id )->where('image', $image_name )->first();
    }




    /* GET IMAGE AND FILE PATH  */
    public function getImageUrlPathAttribute(){
        return $this->gallery->PathGallery."/".$this->image;
    }

    public function getImageThumbUrlAttribute(){
        return $this->gallery->PathGallery."/".makeThumbName($this->image);
    }


}
