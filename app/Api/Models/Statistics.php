<?php
/**
 * Created by PhpStorm.
 * User: adreik
 * Date: 10.05.17
 * Time: 9:45
 */

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;


class Statistics extends Model
{

    /*
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'starus_id',
        'seconds',
        'end'
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

    /**
     * Relation for Status.
     *
     * @param
     * @return
     */
    public function status()
    {
        return $this->belongsToMany('App\Api\Models\UserStatus');
    }

}