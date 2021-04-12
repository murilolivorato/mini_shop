<?php


namespace App\Models;
use App\Http\Controllers\Traits\UserAdminTable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdminPasswordReset extends Model
{
    use HasFactory,  UserAdminTable;

    protected $table    =  'user_admin_pass_resets';
    protected $guarded  = ['id' , 'created_at' , 'updated_at'];
    protected $fillable = [
        'user_id',
        'token' ,
        'user_ip'
    ];
}
