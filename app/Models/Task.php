<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'card_id', 'meta', 'task_name', 'description', 'is_finished', 'order', 'estimation'
    ];

    public function card()
    {
        return $this->belongsTo('App\Models\Card', 'card_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
