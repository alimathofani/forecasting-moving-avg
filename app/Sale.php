<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Item;

class Sale extends Model
{
    protected $fillable = [
        'item_id', 
        'price', 
        'qty', 
        'total',
        'date'
    ];

	public function item()
    {
    	return $this->hasOne(Item::class, 'id', 'item_id');
    }
}
