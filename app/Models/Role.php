<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_name', 'description',
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsToMany('App\Models\Users', 'role_id');
    }
}
