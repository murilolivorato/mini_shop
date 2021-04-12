<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class UserAdmin extends Authenticatable
{
    use HasFactory,   Notifiable , HasApiTokens;


    protected $table    =  'user_admins';
    protected $fillable = [
        'status',
        'email',
        'folder'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**********************************************************************************
    ROLES
     ***********************************************************************************/
    public function Roles(){
        return $this->belongsToMany(UserAdminRole::class , 'user_user_admin_roles' , 'user_id' , 'role_id' );
    }


    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->Roles->contains('title', $role);
        }
    }


    public function PasswordReset(){
        return $this->hasOne(UserAdminPasswordReset::class , 'user_id');
    }



    /**********************************************************************************
    TYPE USERS
     ***********************************************************************************/
    public function getisAdminAttribute(){
        return $this->hasRole('admin');
    }

    public function getisPublisherAttribute(){
        return $this->hasRole('publisher');
    }


    /**********************************************************************************
    USER ADMIN INFO
     ***********************************************************************************/

    // EMPRESA
    public function AdminInfo(){
        return $this->hasOne(UserAdminInfo::class, 'user_admin_id');
    }

    /**********************************************************************************
    USER INFORMATIONS
     ***********************************************************************************/
    public function UserInfo($attribute)
    {
        if($this->isAdmin){
            return $this->AdminInfo->{$attribute};
        }
    }

    /**********************************************************************************
    USER INFORMATIONS
     ***********************************************************************************/
    public function ImageProfile() {
        return $this->hasOne(UserAdminProfileImage::class , 'user_admin_id');
    }




    /**********************************************************************************
    PATH URL
     ***********************************************************************************/
    public function getPathURLAttribute()
    {
        return "/assets/arquivos/usuarios";
    }

    public function getPathURLTempAttribute()
    {
        return "/assets/temp";
    }

}
