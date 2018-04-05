<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MoveReason extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'move_reason', 'description', 'meta'
    ];

    public function moves()
    {
        return $this->hasMany('App\Models\Move', 'move_reason_id');
    }
}
