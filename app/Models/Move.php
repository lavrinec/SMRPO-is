<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Move extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'old_order', 'old_column_id', 'new_column_id', 'user_id', 'meta'
    ];

    public function old_column()
    {
        return $this->belongsTo('App\Models\Column', 'old_column_id');
    }

    public function new_column()
    {
        return $this->belongsTo('App\Models\Column', 'new_column_id');
    }

    public function card()
    {
        return $this->belongsTo('App\Models\Card', 'card_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function move_reason()
    {
        return $this->belongsTo('App\Models\MoveReason', 'move_reason_id');
    }
}
