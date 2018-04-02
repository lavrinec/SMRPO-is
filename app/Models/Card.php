<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'card_name', 'description', 'column_id', 'meta'
    ];

    public function column()
    {
        return $this->belongsTo('App\Models\Column', 'column_id');
    }

    public function board()
    {
        return $this->column()->first()->board();
    }
}
