<?php
/**
 * Created by PhpStorm.
 * User: Andrew K.
 * Date: 25.05.17
 * Time: 9:38
 */

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;


class Location extends Model
{
    public function users()
    {
        return $this->hasMany('App\User');
    }
}