<?php

namespace App;

use File;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use MongoDB\BSON\Timestamp;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'goal',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $avatarPath = '/storage/avatars';

    /*
     *   Custome Methods
     */
    public function getAvatarStoragePath()
    {
        return $this->avatarPath . '/' . $this->id;
    }

    public function getAvatarStorageFullPath()
    {
        $path = public_path() . $this->getAvatarStoragePath();
        if(!is_dir($path)) {
            File::makeDirectory($path, 0775, true);
        }
        return $path;
    }

    public function getAvatarAttribute($value)
    {
        if (is_null($value)) {
            return null;
        } else {
            return $this->getAvatarStoragePath() . '/' . $value;
        }
    }

    public function deleteAvatar()
    {
        if (!is_null($this->avatar)) {
            $file = public_path() . $this->avatar;

            if (is_file($file)) {
                unlink($file);
                $this->avatar = null;
            }
        }
        return true;
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function tasks()
    {
        return $this->hasMany('App\Models\Task', 'assigneTo_id', 'id');
    }

    public function createdTasks()
    {
        return $this->hasMany('App\Models\Task', 'createdBy_id', 'id');
    }

    public function isAdmin()
    {
        if ($this->role->title === 'role_admin') {
            return true;
        } else {
            return false;
        }
    }

    public function userStatus()
    {
        return $this->belongsToMany('App\Models\UserStatus', 'user_status_changing')->withTimestamps();
    }

    public function getStatus()
    {
        return $this->userStatus->last();
    }


    public function remember_token($token)
    {
       $this->remember_token=$token;
       $this->save();
    }


    public function countTime()
    {
       $data = $this->userStatus->all();
       $result = [];
       $tempdata = [];

       foreach($data as $row) {
           $tempdata[] = [$row->id=>$row->pivot->created_at];
       }

       for ($i=0; $i<count($tempdata)-1; $i++) {
           //dd(array_first($tempdata[$i+1])->timestamp);
           if (isset($tempdata[$i+1])) {
               $timestamp0 = array_first($tempdata[$i])->timestamp;
               $timestamp1 = array_first($tempdata[$i+1])->timestamp;

               $statusId = array_search(array_first($tempdata[$i]), $tempdata[ $i ]);

               $result[] = [$statusId=>$timestamp1 - $timestamp0];
           } else {
               $timestamp0 = array_first($tempdata[$i])->timestamp;

               $statusId = array_search(array_first($tempdata[$i]), $tempdata[ $i ]);
               $result[] = [$statusId=> time() - $timestamp0];
           }
       }
       dd($result);
       return $result;
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->attributes['id'];
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }
}
