<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdminProfileImage extends Model
{
    use HasFactory;
    protected $table = 'user_admin_profile_images';
    protected $guarded  = ['id' , 'created_at' , 'updated_at'];
    protected $fillable = [
        'image',

        'user_admin_id' ,
        'user_id' ,
        'user_ip'
    ];


    public function User() {
        return $this->belongsTo(UserAdmin::class  , 'user_admin_id');
    }

    public function getImagePathUrlAttribute(){

        /* $this->setImage(); */
        return  $this->User->PathURL ."/".$this->image;
    }
}
