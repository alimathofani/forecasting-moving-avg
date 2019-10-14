<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transaction;

class Item extends Model
{
    protected $fillable = [
        'name'
    ];

    public function transactions()
    {
    	return $this->hasMany(Transaction::class)->limit(1);
    }
}
