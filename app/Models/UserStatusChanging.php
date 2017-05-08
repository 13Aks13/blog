<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStatusChanging extends Model
{

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    public function userstatus()
    {
        return $this->hasMany('App\Models\UserStatus');
    }

}