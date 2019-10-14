<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'name',
        'status'
    ];

    public function scopeDividerActive($query)
    {
        return $query->where('name', 'forecasting-divider')->where('status', 1);
    }
}
