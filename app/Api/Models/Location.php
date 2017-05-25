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
    /*
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title'
    ];

    /**
     * Relation for User.
     *
     * @param
     * @return
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }


}