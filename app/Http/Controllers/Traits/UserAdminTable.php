<?php


namespace App\Http\Controllers\Traits;
use App\Models\UserAdmin;

trait UserAdminTable
{
    public function ownedBy(UserAdmin $user) {
        return $this->user_id == $user->id;
    }

    public function User() {
        return $this->belongsTo(UserAdmin::class, 'user_id');
    }
}
