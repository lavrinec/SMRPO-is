<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at'];

    public function usersRoles()
    {
        return $this->hasMany('App\Models\UsersRole', 'user_id');
    }


    /**
     * Check if the user is an admin user.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->usersRoles->where('role_id', 1)->count() > 0;
    }


    /**
     * Check if the user is product owner.
     *
     * @return bool
     */
    public function isPO()
    {
        return $this->usersRoles->where('role_id', 2)->count() > 0;
    }


    /**
     * Check if the user is a kanban master.
     *
     * @return bool
     */
    public function isKM()
    {
        return $this->usersRoles->where('role_id', 3)->count() > 0;
    }


    /**
     * Check if the user is a developer.
     *
     * @return bool
     */
    public function isDev()
    {
        return $this->usersRoles->where('role_id', 4)->count() > 0;
    }

}
