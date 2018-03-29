<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use SoftDeletes;

    public function column()
    {
        return $this->belongsTo('App\Models\Column', 'column_id');
    }
}
