<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transaction;
use App\Sale;

class Item extends Model
{
    protected $fillable = [
        'name'
    ];

    public function transactions()
    {
    	return $this->hasMany(Transaction::class)->limit(1);
    }

    public function sales()
    {
    	return $this->hasMany(Sale::class);
    }
}
