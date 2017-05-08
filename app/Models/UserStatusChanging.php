<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStatusChanging extends Model
{
    protected $table = 'user_status_changing';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'status_id',
    ];

    public function users()
    {
        return $this->hasOne('App\Models\User');
    }

    public function userstatus()
    {
        return $this->hasOne('App\Models\UserStatus');
    }

}