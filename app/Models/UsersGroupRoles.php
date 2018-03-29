<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersGroupRoles extends Model
{
    //use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'group_id', 'is_active'
    ];

    protected $dates = ['deleted_at'];

    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\UsersGroup', 'users_group_id');
    }
}
